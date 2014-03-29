<?php 
$installer = $this;
$installer->startSetup();
 ///asdfasdf
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$setup->addAttribute('catalog_category', 'manufacturer_category', array(
    'type' => 'varchar',      
    'group'     => 'Категория-фильтр',
    'backend' => '',
    'frontend' => '',
    'label' => 'Производитель',
    'input' => 'select',    
    'class' => '',
    'source' => 'categoryattr/source_Sourceattr',  
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
));

$setup->addAttribute('catalog_category', 'enable', array(
    'type' => 'varchar',      
    'group'     => 'Категория-фильтр',
    'backend' => '',
    'frontend' => '',
    'label' => 'Отдельная страница',
    'input' => 'select',    
    'class' => '',
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
));

$installer->endSetup();