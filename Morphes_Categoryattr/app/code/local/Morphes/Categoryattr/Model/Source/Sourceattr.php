<?php 
class Morphes_Categoryattr_Model_Source_Sourceattr extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const MAIN = 1;
    const OTHER = 2;
    public function getAllOptions()
    {
        $name='brends';
        $attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter($name)->getFirstItem();
        $attributes = Mage::getResourceModel('eav/entity_attribute_collection')->getData();
        $result = array();
        foreach($attributes as $attr) {
            if($attr['source_model']=='eav/entity_attribute_source_table') {
                $result[] = $attr;
            }
        }
        $this->_options = array();
        $this->_options['0'] = array(
                'label' => '',
                'value' => ''
            );
        foreach($result as $res) {
            $this->_options[] = array(
                'label' => $res['frontend_label'],
                'value' => $res['attribute_code']
            );
        }        
        return $this->_options;
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