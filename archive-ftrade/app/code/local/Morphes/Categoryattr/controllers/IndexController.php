<?php
class Morphes_Categoryattr_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	 $name=$_GET['attr'];
        $attributeInfo = Mage::getResourceModel('eav/entity_attribute_collection')->setCodeFilter($name)->getFirstItem();
        $attributeId = $attributeInfo->getAttributeId();
        $attribute = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
        $attributeOptions = $attribute ->getSource()->getAllOptions(false); 
        echo json_encode($attributeOptions);
        exit();                 
    }

    public function getattrAction()
    {
    	 $name=$_GET['attr'];
    	 $categoryId=$_GET['category'];         		
  		 $_category = Mage::getModel('catalog/category')->load($categoryId);
  		 //var_dump($_category->getManufacturerCategory());

  		 die(var_dump($_category->getValueFilter()));      
    }
}