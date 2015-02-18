<?php
  require_once("../functions.php");
  session_start();
  if(!isset($_SESSION['member_id']) || !isset($_POST['string']) || $_POST['string'] == ""){
    header("location: ../index.php");
  }
  $string = sanitiseString($_POST['string']);
  $elements = explode(" ", $string);
  $fname = $elements[0];
  $stmt;
  if(count($elements) < 2){
    $query = "SELECT member_id, fname, lname from members
              WHERE (fname LIKE ? OR lname LIKE ?)";
    $stmt = makeStmt($query);
    $stmt->bind_param("ss", $fname, $fname);
    $stmt->bind_result($friend_id, $fname, $lname);

  } else {
    $lname = $elements[1];
    $query = "SELECT member_id, fname, lname from members
              WHERE (fname LIKE ? AND lname LIKE ?)
              OR (lname LIKE ? AND fname LIKE ?)";
    $stmt = makeStmt($query);
    $stmt->bind_param("ssss", $fname, $lname, $fname, $lname);
    $stmt->bind_result($friend_id, $fname, $lname);
  }
  $stmt->execute();
  while($stmt->fetch()){

  }
?>
