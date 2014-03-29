<?php 
$location = array('location' => 'http://pmplatform.tcx.oneagile.ru/webservices.php/user');
$client = new SoapClient('http://pmplatform.tcx.oneagile.ru/webservices.php/user?WSDL', $location); 
$header_input = array(
'project' => 'chester_ru',
    'promo'    => 'somepromo',
    'login'    => 'filmsrv',
    'password' => '65LiFsPfe9m',
    'country' => 'RU',
    'clientIp' => '1.1.1.1'
);
$header = new SoapHeader('http://pmplatform.alt1.ru', 'authorizationHeader', $header_input);
$client->__setSoapHeaders(array($header));

$result = $client->__getFunctions();
echo "<pre>";
print_r($result);
 $result = $client->isBrandActive(
       array(
             'brand_on_market_id' => '2'
             
 ));

var_dump($result);
