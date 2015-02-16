<?php
  session_start();
  require_once("../functions");
  if(!isset($_SESSION['member_id']) ||
     !isset($_POST['friend_id']) || $_POST['friend_id']=="" ||
     !isset($_POST['message_id']) || $_POST['message_id']=="" ||
     !isset($_POST['type']) || $_POST['type'] == ""){
       header("Location: ../index.php");
  }
  $friend_id = sanitiseString($_POST['friend_id']);
  $member_id = $_SESSION['member_id'];
  $message_id = sanitiseString($_POST['message_id']);
  $type = sanitiseString($_POST['type']);
  if(isFriend($member_id, $friend_id)){
    $condition = " WHERE ((sender_id = $friend_id AND receiver_id = $member_id)
                  OR (sender_id = $member_id AND receiver_id = $friend_id))";
    $age_condition = "AND message_id < $message_id";
    if($type == "newer"){
      $age_condition = " AND message_id > $message_id";
    }
    $condition .= $age_condition;
    $query = "SELECT * FROM messages" . $condition . " ORDER BY message_id DESC LIMIT 20";
    $results = queryMysql($query);
    $messages = array();
    foreach($results as $result){
      array_push($messages, $result);
    }
    echo json_encode($messages);
  }
?>
