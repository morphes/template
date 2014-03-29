<?php
/**
 * @author RUGENTO
 *
 */
class Rugento_Share_Model_Observer
{
    /**
     * @param unknown $event
     * @return Rugento_Share_Model_Observer
     */
    public function fixDescription($event)
    {
        /* @var $xml Varien_Simplexml_Element */
        $xml = $event->getData('xml_offer');
        $xml->attributes()->id = $event->getProduct()->getSku();
        return $this;
    }
}