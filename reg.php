<?php

function auth_key ($uid, $key)
{
	$app_id = 3383435;
    $app_key = 'nOsOmHqHKFrfq2yHjXyK';
    $keys = md5($app_id . '_' . $uid . '_' . $app_key);
    return $key == $keys ? 'ok' : $keys;
}


foreach ($_POST as $key=>$val)
{
   $_POST[$key] = htmlspecialchars(htmlspecialchars(iconv('UTF-8', 'windows-1251', $val), ENT_QUOTES));
} 


$tims = time();
$hash = md5(md5(rand()) . md5($tims));
$sql = mysql_connect("localhost", "user_m1", "ilya1992");
mysql_select_db("basa_m1");
mysql_query('SET NAMES cp1251');
mysql_set_charset('cp1251');

if ($_POST['act'] == 'reg')
{


$user = (int) $_POST['id'];
$ukey = $_POST['key'];
$funkey = auth_key($user, $ukey);
if ($funkey == 'ok')
{
 
 $res = mysql_fetch_assoc(mysql_query("SELECT money,total,time,hash,groupsts FROM `user3` WHERE `vkid` = $user LIMIT 1"));

 if (!$res)
 {
  mysql_query("INSERT INTO `user3` (`vkid`, `time`, `money`, `hash`) VALUES ('$user', '".$tims."', 50, '".$hash."')");
  $many = 50;
  $total = 0;
  $utime = $tims;
 }
 else
 {
  mysql_query("UPDATE user3 SET time = '".$tims."', hash = '".$hash."' WHERE vkid = $user ");
  $many = $res['money'];
  $total = $res['total'];
  $utime = $res['time'];
 }

 
 $piar = mysql_query("SELECT piar_url,piar_uid FROM `piar3` ORDER BY `piar_id` DESC LIMIT 11");
 $list_people = '';
 while ($row = mysql_fetch_array($piar))
 {
  $list_people[] = array('photo' => $row['piar_url'], 'id' => $row['piar_uid']);
 }


 $ml = mysql_query("SELECT msg,sts,hash,mid,aid,id FROM `mn` WHERE uid = $user ORDER BY `id` DESC LIMIT 10");
 $list_ml = '';
 while ($row = mysql_fetch_array($ml))
 {
  if($row['mid'] == 0){
    $msg = substr(iconv('windows-1251', 'UTF-8', $row['msg']), 0, 230);
  }else{
  	$array_list = array('Крут', 'Дружн', 'Весел', 'Зл', 'Идиот', 'Хитр', 'Умн', 'Добр', 'Понимающ');
    $msg = $array_list[$row['mid']];
  }

  if($row['sts'] == 1){
  	$list_ml[] = array('user' => $row['aid'], 'msg' => $msg, 'hash' => $row['hash'], 'mid' => $row['mid'], 'oid' => $row['id']);
  }else{
  	$list_ml[] = array('user' => 0, 'msg' => $msg, 'hash' => $row['hash'], 'mid' => $row['mid'], 'oid' => $row['id']);
  }
  
 }




 $response_json = array('money' => $many, 'total' => $total, 'hash' => $hash, 'box_group' => $res['groupsts'], 'box_time' => array('day' => 1, 'status' => 0), 'piar_list' => $list_people, 'ml_list' => $list_ml);
}
else
{
	$mes = 'au - ' . $funkey . ', uid - ' . $user . ', pkey - ' . $ukey;
	if (mysql_query("INSERT INTO `debugs` (`text`, `sts`) VALUES ('au - ".$funkey.", uid - ".$user.", pkey - ".$ukey."', '1')"))
	{
 	 $response_json = array('error' => $mes);
    }
    else
    {
     $response_json = array('error' => 'skpzdc, bd');
    }
}
die(json_encode($response_json));
}
 elseif ($_POST['act'] == 'send')
{


}
 elseif ($_POST['act'] == 'debugs')
{

	if (mysql_query("INSERT INTO `debugs` (`text`, `sts`) VALUES ('ajax - ".$_POST['msg'].", ap - ".$_POST['mid'].", is - ".$_POST['hk']."', '2')"))
	{
 	 echo 'ok';
    }
    else
    {
     echo 'error';
    }

}
 elseif ($_POST['act'] == 'send_mn')
{
  $type = (int) $_POST['type'];
  $mid = (int) $_POST['mid'];
  $user_id = (int) $_POST['user_id'];
  $funkey = auth_key($mid, $_POST['user_key']);
  if($funkey != 'ok') die(json_encode(array('error' => 'no auth key')));
   $res = mysql_fetch_assoc(mysql_query("SELECT money,hash FROM `user3` WHERE `vkid` = $mid LIMIT 1"));
   if($res['hash'] != $_POST['user_hash']) die(json_encode(array('error' => 'no user hash')));
    if(!mysql_query("INSERT INTO `mn` (`aid`, `uid`, `mid`, `hash`, `msg`) VALUES ('".$mid."', '".$user_id."', '".$type."', '".$_POST['user_hash']."', '".$_POST['msg']."')")) die(json_encode(array('error' => 'no bd')));
    $many_new = $res['money'] + rand(8, 11);
     if(!mysql_query("UPDATE user3 SET hash = '".$hash."', money = $many_new WHERE vkid = $mid ")) die(json_encode(array('error' => 'no money')));
      mysql_query("UPDATE user3 SET total = total + 1 WHERE vkid = $user_id ");
      $resm = array('hash' => $hash, 'money' => $many_new);
      die(json_encode($resm));

     
   
  
}
 elseif ($_POST['act'] == 'balanse')
{

  $uid = (int) $_POST['uid'];
  $key = (int) $_POST['ukey'];
  $funkey = auth_key($uid, $key);
  if($funkey != 'ok') die('no');
  $res = mysql_fetch_assoc(mysql_query("SELECT money FROM `user3` WHERE `vkid` = $uid LIMIT 1"));
  die(json_encode(array('many' => $res['money'])));
}
 elseif ($_POST['act'] == 'add_piar') 
{
 $user = (int) $_POST['id'];
 $ukey = $_POST['key'];
 $photo_url = $_POST['photo'];
 $funkey = auth_key($user, $ukey);
 if ($funkey == 'ok')
 {
   $res = mysql_fetch_assoc(mysql_query("SELECT money FROM `user3` WHERE `vkid` = $user LIMIT 1"));
   if($res['money'] > 1000){
    if(!mysql_query("INSERT INTO `piar3` (`piar_url`, `piar_uid`) VALUES ('$photo_url', '$user')")) die('no');
    $min_money = abs($res['money'] - 2000);
    mysql_query("UPDATE user3 SET money = $min_money WHERE vkid = $user ");
    $piar = mysql_query("SELECT piar_url,piar_uid FROM `piar3` ORDER BY `piar_id` DESC LIMIT 11");
    $list_people = '';
    while ($row = mysql_fetch_array($piar))
    {
     $list_people[] = array('photo' => $row['piar_url'], 'id' => $row['piar_uid']);
    }
    die(json_encode(array('money' => $min_money, 'piar_list' => $list_people)));
   }else{
	die(json_encode(array('error' => 1, 'piar_list' => $list_people)));
   }
 }
 else
 {
	die('no');
 }
}
 elseif ($_POST['act'] == 'ras')
{
 $user = (int) $_POST['mid'];
 $ukey = $_POST['ukey'];
 $funkey = auth_key($user, $ukey);
 if($funkey != 'ok') die(json_encode(array('error' => 1)));
 $id = (int) $_POST['id'];
 $hash = $_POST['hash'];
 $res = mysql_fetch_assoc(mysql_query("SELECT sts,uid,hash,id,mid,aid,msg FROM `mn` WHERE `id` = $id LIMIT 1"));
 if($res['hash'] != $hash && $res['sts'] != 0 && $res['uid'] != $id) die(json_encode(array('error' => 1)));
 $rem = mysql_fetch_assoc(mysql_query("SELECT money FROM `user3` WHERE `vkid` = $user LIMIT 1"));
 if($rem['money'] > 200){
  $min_money = abs($rem['money'] - 200);
  if(!mysql_query("UPDATE mn SET sts = 1 WHERE id = $id ")) die(json_encode(array('error' => 1)));
  mysql_query("UPDATE user3 SET money = $min_money WHERE vkid = $user ");

  if($res['mid'] == 0){
    $msg = substr(iconv('windows-1251', 'UTF-8', $res['msg']), 0, 230);
  }else{
    $array_list = array('Крут', 'Дружн', 'Весел', 'Зл', 'Идиот', 'Хитр', 'Умн', 'Добр', 'Понимающ');
    $msg = $array_list[$res['mid']];
  }


  die(json_encode(array('many' => $min_money, 'info' => array('id' => $res['id'], 'uid' => $res['aid'], 'msg' => $msg, 'mid' => $res['mid']))));
 }else{
  die(json_encode(array('error' => 2)));
 }

} 
 elseif ($_POST['act'] == 'snull')
{
 $user = (int) $_POST['uid'];
 $ukey = $_POST['ukey'];
 $funkey = auth_key($user, $ukey);
 if($funkey != 'ok') die(json_encode(array('error' => 1)));
 mysql_query("UPDATE user3 SET total = 0 WHERE vkid = $user ");
 die(json_encode(array('error' => 0)));
}
 elseif ($_POST['act'] == 'gjoin')
{
 $user = (int) $_POST['uid'];
 $ukey = $_POST['ukey'];
 $funkey = auth_key($user, $ukey);
 if($funkey != 'ok') die(json_encode(array('error' => 1)));
 $res = mysql_fetch_assoc(mysql_query("SELECT groupsts,money FROM `user3` WHERE `vkid` = $user LIMIT 1"));
 if($res['groupsts'] == 0){
  $min_money = abs($res['money'] + 500);
  mysql_query("UPDATE user3 SET groupsts = 1, money = $min_money WHERE vkid = $user ");
  die(json_encode(array('error' => 0, 'money' => $min_money)));
 }else{
  die(json_encode(array('error' => 2)));
 }
}
 elseif ($_POST['act'] == 'show_us') 
{
  $osfd = (int) $_POST['oid'];
  $user = (int) $_POST['id'];
  $ukey = $_POST['key'];
  $funkey = auth_key($user, $ukey);
  if ($funkey == 'ok')
  {
 
   $ml = mysql_query("SELECT msg,sts,hash,mid,aid,id FROM `mn` WHERE uid = '".$osfd."' ORDER BY `id` DESC LIMIT 10");
   $list_ml = '';
   
   while ($row = mysql_fetch_array($ml))
   {
    if($row['mid'] == 0){
    $msg = substr(iconv('windows-1251', 'UTF-8', $row['msg']), 0, 230);
    }else{
      $array_list = array('Крут', 'Дружн', 'Весел', 'Зл', 'Идиот', 'Хитр', 'Умн', 'Добр', 'Понимающ');
      $msg = $array_list[$row['mid']];
    }
   }

    if($row['sts'] == 1){
      $list_ml[] = array('user' => $row['aid'], 'msg' => $msg, 'hash' => $row['hash'], 'mid' => $row['mid'], 'oid' => $row['id']);
    }else{
      $list_ml[] = array('user' => 0, 'msg' => $msg, 'hash' => $row['hash'], 'mid' => $row['mid'], 'oid' => $row['id']);
    }
  
 }
  die();
  $response_json = array('ml_list' => $list_ml);
  echo json_encode($response_json);
}
 elseif ($_POST['act'] == 'show_of') 
{
  $of = (int) $_POST['of'];
  $user = (int) $_POST['id'];
  $ukey = $_POST['key'];
  $funkey = auth_key($user, $ukey);
  if ($funkey == 'ok')
  {
 
   $ml = mysql_query("SELECT msg,sts,hash,mid,aid,id FROM `mn` WHERE uid = '".$user."' ORDER BY `id` DESC $of, LIMIT 10");
   $list_ml = '';
   
   while ($row = mysql_fetch_array($ml))
   {
    if($row['mid'] == 0){
    $msg = substr(iconv('windows-1251', 'UTF-8', $row['msg']), 0, 230);
    }else{
      $array_list = array('Крут', 'Дружн', 'Весел', 'Зл', 'Идиот', 'Хитр', 'Умн', 'Добр', 'Понимающ');
      $msg = $array_list[$row['mid']];
    }
   }

    if($row['sts'] == 1){
      $list_ml[] = array('user' => $row['aid'], 'msg' => $msg, 'hash' => $row['hash'], 'mid' => $row['mid'], 'oid' => $row['id']);
    }else{
      $list_ml[] = array('user' => 0, 'msg' => $msg, 'hash' => $row['hash'], 'mid' => $row['mid'], 'oid' => $row['id']);
    }
  
 }
  die();
  $response_json = array('ml_list' => $list_ml);
  echo json_encode($response_json);
}



 mysql_close($sql);
?>