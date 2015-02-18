<?php
  require_once("../functions.php");
  session_start();
  if(!isset($_SESSION['member_id']) || !isset($_POST['friend_id']) || $_POST['friend_id'] == ""){
    header("Location: ../index.php");
  }
  $friend_id = sanitiseString($_POST['friend_id']);
  $member_id = $_SESSION['member_id'];

  $query = "DELETE FROM friends WHERE
            (member_id = ? AND friend_id = ?) OR
            (friend_id = ? AND member_id = ?)";
  $stmt = makeStmt($query);
  $stmt->bind_param("iiii", $member_id, $friend_id, $member_id, $friend_id);
  $stmt->execute();
  echo $stmt->affected_rows;
  return;
?>
