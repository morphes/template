<?php

class FTrade_Sales_Model_Order_Address extends Mage_Sales_Model_Order_Address
{
	public function getCompanyDetailsFileUrl()
	{
        $url = Mage::getUrl('customer/address/viewfile', array(
            'file'      => Mage::helper('core')->urlEncode($this->getCompanyDetailsFile()),
        ));

        return $url;
	}
}
