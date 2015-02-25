<?php
  require_once("../functions.php");
  session_start();
  if(!isset($_SESSION['member_id']) || !isset($_POST['friend_id']) || $_POST['friend_id'] == ""){
    header("Location: ../index.php");
  }

  $friend_id = $_POST['friend_id'];
  $friend_id = sanitiseString($friend_id);
  $member_id = $_SESSION['member_id'];

  if(!isFriend($member_id, $friend_id)){
    $requester_id = searchRequests($member_id, $friend_id);
    if($requester_id == 0){
      requestFriendship();
      echo 1;
      return;
    } else {
      if($requester_id != $member_id){
        confirmFriendship($member_id, $requester_id);
        echo 2;
        return;
      }
    }
  }

  function requestFriendship(){
    global $friend_id;
    global $member_id;
    $query = "INSERT INTO friend_requests (requester_id, friend_id)
                VALUES (?, ?)";
    $stmt = makeStmt($query);
    $stmt->bind_param("ii", $member_id, $friend_id);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows();
  }
?>
