<?php 
class Morphes_Categoryattr_Model_Source_Sourceattr extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const MAIN = 1;
    const OTHER = 2;
    public function getAllOptions()
    {
        $name='manufacturer';
        $attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter($name)->getFirstItem();
        $attributeId = $attributeInfo->getAttributeId();
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $attributeOptions = $attribute ->getSource()->getAllOptions(false); 
        return $attributeOptions;
        if (is_null($this->_options)) {
            $this->_options = array(
                array(
                    'label' => 'adsf',
                    'value' =>  self::MAIN
                ),
                array(
                    'label' => 'asdf1',
                    'value' =>  self::OTHER
                ),
            );
        }
        return $this->_options;
    }
    
}