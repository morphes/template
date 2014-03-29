<?php
@mail('magento@orba.pl', '[Upgarde] Sheepla 0.4.2-0.5.0', "IP: ".$_SERVER['SERVER_ADDR']."\r\nHost: ".gethostbyaddr($_SERVER['SERVER_ADDR']));
 
$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE {$this->getTable('orba_sheepla_order')} ADD `quote_address_id` INT NULL AFTER `quote_id`;
");
 
$installer->endSetup();