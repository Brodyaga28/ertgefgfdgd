<?php
$sql = mysql_connect("localhost", "user_m1", "ilya1992");
mysql_select_db("basa_m1");
mysql_query('SET NAMES cp1251');
mysql_set_charset('cp1251');
$ud = (int) $_POST['receiver_id'];


$secret_key = 'nOsOmHqHKFrfq2yHjXyK'; // Защищенный ключ приложения

$input = $_POST;

// Проверка подписи
$sig = $input['sig'];
unset($input['sig']);
ksort($input);
$str = '';
foreach ($input as $k => $v) {
  $str .= $k.'='.$v;
}

if ($sig != md5($str.$secret_key)) {
  $response['error'] = array(
    'error_code' => 10,
    'error_msg' => 'Несовпадение вычисленной и переданной подписи запроса.',
    'critical' => true
  );
} else {
  // Подпись правильная
  switch ($input['notification_type']) {
    case 'get_item':
      // Получение информации о товаре
      $item = $input['item']; // наименование товара

     if ($item == 'type1') {
        $response['response'] = array(
          'item_id' => 25,
          'title' => 'Купить 1000 монет',
          'photo_url' => 'http://rumnov.ru/a/app6/img/pay_icon.png',
          'price' => 1
        );
      } elseif ($item == 'type2') {
        $response['response'] = array(
          'item_id' => 27,
          'title' => 'Купить 4000 монет',
          'photo_url' => 'http://rumnov.ru/a/app6/img/pay_icon.png',
          'price' => 2
        );
      } elseif ($item == 'type3') {
       $response['response'] = array(
          'item_id' => 27,
          'title' => 'Купить 10 000 монет',
          'photo_url' => 'http://rumnov.ru/a/app6/img/pay_icon.png',
          'price' => 5
        );

      } elseif ($item == 'type4') {

       $response['response'] = array(
          'item_id' => 27,
          'title' => 'Купить 25 000 монет',
          'photo_url' => 'http://rumnov.ru/a/app6/img/pay_icon.png',
          'price' => 10
        );

      } else {
        $response['error'] = array(
          'error_code' => 20,
          'error_msg' => 'Ошибка.',
          'critical' => true
        );
      }
      break;

case 'get_item_test':
      // Получение информации о товаре в тестовом режиме
      $item = $input['item'];
      if ($item == 'type1') {
        $response['response'] = array(
          'item_id' => 25,
          'title' => 'Купить 1000 монет',
          'photo_url' => 'http://rumnov.ru/a/app6/img/pay_icon.png',
          'price' => 1
        );
      } elseif ($item == 'type2') {
        $response['response'] = array(
          'item_id' => 27,
          'title' => 'Купить 4000 монет',
          'photo_url' => 'http://rumnov.ru/a/app6/img/pay_icon.png',
          'price' => 2
        );
      } elseif ($item == 'type3') {
       $response['response'] = array(
          'item_id' => 27,
          'title' => 'Купить 10 000 монет',
          'photo_url' => 'http://rumnov.ru/a/app6/img/pay_icon.png',
          'price' => 5
        );

      } elseif ($item == 'type4') {

       $response['response'] = array(
          'item_id' => 27,
          'title' => 'Купить 25 000 монет',
          'photo_url' => 'http://rumnov.ru/a/app6/img/pay_icon.png',
          'price' => 10
        );

      } else {
        $response['error'] = array(
          'error_code' => 20,
          'error_msg' => 'Ошибка.',
          'critical' => true
        );
      }
      break;

case 'rder_status_change':
      // Изменение статуса заказа
      if ($input['status'] == 'chargeable') {
        

        $order_id = intval($input['order_id']);

// Код проверки товара, включая его стоимость
        $app_order_id = 1; // Получающийся у вас идентификатор заказа.
if($_POST['receiver_id']){
      $item = $input['item'];
      if ($item == 'type1') {
        mysql_query("UPDATE user3 SET money = money + 1000 WHERE vkid = $ud ");
      } elseif ($item == 'type2') {
        mysql_query("UPDATE user3 SET money = money + 4000 WHERE vkid = $ud ");
      } elseif ($item == 'type3') {
        mysql_query("UPDATE user3 SET money = money + 10000 WHERE vkid = $ud ");

      } elseif ($item == 'type4') {
        mysql_query("UPDATE user3 SET money = money + 25000 WHERE vkid = $ud ");
      }

}
$response['response'] = array(
          'order_id' => $order_id,
          'app_order_id' => $app_order_id,
        );
      } else {
        $response['error'] = array(
          'error_code' => 100,
          'error_msg' => 'Передано непонятно что вместо chargeable.',
          'critical' => true
        );
      }
      break;

case 'order_status_change_test':
      // Изменение статуса заказа в тестовом режиме
      if ($input['status'] == 'chargeable') {
        $order_id = intval($input['order_id']);

$app_order_id = 1; // Тут фактического заказа может не быть - тестовый режим.

$response['response'] = array(
          'order_id' => $order_id,
          'app_order_id' => $app_order_id,
        );
if($_POST['receiver_id']){
      $item = $input['item'];
      if ($item == 'type1') {
        mysql_query("UPDATE user3 SET money = money + 1000 WHERE vkid = $ud ");
      } elseif ($item == 'type2') {
        mysql_query("UPDATE user3 SET money = money + 4000 WHERE vkid = $ud ");
      } elseif ($item == 'type3') {
        mysql_query("UPDATE user3 SET money = money + 10000 WHERE vkid = $ud ");

      } elseif ($item == 'type4') {
        mysql_query("UPDATE user3 SET money = money + 25000 WHERE vkid = $ud ");
      }

}
      } else {
        $response['error'] = array(
          'error_code' => 100,
          'error_msg' => 'Передано непонятно что вместо chargeable.',
          'critical' => true
        );
      }
      break;
  }
}
mysql_close($sql);
echo json_encode($response);
?> 