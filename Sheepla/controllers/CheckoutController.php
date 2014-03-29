<?php
require_once('Mage/Checkout/controllers/OnepageController.php');

class Orba_Sheepla_CheckoutController extends Mage_Checkout_OnepageController {
    
    public function getPaymentMethodsAction() {
        if ($this->_expireAjax()) {
            return;
        }
        $shipping_method = $this->getRequest()->getParam('shipping_method');
        Mage::getSingleton('checkout/session')->getQuote()->getShippingAddress()->setShippingMethod($shipping_method)->save();
        $html = $this->getLayout()->createBlock('sheepla/checkout_onepage_payment_methods', 'sheepla.payment.methods', array('template' => 'sheepla/payment_methods.phtml'))->toHtml();
        $this->getResponse()->setBody($html);
    }

}