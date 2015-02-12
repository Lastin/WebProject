<?php
  require_once("../functions.php");
  if(!isset($_POST['user'])) return;
  $username = sanitiseString($_POST['user']);
  return checkUserExists($username);
?>
