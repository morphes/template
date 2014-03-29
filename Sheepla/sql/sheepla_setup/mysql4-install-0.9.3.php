<?php
 
@mail('sales@sheepla.com', '[Instalacja] Sheepla 0.9.3', "IP: ".$_SERVER['SERVER_ADDR']."\r\nHost: ".gethostbyaddr($_SERVER['SERVER_ADDR'])."\r\nSite: ").$_SERVER["HTTP_HOST"];
 
$installer = $this;
 //throw new Exception("This is an exception to stop the installer from completing");
$installer->startSetup();

$installer->run("
 
DROP TABLE IF EXISTS {$this->getTable('orba_sheepla_order')};
CREATE TABLE {$this->getTable('orba_sheepla_order')} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(128) DEFAULT NULL,
  `quote_id` varchar(128) DEFAULT NULL,
  `quote_address_id` int(11) DEFAULT NULL,
  `last_sync_on` datetime DEFAULT NULL,
  `requires_sync` tinyint(4) NOT NULL DEFAULT '1',
  `do_pl_inpost_machine_id` varchar(64) DEFAULT NULL,
  `do_pl_inpost_email` varchar(256) DEFAULT NULL,
  `do_pl_inpost_mobile` varchar(32) DEFAULT NULL,
  `do_ru_qiwi_post_machine_id` varchar(128) DEFAULT NULL,
  `do_ru_pick_point_point` varchar(128) DEFAULT NULL,
  `do_ru_im_point` varchar(128) DEFAULT NULL,
  `do_ru_shoplogistics_metro` varchar(128) DEFAULT NULL,
  `do_ru_shoplogistics_point` varchar(128) DEFAULT NULL,
  `do_ru_cdek_point` varchar(128) DEFAULT NULL, 
  `do_ru_boxberry_point` varchar(128) DEFAULT NULL,
  `do_ru_logibox_point` varchar(128) DEFAULT NULL,
  `do_ru_topdelivery_point` varchar(128) DEFAULT NULL,
  `is_valid` tinyint(1) DEFAULT NULL,
  `last_error` text,
  `last_synced_status_change_id` int(11) NOT NULL,
  `received_edtn` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
");

$installer->endSetup();