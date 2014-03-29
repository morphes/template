<?php
class FTrade_OrderComment_Model_Observer
{
    /**
     * Add a customer order comment when the order is placed.
     * Listen "checkout_type_onepage_save_order" event
     *
     * @param Varien_Event_Observer $observer
     * @return FTrade_OrderComments_Model_Observer
     */
    public function addOrderComment(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $request = Mage::app()->getRequest();

        $comments = strip_tags($request->getParam('customer_comment'));

        if(!empty($comments)){
            $order->setCustomerNote($comments);
        }

        return $this;
    }
}
