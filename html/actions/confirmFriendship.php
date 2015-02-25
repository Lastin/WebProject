<?php
  require_once "../functions.php";
  session_start();
  if(!isset($_SESSION['member_id']) || !isset($_POST['friend_id']) || $_POST['friend_id'] == ""){
    header("Location: ../index.php");
  }
  $friend_id = sanitiseString($_POST['friend_id']);
  $member_id = $_SESSION['member_id'];
  $requester_id = searchRequests($member_id, $friend_id);
  if($requester_id != $member_id){
    confirmFriendship($member_id, $friend_id);
  }

?>
