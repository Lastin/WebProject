<?php
  require_once("../functions.php");
  session_start();
  if(!isset($_SESSION['member_id']) || !isset($_POST['friend_id']) || $_POST['friend_id'] == ""){
    header("Location: ../index.php");
  }

  $friend_id = $_POST['friend_id'];
  $friend_id = sanitiseString($friend_id);
  $member_id = $_SESSION['member_id'];

  if(searchFriendships() == 0){
    if(searchRequests() > 0){
      confirmFriendship();
    } else {
      requestFriendship();
    }
  }

  function searchRequests(){
    global $friend_id;
    global $member_id;
    $query = "SELECT 1 FROM friend_requests
              WHERE requester_id = ? AND friend_id = ?"
    $stmt = makeStmt($query);
    $stmt->bind_param("ii", $friend_id, $member_id);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows;
  }

  function searchFriendships(){
    global $friend_id;
    global $member_id;
    $query = "SELECT 1 FROM friends WHERE
              (member_id = ? AND friend_id = ?) OR
              (friend_id = ? AND member_id = ?)";
    $stmt = makeStmt($query);
    $stmt->bind_param("iiii", $member_id, $friend_id, $member_id, $friend_id);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows;
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
