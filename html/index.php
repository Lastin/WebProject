<?php
  ob_start();
  session_start();
  require_once "functions.php";
  require_once "models.php";
  require_once "objects.php";
  echo makeDocBegin();
  if(isset($_SESSION['username'])) {
    $user = new User;
    $user->fetchUserData($_SESSION['username']);
    echo makeRightPanel($user);
    //echo makeMainPanel($user->getPosts());
  } else {
    echo makeWelcomePage();
  }
  echo makeDocEnd();
?>
