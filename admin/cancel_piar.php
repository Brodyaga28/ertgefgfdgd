<?php
header("Content-Type: text/html; charset=utf-8");
require 'init.php';

$login = $_COOKIE['login'];
$login = addslashes($login);
$login = htmlspecialchars($login);
$login = mysql_escape_string($login);

$pass = $_COOKIE['password'];
$pass = addslashes($pass);
$pass = htmlspecialchars($pass);
$pass = mysql_escape_string($pass);

if(!mysql_connect($db_host,$db_user,$db_pass)) exit('Не удалось соединение с базой данных, перезагрузите страницу, пожалуйста');
mysql_select_db($db_name);

if($login == 'admin' and $pass == '258456') {
	$id = $_GET['id'];
	mysql_query("UPDATE `users` SET `piar` = 0 WHERE `uid` = ".$id);
	echo '<script type="text/javascript">';
	echo 'window.location.href="admin.html";';
	echo '</script>';
}
else {
	setcookie("login", "", time()-3600);
	setcookie("password", "", time()-3600);
	exit('Ходи отсюда, пока зубы целы');
}
?>