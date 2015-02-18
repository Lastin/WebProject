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
    $member_id = $_SESSION['member_id'];
    if($id != $member_id){
      if(isFriend($id, $member_id)){
        $button = "<button id='befriendButton' type='button' onclick='removeFriend($id)' class='endefriendBtn unfriend'>Unfriend</button>";
      } else {
        $requester_id = searchRequests($id, $member_id);
        if($requester_id == 0) {
          $button = "<button id='befriendButton' type='button' onclick='inviteFriend($id)' class='endefriendBtn invite'>Invite to friends</button>";
        } else if($requester_id == $id) {
          $button = "<button id='befriendButton' type='button' onclick='confirm($id)' class='endefriendBtn confirm'>Confirm</button>";
        } else {
          $button = "<button id='befriendButton' type='button' onclick='cancel($id)' class='endefriendBtn cancel'>Cancel Invitation</button>";
        }
      }
    }
    $end =
      "</div>
      </div>
    <div class='posts_container'>
    </div>";
    return $beginning . $button . $end;
  }
?>
