<?php
@mail('magento@orba.pl', '[Upgarde] Sheepla 0.1.5-0.1.7', "IP: ".$_SERVER['SERVER_ADDR']."\r\nHost: ".gethostbyaddr($_SERVER['SERVER_ADDR']));
 
$installer = $this;
 //throw new Exception("This is an exception to stop the installer from completing");
$installer->startSetup();
 
$installer->run("

ALTER TABLE  {$this->getTable('orba_sheepla_order')} CHANGE  `do_pp_id`  `do_pl_inpost_machine_id` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE  {$this->getTable('orba_sheepla_order')} CHANGE  `do_inpost_email`  `do_pl_inpost_email` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE  {$this->getTable('orba_sheepla_order')} CHANGE  `do_inpost_mobile`  `do_pl_inpost_mobile` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE  {$this->getTable('orba_sheepla_order')} ADD  `do_ru_shoplogistics_metro` VARCHAR( 128 ) NULL AFTER  `do_pl_inpost_mobile`;
ALTER TABLE  {$this->getTable('orba_sheepla_order')} CHANGE  `is_valid`  `is_valid` TINYINT( 1 ) NULL DEFAULT NULL;
ALTER TABLE  {$this->getTable('orba_sheepla_order')} CHANGE  `last_error`  `last_error` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL

    ");
 
$installer->endSetup();