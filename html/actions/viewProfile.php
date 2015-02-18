<?php
  require_once("../functions.php");
  session_start();
  if(!isset($_SESSION['member_id']) || !isset($_GET['id']) || $_GET['id'] == ""){
    header("Location: ../index.php");
  }
  $id = sanitiseString($_GET['id']);

  $array = array(
    "success" => 1,
    "profile" => profileHTML($id)
  );
  echo json_encode($array);

  function profileHTML($id){
    $beginning =
    "<div class='post'>
      <div class='profile'>
        <img src='actions/getImage.php?image_id='".getProfileImageId($id)."' class='profile-view-img' />
        <div class='details'>
          <p>".getMemberFullName($id)."</p>
          <p>Location: ".getMemberLocation($id)."</p>
        </div>";
    $button = "";
    if($id != $_SESSION['member_id']){
      $button = "<button type='button' onclick='removeFriend($id)' class='unfriend'>Unfriend</button>";
    }
    $end =
      "</div>
    </div>
    <div class='posts_container'>

    </div>";
    return $beginning . $button . $end;
  }
?>
