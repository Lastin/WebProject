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
              WHERE image_id = '$image_id'";
    $result = queryMysql($query);
    return $result->fetch_assoc()['image'];
  }

  function grantAccess($image_id){
    $query = "SELECT owner_id
              FROM images WHERE image_id = '$image_id'";
    $result = queryMysql($query);
    $friend_id = $result->fetch_assoc()['owner_id'];
    return isFriend($_SESSION['member_id'], $friend_id);
  }
?>
