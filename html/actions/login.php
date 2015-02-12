<?php
  if(isset($_POST['user']) && isset($_POST['password'])){
    $username = sanitiseString($_POST['user']);
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
      if (password_verify($pass, $result['pass'])){
        $_SESSION['username'] = $username;
        header("Location: index.php");
      } else {
        $error = "Username/Password invalid";
        echo "wong";
      }
    }
  }
?>
