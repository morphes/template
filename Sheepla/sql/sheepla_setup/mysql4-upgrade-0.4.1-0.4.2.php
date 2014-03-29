<?php
@mail('magento@orba.pl', '[Upgarde] Sheepla 0.4.1-0.4.2', "IP: ".$_SERVER['SERVER_ADDR']."\r\nHost: ".gethostbyaddr($_SERVER['SERVER_ADDR']));
 
$installer = $this;
$installer->startSetup();
 
$installer->endSetup();