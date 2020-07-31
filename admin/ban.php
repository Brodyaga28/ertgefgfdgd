<font color="#006400">Пользователь</font><strong><font color="#ff0000">id<?
echo($_POST["id"]);
?></font></strong><font color="#006400">заблокирован!</font>
 
<?
  $viewer_id = $_POST['id'];
  $fp=fopen("ban$viewer_id.txt","a+");
 if ($fp) {
 flock($fp,2);
  fwrite($fp,"1");
 flock($fp,3);
 fclose($fp);
  }
?>
 
<?
  $reason = $_POST['reason'];
  $viewer_id = $_POST['id'];
  $fp=fopen("reason_ban$viewer_id.txt","a+");
 if ($fp) {
 flock($fp,2);
  fwrite($fp,"$reason");
 flock($fp,3);
 fclose($fp);
  }
?>
 
<?
  $fine = $_POST['fine'];
  $viewer_id = $_POST['id'];
  $fp=fopen("fine_ban$viewer_id.txt","a+");
 if ($fp) {
 flock($fp,2);
  fwrite($fp,"$fine");
 flock($fp,3);
 fclose($fp);
  }
?>