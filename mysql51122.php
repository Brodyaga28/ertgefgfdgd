<?php
$host = 'localhost';   //Ссылка на базу не трогать
$user = '';       //Имя пользователя
$pswd = '';          //Пороль пользователя
$db = '';       //Название базы

$connect = mysql_connect($host,$user,$pswd); //Коннект к базе данных!

mysql_select_db($db,$connect); //входит в нашу базу данных
?>