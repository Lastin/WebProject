<?php
  require_once("../functions.php");
  $username = sanitizeString($_POST['user']);
  $query = "SELECT 1 FROM members WHERE username='$username' LIMIT 1";
  $result = queryMysql($query);
  if(@mysql_num_rows() != 1){
    return false;
  }
  return true;
?>
