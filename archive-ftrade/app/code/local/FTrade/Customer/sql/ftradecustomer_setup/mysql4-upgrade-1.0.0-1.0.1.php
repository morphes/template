<?php

/* @var $installer Mage_Customer_Model_Entity_Setup */
$installer = $this;

/* @var $eavConfig Mage_Eav_Model_Config */
$eavConfig = Mage::getSingleton('eav/config');

$store = Mage::app()->getStore(Mage_Core_Model_App::ADMIN_STORE_ID);


$installer->startSetup();

$attributes = array(
    'company_details_file' => array(
        'label' => 'Company details',
        'type' => 'text',
        'input' => 'text',
        'user_defined' => true,
        'visible' => true,
        'required' => false,
    )
);

foreach ($attributes as $attributeCode => $data) {
    $installer->addAttribute('customer_address', $attributeCode, $data);
}

foreach ($attributes as $attributeCode => $data) {
    $attribute = $eavConfig->getAttribute('customer_address', $attributeCode);
    $attribute->setWebsite($store->getWebsite());

    $usedInForms = array(
        'adminhtml_customer_address',
        'customer_address_edit',
        'customer_register_address'
    );
    $attribute->setData('used_in_forms', $usedInForms);

    $attribute->save();
}

$installer->endSetup();
