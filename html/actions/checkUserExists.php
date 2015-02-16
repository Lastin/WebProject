<?php
  require_once("../functions.php");
  if(!isset($_POST['username']))
    header("Location: ../index.php");
  $username = sanitiseString($_POST['username']);
  echo checkUserExists($username);
  //example of possible exploit here
?>
