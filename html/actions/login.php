<?php
  require_once("../functions.php");
  if(isset($_POST['username']) && isset($_POST['password'])){
    $username = sanitiseString($_POST['username']);
    $password = sanitiseString($_POST['password']);

    $u_len = strlen($username);
    $p_len = strlen($password);
    if ($u_len ==0)
      $error = "Enter user name";
    else if ($p_len == 0)
      $error = "Enter password";
    else {
      $result = queryMySQL("SELECT username,password FROM members WHERE username='$username'");
      $result = $result->fetch_assoc();
      if (password_verify($password, $result['password'])){
        $_SESSION['username'] = $username;
        echo 1;
        header('Location: ../index.php');
      } else {
        echo 0;
      }
    }
  }
?>
