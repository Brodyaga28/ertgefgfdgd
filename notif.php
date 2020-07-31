<?php
header("Content-Type: text/html; charset=utf-8"); 
require 'config.php';

mysql_connect($DBServer,$DBUser,$DBPass);
mysql_select_db($DBName);

$res = mysql_query('SELECT * FROM `'.$table.'`');
$max = floor(mysql_num_rows($res)/100)+1;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Уведомления</title>
	<script type="text/javascript" src="jquery.min.js"></script>
	<style>
	#mess {
	width:400px;
	height:200px;
	}
	#log {
	background:black;
	color:white;
	padding:30px;
	}
	</style>
    <script type="text/javascript">
	function send(text,counter,max) {
	    $.ajax({
		url: 'send.php',
		type: 'POST',
		data: {'text':text,'offset':counter*100},
		success: function(data) {
		    $('#log').append(data+'</br>');
			if(counter < max-1) send(text,counter+1,max);
		}
		});
	}
	</script>
</head>
<body>
<h1>ОТПРАВКА УВЕДОМЛЕНИЙ!</h1>
<input type='textarea' id="mess">
<a href="#" onclick="send($('#mess').val(),0,<?php echo $max; ?>);"><h3>ОТПРАВИТЬ!</h3></a>
</br></br></br></br>
<h4>ЛОГ...</h4>
<div id="log"></div>
</body>
</html>