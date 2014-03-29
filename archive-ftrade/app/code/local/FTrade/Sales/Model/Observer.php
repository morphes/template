<?php
class FTrade_Sales_Model_Observer
{
    public function addFavoriteCarrierQuote(Varien_Event_Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();

        $request = Mage::app()->getRequest();

        $carrier = strip_tags($request->getParam('favorite_carrier'));

        if(!empty($carrier)){
            $quote->setFavoriteCarrier($carrier);
        }

        return $this;
    }

    public function addFavoriteCarrierOrder(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();

        $carrier = $quote->getFavoriteCarrier();

        if(!empty($carrier)){
            $order->setFavoriteCarrier($carrier);
        }

        return $this;
    }
}
