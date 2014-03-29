<?php

/**
 * Created by ORBA|we-commerce your business -> http://orba.pl
 * 
 */
class Orba_Sheepla_Model_Carrier_Sheepla extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface {

    /**
     * unique internal shipping method identifier
     *
     * @var string [a-z0-9_]
     */
    protected $_code = 'sheepla';
    protected $sheeplaProxyModel;
    protected $sp;

    /**
     * Collect rates for this shipping method based on information in $request
     *
     * @param Mage_Shipping_Model_Rate_Request $data
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request) {

        // skip if not enabled
        if (!Mage::getStoreConfig('carriers/' . $this->_code . '/active')) {
            return false;
        }

        $result = Mage::getModel('shipping/rate_result');
        $packageValue = $request->getBaseCurrency()->convert($request->getPackageValue(), $request->getPackageCurrency());
        $temp = array();

        //get sheepla module config
        $sConfig = Mage::getStoreConfig('sheepla');
        
        //if user is using dynamic pricing
        if ($sConfig['advanced']['use_dynamic_pricing']) {
            //support admin and user checkout
            if (Mage::getSingleton('admin/session')->isLoggedIn()) { //admin
                $quote = Mage::getSingleton('adminhtml/session_quote')->getQuote();
            } else { //user
                $quote = Mage::getSingleton('checkout/session')->getQuote();
            }
            $items = $quote->getAllVisibleItems();
            $address = $quote->getShippingAddress();

            try {
                $this->initSheeplaObjects();
                $dpRates = $this->sp->getClient()->getDynamicPricing($address, $items);
                
                $availableDynamicTemplateIds = array(); 
                foreach ($dpRates as $rate) {
                    $availableDynamicTemplateIds[] = $rate['shipmentTemplateId'];
                }
                
            } catch (Exception $e) {
                $dpRates = false;
                Mage::Log('[Sheepla][' . date('Y-m-d H:i:s') . ']' . $e->getMessage());
            }           
        } else {
            $dpRates = false;
        }
        
        for ($i = 1; $i <= 10; $i++) {
            if ($this->getMethodConfig('allowspecific', $i)) {
                $availableCountries = explode(',', $this->getMethodConfig('specificcountry', $i));
                if (!($availableCountries && in_array($request->getDestCountryId(), $availableCountries))) {
                    continue;
                }
            }

            $shippingName = $this->getMethodConfig('name', $i);
            $shippingPrice = $this->getMethodConfig('price', $i);
            
            if (!empty($shippingName)) {
                
                //if dynamic pricing enabled and method is not at dpRates table, skip this method
                if (is_array($dpRates)) {
                    $shippingTemplateId = $this->getMethodConfig('template_id', $i);
                    if ($shippingTemplateId != '0' && !in_array($shippingTemplateId, $availableDynamicTemplateIds))
                            continue;
                }
               
                $method = Mage::getModel('shipping/rate_result_method');
                $method->setCarrier('sheepla');
                $method->setMethod('method_' . $i);
                $method->setMethodTitle($this->getMethodConfig('name', $i));
                $method->setMethodDetails($this->getMethodConfig('desc', $i));
                $method->setMethodDescription($this->getMethodConfig('desc', $i));
                $method->setPrice(preg_replace('/,/','.',$shippingPrice));
                $method->setCost($this->getMethodConfig('cost', $i));

                if (isset($sConfig['advanced']['custom_label']) && !empty($sConfig['advanced']['custom_label'])) {
                    $method->setCarrierTitle($sConfig['advanced']['custom_label']);
                } else {
                    $method->setCarrierTitle(Mage::helper('sheepla/data')->__('Robust delivery by Sheepla!'));
                }

                //dynamic price calculate
                if ($request->getFreeShipping() === true || $request->getPackageQty() == $this->getFreeBoxes()) {
                    $method->setPrice('0.00');
                } elseif (is_array($dpRates)) {
                    foreach ($sConfig as $k => $v) {
                        if ($method->getMethod() == $k) {
                            foreach ($dpRates as $rule) { 
                                if ($rule['shipmentTemplateId'] == $v['template_id']) {
                                    $method->setPrice($rule['price']);
                                }
                            }
                        }
                    }
                }
                
                $temp[$this->getMethodConfig('sort_order', $i)] = $method;
            }
        }

        foreach ($temp as $m) {
            $result->append($m);
        }
        return $result;
    }

    protected function getMethodConfig($key, $mNo) {

        $cString = "method_{$mNo}/{$key}";
        return Mage::getStoreConfig('sheepla/' . $cString);
    }

    public function getAllowedMethods() {
        return array('sheepla' => $this->getConfigData('name'));
    }

    public function getTrackingInfo($trackingNo) {

        $this->initSheeplaObjects();

        $sd = $this->sp->getClient()->getShipmentDetails($trackingNo);

        $edtn = $sd[0]['edtn'];
        $ctn = $sd[0]['ctn'];
        $carrier = $sd[0]['carrier'];

        $tn = trim($trackingNo);
        if (!empty($ctn)) {
            $tn = $tn . " (Numer przewoźnika {$carrier}: {$ctn})";
        }

        $result = Mage::getModel('shipping/tracking_result');

        $status = Mage::getModel('shipping/tracking_result_status');
        $status->setCarrier('sheepla');
        $status->setCarrierTitle($sd[0]['carrier']);
        $status->setTracking($edtn);
        $status->setPopup(1);

        //tracking url
        $urlBase = 'http://panel.sheepla.pl';
        if ($sd[0]['sender']['countryCode'] == "RU") {
            $urlBase = 'http://panel.sheepla.ru';
        }

        $status->setUrl($urlBase . "/Guest/TrackShipment/" . trim($trackingNo));
        $result->append($status);


        return $status;
    }

    protected function initSheeplaObjects() {

        $this->sheeplaProxyModel = Mage::getModel('sheepla/proxy');
        $this->sp = $this->sheeplaProxyModel->getProxy();
        return $this->sp;
    }

    public function checkAvailableShipCountries(Mage_Shipping_Model_Rate_Request $request) {
        
    }

}