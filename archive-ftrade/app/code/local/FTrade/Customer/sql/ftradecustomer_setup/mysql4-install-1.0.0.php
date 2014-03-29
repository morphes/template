<?php

/* @var $installer Mage_Customer_Model_Entity_Setup */
$installer = $this;

/* @var $eavConfig Mage_Eav_Model_Config */
$eavConfig = Mage::getSingleton('eav/config');

$store = Mage::app()->getStore(Mage_Core_Model_App::ADMIN_STORE_ID);


$installer->startSetup();

$attributes = array(
    'inn' => array(
        'label' => 'INN',
        'type' => 'varchar',
        'input' => 'text',
        'user_defined' => true,
        'visible' => true,
        'required' => false,
    ),
    'kpp' => array(
        'label'         => 'KPP',
        'type' => 'varchar',
        'input' => 'text',
        'user_defined' => true,
        'visible' => true,
        'required' => false,
    ),
    'bank_account' => array(
        'label' => 'Bank Account',
        'type' => 'varchar',
        'input' => 'text',
        'user_defined' => true,
        'visible' => true,
        'required' => false,
    ),
    'bank' => array(
        'label' => 'Bank',
        'type' => 'varchar',
        'input' => 'text',
        'user_defined' => true,
        'visible' => true,
        'required' => false,
    ),
    'c_account' => array(
        'label' => 'Correspondent Account',
        'type' => 'varchar',
        'input' => 'text',
        'user_defined' => true,
        'visible' => true,
        'required' => false,
    ),
    'bik' => array(
        'label' => 'BIK',
        'type' => 'varchar',
        'input' => 'text',
        'user_defined' => true,
        'visible' => true,
        'required' => false,
    ),
    'allocate_nds' => array(
        'label' => 'Allocate NDS in the invoice',
        'type' => 'int',
        'input' => 'select',
        'source' => 'eav/entity_attribute_source_boolean',
        'user_defined' => true,
        'visible' => true,
        'required' => false,
    ),
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
