<?php
  ob_start();
  session_start();
  require_once "functions.php";
  require_once "models.php";
  require_once "objects.php";
  echo makeDocBegin();
  if(isset($_SESSION['member_id'])) {
    $user = new Member;
    $user->fetchUserData($_SESSION['member_id']);
    echo makeRightPanel($user);
    echo makeChatBox();
    //echo makeMainPanel($user->getPosts());
  } else {
    echo makeWelcomePage();
  }
  echo makeDocEnd();
?>
