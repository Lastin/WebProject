<?php
  ob_start();
  session_start();
  require_once "functions.php";
  require_once "models.php";
  require_once "objects";
  echo makeDocBegin();
  if(isset($_SESSION['username'])) {

    echo makeRightPanel();
    echo makeMainPanel();
  } else {
    echo makeWelcomePage();
  }
  echo makeDocEnd();

  function makeUser(){
    $_SESSION['username'];
  }
?>
