<?php
@mail('magento@orba.pl', '[Upgarde] Sheepla 0.2.9-0.3.0', "IP: ".$_SERVER['SERVER_ADDR']."\r\nHost: ".gethostbyaddr($_SERVER['SERVER_ADDR']));
 
$installer = $this;
 //throw new Exception("This is an exception to stop the installer from completing");
$installer->startSetup();
 
$installer->run("

ALTER TABLE  {$this->getTable('orba_sheepla_order')} ADD  `do_ru_im_point` VARCHAR( 128 ) NULL AFTER  `do_pl_inpost_mobile`;
ALTER TABLE  {$this->getTable('orba_sheepla_order')} ADD  `do_ru_pick_point_point` VARCHAR( 128 ) NULL AFTER  `do_pl_inpost_mobile`;

    ");
 
$installer->endSetup();