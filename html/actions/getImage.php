<?php
  session_start();
  require_once("../functions.php");
  if(!isset($_SESSION['member_id']) || !isset($_GET['image_id'])){
    header("Location: ../index.php");
  }

  header("Content-type: image/png");
  $image_id = sanitiseString($_GET['image_id']);
  if(!grantAccess($image_id)){
    $image_id = 1;
  }
  echo getImage($image_id);

  function getImage($image_id){
    $query = "SELECT image FROM images
              WHERE image_id = ?";
    $stmt = makeStmt($query);
    $stmt->bind_param("i", $image_id);
    $stmt->bind_result($image);
    $stmt->execute();
    $stmt->fetch();
    return $image;
  }

  function grantAccess($image_id){
    $query = "SELECT owner_id FROM images
              WHERE image_id = ?";
    $stmt = makeStmt($query);
    $stmt->bind_param("i", $image_id);
    $stmt->bind_result($owner_id);
    $stmt->execute();
    $stmt->fetch();
    return $owner_id;
  }
?>
