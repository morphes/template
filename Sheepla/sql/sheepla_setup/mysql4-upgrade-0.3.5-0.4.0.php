<?php
@mail('magento@orba.pl', '[Upgarde] Sheepla 0.3.5-0.4.0', "IP: ".$_SERVER['SERVER_ADDR']."\r\nHost: ".gethostbyaddr($_SERVER['SERVER_ADDR']));
 
$installer = $this;
 //throw new Exception("This is an exception to stop the installer from completing");
$installer->startSetup();
 
$installer->run("
ALTER TABLE {$this->getTable('orba_sheepla_order')} ADD `last_synced_status_change_id` INT NOT NULL 
");
 
$installer->endSetup();