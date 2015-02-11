<?php // Example 26-2: header.php
  ob_start();

  session_start();

  require_once 'functions.php';

  $userstr = ' (Guest)';

  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = " ($user)";
  }
  else $loggedin = FALSE;

  if ($loggedin) {
    $navbar = "
    <ul class='nav-bar menu'>
      <li><a class='nav-item' href='members.php?view=$user'>Home</a></li>
      <li><a class='nav-item' href='members.php'>Members</a></li>
      <li><a class='nav-item' href='friends.php'>Friends</a></li>
      <li><a class='nav-item' href='messages.php'>Messages</a></li>
      <li><a class='nav-item' href='profile.php'>Edit Profile</a></li>
      <li><a class='nav-item' href='logout.php'>Log out</a></li></ul><br>
    </ul>";
  }
  else {
    $navbar = "
    <ul class='nav-bar menu'>
      <li><a class='nav-item' href='signup.php'>Register</a></li>
      <li><a class='nav-item' href='login.php'>Log in</a></li></ul>
    </ul>";
  }

  $content = "
  <!DOCTYPE html>
  <html>
  <head>
  <title>$appname$userstr</title>
  <link rel='stylesheet' href='styles.css' type='text/css'>
  <link rel='stylesheet' href='//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css'>
  <script src='//code.jquery.com/jquery-1.10.2.js'></script>
  <script src='//code.jquery.com/ui/1.11.2/jquery-ui.js'></script>
  </head>
  <body>
  <center>
  <a href='index.php'><canvas id='logo' width='624' height='96'>$appname</canvas></a></center>
  <div class='appname'>$appname$userstr$navbar</div>
  <script src='javascript.js'></script>";

  echo $content;
?>
