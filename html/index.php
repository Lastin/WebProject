<?php
  ob_start();
  session_start();
  require_once "functions.php";
  require_once "models.php";
  echo makeDocBegin();
  if(isset($_SESSION['user_id'])) {

  } else {
    echo makeWelcomePage();
  }
  echo makeDocEnd();
?>
