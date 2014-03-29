<?php
@mail('magento@orba.pl', '[Upgarde] Sheepla 0.5.2-0.5.3', "IP: ".$_SERVER['SERVER_ADDR']."\r\nHost: ".gethostbyaddr($_SERVER['SERVER_ADDR']));
 
$installer = $this;
 //throw new Exception("This is an exception to stop the installer from completing");
$installer->startSetup();
 
$installer->run("
    ALTER TABLE {$this->getTable('orba_sheepla_order')} ADD `do_ru_qiwi_post_machine_id` VARCHAR( 128 ) NULL AFTER  `do_pl_inpost_mobile`;
");
 
$installer->endSetup();