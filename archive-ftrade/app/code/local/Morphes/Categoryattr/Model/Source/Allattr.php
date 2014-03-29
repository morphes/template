<?php 
class Morphes_Categoryattr_Model_Source_Allattr extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    const MAIN = 1;
    const OTHER = 2;
    public function getAllOptions()
    {        
        $attributes = Mage::getResourceModel('eav/entity_attribute_collection')->getData();
        $result = array();
        foreach($attributes as $attr) {            
            $check_attr = Mage::getModel('catalog/resource_eav_attribute')->load($attr['attribute_id'])->getData(); 
            if(isset($check_attr['is_filterable'])) {
                if($check_attr['is_filterable']=='1') {
                    $result[] = $check_attr;
                }
            }
        }
        $this->_options = array();
        $this->_options['0'] = array(
                'label' => '',
                'value' => ''
            );
                   
        foreach($result as $res) {
            $attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter($res['attribute_code'])->getFirstItem();
            $attributeId = $attributeInfo->getAttributeId();
            $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
            $attributeOptions = $attribute ->getSource()->getAllOptions(false); 
            $this->_options[] = array('label'=>$res['frontend_label'], 'value'=> $attributeOptions );
        }                
        return $this->_options;        
    }
    
}