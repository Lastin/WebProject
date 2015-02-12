<?php
  ob_start();
  session_start();
  require_once "functions.php";
  require_once "models.php";
  if(isset($_SESSION['user_id'])) {

  } else {
    echo makeDocBegin() . makeWelcomePage() . makeDocEnd();
  }
?>
