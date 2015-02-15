<?php
  require_once "../functions.php";
  session_start();
  if(!isset($_SESSION['member_id']) ||
     !isset($_POST['message']) || $_POST['message'] == ""
     || !isset($_POST['receiver_id']) || $_POST['receiver_id'] == ""){
    header("Location: ../index.php");
  }
  $message = sanitiseString($_POST['message']);
  echo(strlen($message));
  if(strlen($message) > 4000 || strlen($message) < 1){
    header("Location: ../index.php");
  }
  $receiver_id = sanitiseString($_POST['receiver_id']);
  $member_id = $_SESSION['member_id'];
  if(isFriend($member_id, $receiver_id)){
    $query = "INSERT INTO messages (message,sender_id, receiver_id)
              VALUES ('$message','$member_id','$receiver_id')";
    $result = queryMysqlGetInsertId($query);
    if($result > 0){
      echo $result;
    } else
    echo -1;
  }
?>
