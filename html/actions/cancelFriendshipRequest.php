<?php
  require_once("../functions.php");
  session_start();
  if(!isset($_SESSION['member_id']) || !isset($_POST['friend_id']) || $_POST['friend_id'] == ""){
    header("Location: ../index.php");
  }
  $member_id = $_SESSION['member_id'];
  $friend_id = $_POST['friend_id'];
  $friend_id = sanitiseString($friend_id);
  removeRequest($member_id, $friend_id);
?>
