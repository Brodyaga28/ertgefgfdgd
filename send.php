<?php
header("Content-Type: text/html; charset=utf-8"); 
require ("vkapi.class.php");
 
require 'config.php';

if(isset($_POST['offset']) && $_POST['offset'] != '') $offset = $_POST['offset']; 
else exit('Бля, не сработал скрипт...(');
if(isset($_POST['text']) && $_POST['text'] != '' ) $text = $_POST['text']; 
else exit('Введи бля сообщение');

mysql_connect($DBServer,$DBUser,$DBPass);
mysql_select_db($DBName);

$ids = "";
$count = 0;

$res = mysql_query('SELECT * FROM `'.$table.'` LIMIT '.$offset.',100');
while($row = mysql_fetch_array($res)) {
    if($count !== 99) $ids .= $row[$field].',';
	else $ids .= $row[$field];
	$count++;
}

$VK = new vkapi($APPid, $APPkey);
$res = $VK->api('secure.sendNotification', array('uids' => $ids, 'message' => $text));

if($res['response'] != "") exit('В позиции от '.$offset.' к '.($offset+100).' отправлено им: '.$res['response']);
else exit('В позиции от '.$offset.' к '.($offset+100).' не отправлено никому!'); 
?>