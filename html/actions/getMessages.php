<?php
  session_start();
  require_once("../functions.php");
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
    $condition = " WHERE (
                  (sender_id = ? AND receiver_id = ?) OR
                  (sender_id = ? AND receiver_id = ?))";
    $age_condition = "AND message_id < ?";
    if($type == "newer"){
      $age_condition = " AND message_id > ?";
    }
    $condition .= $age_condition;
    $query = "SELECT * FROM messages" . $condition . " ORDER BY message_id DESC LIMIT 20";

    $messages = array();
    $stmt = makeStmt($query);
    $stmt->bind_param("iiiii", $member_id, $friend_id, $friend_id, $member_id, $message_id);
    $stmt->bind_result($message_id, $sender_id, $receiver_id, $time, $content, $isread);
    $stmt->execute();
    while($stmt->fetch()){
      $message = array(
        "message" => $content,
        "message_id" => $message_id,
        "sender_id" => $sender_id
      );
      array_push($messages, $message);
    }
    echo json_encode($messages);
  }
?>
