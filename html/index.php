<?php
  ob_start();
  session_start();
  require_once "functions.php";
  require_once "models.php";
  require_once "objects.php";
  echo makeDocBegin();
  if(isset($_SESSION['member_id'])) {
    $_SESSION['messages_fetched'] = 0;
    $user = new Member;
    $user->fetchUserData($_SESSION['member_id']);
    $_SESSION['userObj'] = $user;
    echo makeRightPanel($user);
    echo makeChatBoxesContainer();
    
  } else {
    echo makeWelcomePage();
  }
  echo makeDocEnd();
?>
