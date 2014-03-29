<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

echo '
<!DOCTYPE html>
<html>
 <head>
  <title>description</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
 </head> 
 <body>';

echo "<br />Данные из формы: <br /><pre>";
var_dump($_REQUEST);
echo "</pre>";

//подключаем файл с классом CalculatePriceDeliveryCdek
include_once("CalculatePriceDeliveryCdek.php");

try {

    //создаём экземпляр объекта CalculatePriceDeliveryCdek
    $calc = new CalculatePriceDeliveryCdek();

    //Авторизация. Для получения логина/пароля (в т.ч. тестового) обратитесь к разработчикам СДЭК -->
    $calc->setAuth('741a658ed104752ff5a4ba27950ba72b', 'e95869780addf13d9753221b36b7bd00');

    //устанавливаем город-отправитель
    //$calc->setSenderCityId($_REQUEST['senderCityId']);
    $calc->setSenderCityId('44');
    //устанавливаем город-получатель
    //$calc->setReceiverCityId($_REQUEST['receiverCityId']);
    $calc->setReceiverCityId('137');
    //устанавливаем дату планируемой отправки
    //$calc->setDateExecute($_REQUEST['dateExecute']);
    $tarifList = array(
        '0' => '5',
        '1' => '62'
    );
    //устанавливаем тариф по-умолчанию
    $calc->setTariffId('62');
    
    //задаём список тарифов с приоритетами
     $calc->addTariffPriority($tarifList);
    // $calc->addTariffPriority($_REQUEST['tariffList2']);
    //устанавливаем режим доставки
    //$calc->setModeDeliveryId($_REQUEST['modeId']);
    //добавляем места в отправление
    //var_dump($_REQUEST['weight1']);
    //$calc->addGoodsItemBySize($_REQUEST['weight1'], $_REQUEST['length1'], $_REQUEST['width1'], $_REQUEST['height1']);
    $calc->addGoodsItemBySize('70', '115', '40', '61');
    //$calc->addGoodsItemByVolume($_REQUEST['weight2'], $_REQUEST['volume2']);

    if ($calc->calculate() === true) {
        $res = $calc->getResult();
        echo "<pre>";
        print_r($res);
        echo 'Цена доставки: ' . $res['result']['price'] . 'руб.<br />';
        echo 'Срок доставки: ' . $res['result']['deliveryPeriodMin'] . '-' .
        $res['result']['deliveryPeriodMax'] . ' дн.<br />';
        echo 'Планируемая дата доставки: c ' . $res['result']['deliveryDateMin'] . ' по ' . $res['result']['deliveryDateMax'] . '.<br />';
        echo 'id тарифа, по которому произведён расчёт: ' . $res['result']['tariffId'] . '.<br />';
        if (array_key_exists('cashOnDelivery', $res['result'])) {
            echo 'Ограничение оплаты наличными, от (руб): ' . $res['result']['cashOnDelivery'] . '.<br />';
        }
    } else {
        $err = $calc->getError();
        print_r($err);
        if (isset($err['error']) && !empty($err)) {
            //var_dump($err);
            foreach ($err['error'] as $e) {
                echo 'Код ошибки: ' . $e['code'] . '.<br />';
                echo 'Текст ошибки: ' . $e['text'] . '.<br />';
            }
        }
    }

    //раскомментируйте, чтобы просмотреть исходный ответ сервера
    // var_dump($calc->getResult());
    // var_dump($calc->getError());
} catch (Exception $e) {
    echo 'Ошибка: ' . $e->getMessage() . "<br />";
}


echo '
  </body>
</html>
';
?>