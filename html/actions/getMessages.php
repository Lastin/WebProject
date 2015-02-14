<?php
  session_start();
  require_once("../functions.php");
  if(!isset($_POST['member_id']) ||
     !isset($_POST['friend_id']) || $_POST['friend_id']=="" ||
     !isset($_POST['message_id']) || $_POST['message_id']==""){
    header("Location: ../index.php");
  }

  $friend_id = sanitiseString($_POST['friend_id']);
  $member_id = $_SESSION['member_id'];
  $message_id = sanitiseString($_POST['message_id']);
  if(isFriend($member_id, $friend_id)){
    $query = "SELECT * FROM messages
              WHERE message_id > $message_id
              AND (sender_id = $friend_id AND receiver_id = $member_id
              OR sender_id = $member_id AND receiver_id = $friend_id)
              ORDER BY time DESC LIMIT 10";
    $results = queryMysql($query);
    $messages = array();
    foreach($results as $result){
      array_push($messages, $result);
    }
    echo json_encode($messages);
  }
?>
