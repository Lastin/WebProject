<?php
  require_once("../functions.php");
  if(!isset($_POST['username']))
    return;
  $username = sanitiseString($_POST['username']);
  echo (int)checkUserExists($username);
  //example of possible exploit here
?>
