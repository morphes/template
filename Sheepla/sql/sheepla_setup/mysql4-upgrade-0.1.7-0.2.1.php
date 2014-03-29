<?php

@mail('magento@orba.pl', '[Upgarde] Sheepla 0.1.7 0.2.1', "IP: ".$_SERVER['SERVER_ADDR']."\r\nHost: ".gethostbyaddr($_SERVER['SERVER_ADDR']));
 
$installer = $this;
 //throw new Exception("This is an exception to stop the installer from completing");
$installer->startSetup();
 
$installer->run("
    ");
 
$installer->endSetup();