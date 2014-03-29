<?php

require_once('Sheepla/isheepla_proxy_data_model.interface.php');

class Orba_Sheepla_Model_Data extends Mage_Core_Model_Abstract implements ISheeplaProxyDataModel {

    protected $forceErrors; 
    protected $maxErrors;

    public function _construct() {
        $this->_init('sheepla/data');
        $this->forceErrors = false;
        $this->maxErrors = 3;
    }

    public function setForceErrors($fe) {
        $this->forceErrors = $fe;
    }

    public function getOrders() {
        $o2sync = Mage::getModel('sheepla/order')
                ->getCollection()
                ->addFieldToFilter('requires_sync', array('gt' => 0))
                ->addFieldToFilter('order_id', array('notnull' => true));
                //->addFieldToFilter('order_id', array('gt' => 0));

        return $this->_getOrders($o2sync);
    }

    public function getOrder($order) {
        $o2sync = Mage::getModel('sheepla/order')
                ->getCollection()
                ->addFieldToFilter('requires_sync', array('gt' => 0))
                ->addFieldToFilter('order_id', $order->getIncrementId());
        return $this->_getOrders($o2sync);
    }

    public function getForceOrder($order) {
        $o2sync = Mage::getModel('sheepla/order')
                ->getCollection()
                ->addFieldToFilter('order_id', $order->getIncrementId());

        echo "Get from Sheepla orders table:<br/>";
        Zend_Debug::dump($o2sync->toArray());

        return $this->_getOrders($o2sync);
    }

    public function _getOrders($o2sync) {

        if ($this->forceErrors) {
            $o2sync->setOrder('order_id', 'DESC');
            $o2sync->setPageSize(10);

            echo "Get from Sheepla orders table:<br/>";
            Zend_Debug::dump($o2sync->toArray());
        } else {
            //if forceErrors is diabled then we only send one order $this->maxErrors times
            $o2sync->addFieldToFilter('requires_sync', array('lt' => $this->maxErrors + 1));
        }

        $result = array();
        foreach ($o2sync as $so) {
            $od = $this->prepareOrderData($so);
            if (!is_null($od)) {
                $result[] = $od;
            }
        }
        return $result;
    }

    protected function prepareOrderData($so) {

        $soData = $so->getData();

        $mo = Mage::getModel('sales/order')->loadByIncrementId($soData['order_id']);
        $moData = $mo->getData();

        // if order is deleted from magento or it's not sheepla order (0.7.2 fix)
        if (!count($moData)) {
            $so->delete();
            return null;
        } else {
            $temp = explode('_', $moData['shipping_method']);
            if ($temp[0] != 'sheepla') {
                $so->delete();
                return null;
            }
        }
        
        //check statuses with config
        $sConfgig = Mage::getStoreConfig('sheepla');
        $configStatuses = explode(',',$sConfgig['advanced']['status_to_sync']);
        if (!in_array($moData['status'], $configStatuses)) return null;
        
        $op = $mo->getPayment();

        //prepare detailed items data
        $magentoItems = $mo->getAllVisibleItems();
        $orderItems = array();

        //for each item in order prepare sheepla order item data
        foreach ($magentoItems as $mi) {
            $oi = array();
            $oi['name'] = $mi->getName();
            $oi['sku'] = $mi->getSku();
            $oi['qty'] = $mi->getQtyOrdered();
            $oi['unit'] = 'gram';
            $oi['weight'] = $mi->getWeight() * 1000; // weight in gramms 
            $oi['width'] = $mi->getWidth();
            $oi['height'] = $mi->getHeight();
            $oi['length'] = $mi->getLength();
            $oi['priceGross'] = $mi->getPriceInclTax();
            $oi['ean13'] = $mi->getEan13();
            $oi['ean8'] = $mi->getEan8();
            $oi['issn'] = $mi->getIssn();
            $orderItems[] = $oi;
        }

        if (empty($op)) {
            $opData['method'] = "N/A";
        } else {
            $opData = $op->getData();
        }

        $shaData = $mo->getShippingAddress()->getData();        
        
        //get template data
        $mc = Mage::getStoreConfig("sheepla/{$temp[1]}_{$temp[2]}", $mo->getStoreId());
        $tId = $mc['template_id'];

        //no template assigned - this is not automated sheepla method
        if (!$tId) {
            $so->delete();
            return null;
        }

        $customerId = 'guest';
        if (!empty($moData['customer_id'])) {
            $customerId = $moData['customer_id'];
        }
        
        /* email override from getShippingAddress() if basic magento email doesnt exist */
        $email = $moData['customer_email'];
        if (empty($email)) {
            $email = $shaData['email'];
        }
        
        
        /* get Street and buildingNumber */
        $street = $shaData['street'];
        $buildingNumber = null;
        //if preg is valid replace street and get building number
        if (preg_match("/([\D]+)\s+([0-9]+.*)/", $street,$matches)) {
            if (count($matches) == 3) {
                $street = $matches[1];
                $buildingNumber = $matches[2];
            }
        }
        

        //advanced settings: Provide order comment flag is set
        $comments = null;
        if ($sConfgig['advanced']['comment_order_attach']) {
            $comments = Mage::getModel('sheepla/comment')->getOrderComment($soData['order_id']);
        } elseif (Mage::app()->getRequest()->isPost()) { //set shippment comment during creating shipment
            $post = Mage::app()->getRequest()->getPost();
            $comments = $post['shipment']['comment_text'];
        }
        

        $result = array(
            'orderValue' => $moData['grand_total'], // total order price in float
            'orderValueCurrency' => $moData['base_currency_code'], // ISO formated currency type
            'externalDeliveryTypeId' => $moData['shipping_method'], // shipment id from the shop
            'externalDeliveryTypeName' => $mc['name'], // shipment name from the shop
            'externalPaymentTypeId' => $opData['method'], //todo				// payment type id from the shop
            'externalPaymentTypeName' => $opData['method'], // payment type name from the shop
            'externalCountryId' => $shaData['country_id'], //todo  							// country id from the shop 
            'externalBuyerId' => $customerId, // client id from the shop 
            'externalOrderId' => $moData['increment_id'], // order id from the shop 
            'shipmentTemplate' => $tId, // shipment template id from the sheepla application
            'comments' => $comments, // additional coments about the order 
            'createdOn' => date('c', strtotime($moData['created_at'])),
            'deliveryPrice' => $moData['shipping_amount'],
            'deliveryPriceCurrency' => $moData['base_currency_code'],
            // ISO 8601 date (added in PHP 5) (see http://php.net/manual/en/function.date.php format character 'c') 
            'deliveryOptions' => array(
            ),
            'deliveryAddress' => array(
                'street' => $street, // delivery address street
                'buildingNumber' => $buildingNumber,
                'zipCode' => $shaData['postcode'], // delivery address street
                'city' => $shaData['city'], // delivery address city
                'countryAlpha2Code' => $shaData['country_id'], // the country id from the sheepla (see SheeplaProxyDataModelAbstract)
                'firstName' => $shaData['firstname'], // Recipient first name
                'lastName' => $shaData['lastname'], // Recipient last name
                'companyName' => $shaData['company'], // Recipient company name
                'phone' => $shaData['telephone'], // Recipient phone number
                'email' => $email      // Recipient e-mail addres
            ),
            'orderItems' => $orderItems
        );

        //additional delivery options
        if (!empty($soData['do_pl_inpost_machine_id'])) {
            $result['deliveryOptions']['plInPost']['popName'] = $soData['do_pl_inpost_machine_id'];
        }

        if (!empty($soData['do_ru_shoplogistics_metro'])) {
            $result['deliveryOptions']['ruShopLogistics']['metroStationId'] = $soData['do_ru_shoplogistics_metro'];
        }

        if (!empty($soData['do_ru_im_point'])) {
            $result['deliveryOptions']['ruIMLogistics']['pickupPointCarrierCode'] = $soData['do_ru_im_point'];
        }

        if (!empty($soData['do_ru_pick_point_point'])) {
            $result['deliveryOptions']['ruPickPoint']['pickupPointCarrierCode'] = $soData['do_ru_pick_point_point'];
        }

        if (!empty($soData['do_ru_qiwi_post_machine_id'])) {
            $result['deliveryOptions']['ruQiwiPost']['popName'] = $soData['do_ru_qiwi_post_machine_id'];
        }

        if (!empty($soData['do_ru_shoplogistics_point'])) {
            $result['deliveryOptions']['ruShopLogistics']['metroStationId'] = $soData['do_ru_shoplogistics_point'];
        }
        
        if (!empty($soData['do_ru_cdek_point'])) {
            $result['deliveryOptions']['ruCdek']['popName'] = $soData['do_ru_cdek_point'];
        }
        
        if (!empty($soData['do_ru_cdek_point'])) {
            $result['deliveryOptions']['ruCdek']['popName'] = $soData['do_ru_cdek_point'];
        }
        
        if (!empty($soData['do_ru_boxberry_point'])) {
            $result['deliveryOptions']['ruBoxBerry']['popName'] = $soData['do_ru_boxberry_point'];
        }
        
        if (!empty($soData['do_ru_logibox_point'])) {
            $result['deliveryOptions']['ruLogiBox']['popName'] = $soData['do_ru_logibox_point'];
        }
        
        if (!empty($soData['do_ru_topdelivery_point'])) {
            $result['deliveryOptions']['ruTopDelivery']['popName'] = $soData['do_ru_topdelivery_point'];
        }

        return $result;
    }

    public function getConfig() {
        return array(
            'url' => Mage::helper('sheepla')->getConfigData('sheepla/api_config/api_url'),
            'key' => Mage::helper('sheepla/data')->getAdminApiKey(false),
        );
    }

    public function getPaymentMethods() {
        return null;
    }

    public function getShippingMethods() {
        return null;
    }

}