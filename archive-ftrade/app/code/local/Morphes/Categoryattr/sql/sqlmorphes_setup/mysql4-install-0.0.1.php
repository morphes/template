<?php 
$installer = $this;
$installer->startSetup();
 ///asdfasdf
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$setup->addAttribute('catalog_category', 'is_page', array(
    'type' => 'varchar',      
    'group'     => 'Категория-фильтр',
    'backend' => '',
    'frontend' => '',
    'label' => 'Отдельная страница',
    'input' => 'select',    
    'class' => 'value',
    'source' => 'eav/entity_attribute_source_boolean',  
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => false,
    'default' => '0',       
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'unique' => false,
    'position' => 0
));


// $setup->addAttribute('catalog_category', 'catalog_attr', array(
//     'type' => 'varchar',      
//     'group'     => 'Категория-фильтр',
//     'backend' => '',
//     'frontend' => '',
//     'label' => 'Атрибут',
//     'input' => 'select',    
//     'class' => 'brend',
//     'source' => 'categoryattr/source_Sourceattr',  
//     'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
//     'visible' => true,
//     'required' => false,
//     'user_defined' => false,
//     'default' => '0',       
//     'searchable' => false,
//     'filterable' => false,
//     'comparable' => false,
//     'visible_on_front' => false,
//     'unique' => false,
//     'position' => 1
// ));

$setup->addAttribute('catalog_category', 'catalog_attr_value', array(
    'type' => 'varchar',      
    'group'     => 'Категория-фильтр',
    'backend' => '',
    'frontend' => '',
    'label' => 'Значение атрибута',
    'input' => 'select',    
    'class' => '',
    'source' => 'categoryattr/source_Allattr',  
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => false,
    'default' => '0',       
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'unique' => false,
    'position' => 2
));



$installer->endSetup();