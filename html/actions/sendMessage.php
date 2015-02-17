<?php
  require_once "../functions.php";
  session_start();
  if(!isset($_SESSION['member_id']) ||
     !isset($_POST['message']) || $_POST['message'] == ""
     || !isset($_POST['receiver_id']) || $_POST['receiver_id'] == ""){
    header("Location: ../index.php");
  }
  $message = sanitiseString($_POST['message']);
  if(strlen($message) > 4000 || strlen($message) < 1){
    header("Location: ../index.php");
  }
  $receiver_id = sanitiseString($_POST['receiver_id']);
  $member_id = $_SESSION['member_id'];
  if(isFriend($member_id, $receiver_id)){
    $query = "INSERT INTO messages (message, sender_id, receiver_id)
              VALUES (?, ?, ?)";
    $stmt = makeStmt($query);
    $stmt->bind_param("sii", $message, $member_id, $receiver_id);
    $stmt->execute();
    $message_id = $stmt->insert_id;
    if($message_id > 0){
      echo $message_id;
    } else {
      echo -1;
    }
  }

  function validateInput($input){
    $regex = "//"
  }
?>
