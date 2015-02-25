<?php
  require_once "../functions.php";
  session_start();
  if(!isset($_SESSION['member_id']) || !isset($_POST['image']) || $_POST['image'] == "") return;

  $image = $_POST['image'];
  $member_id = $_SESSION['member_id'];

  $query = "INSERT INTO images (owner_id, image)
            VALUES (?, ?)";
  $stmt = makeStmt($query);
  $stmt->bind_param("is", $member_id, $image);
  $stmt->execute();
?>
