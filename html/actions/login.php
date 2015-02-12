<?php
  require_once('../index.php');
  if(isset($_POST['user'])){
    $username = sanitizeString($_POST['user']);
    $password = sanitizeString($_POST['password']);

    $u_len = strlen($username);
    $p_len = strlen($password);
    if ($u_len ==0)
      $error = "Enter user name";
    else if ($p_len == 0)
      $error = "Enter password";
    else {
      $result = queryMySQL("SELECT username,password FROM members WHERE username='$username'");
      $result = $result->fetch_assoc();
      if (password_verify($pass, $result['pass'])){
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        header("Location: members.php?view=$user");
      } else {
        $error = "Username/Password invalid";
      }
    }
  }
?>
