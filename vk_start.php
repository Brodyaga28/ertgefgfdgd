<?php
$api_url = $_GET['api_url'];
$api_id = $_GET['api_id'];
$api_settings = $_GET['api_settings'];
$viewer_id = $_GET['viewer_id'];
$viewer_type = $_GET['viewer_type'];
$sid = $_GET['sid'];
$user_id = $_GET['user_id'];
$group_id = $_GET['group_id'];
$is_app_user = $_GET['is_app_user'];
$auth_key = $_GET['auth_key'];
if(substr_count(@file_get_contents("ban$viewer_id.txt"), '1'))  {
echo("
<script type='text/javascript' charset='cp1251' >
location.replace('ban_inf.php?viewer_id=$viewer_id&auth_key=$auth_key');
</script>");
}
else
{
echo("
<script type='text/javascript' charset='cp1251' >
location.replace('http://www.h5132.ptzhost.net/app/index.php?api_url=$api_url&api_id=$api_id&api_settings=$api_settings&viewer_id=$viewer_id&viewer_type=$viewer_type&sid=$sid&user_id=$user_id&group_id=$group_id&is_app_user=$is_app_user&auth_key=$auth_key');
</script>");
}
?>