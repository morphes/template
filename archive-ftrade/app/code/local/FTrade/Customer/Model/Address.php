<?php

class FTrade_Customer_Model_Address extends Mage_Customer_Model_Address
{
	public function getCompanyDetailsFileUrl()
	{
        $url = Mage::getUrl('customer/address/viewfile', array(
            'file'      => Mage::helper('core')->urlEncode($this->getCompanyDetailsFile()),
        ));

        return $url;
	}
}
