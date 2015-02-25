<?php
  session_start();
  require_once("../functions.php");
  if(isset($_POST['username']) && isset($_POST['password'])){
    $username = sanitiseString($_POST['username']);
    $password = sanitiseString($_POST['password']);

    $u_len = strlen($username);
    $p_len = strlen($password);
    if ($u_len == 0){
      echo "Enter user name";
      return;
    }
    else if ($p_len == 0){
      echo "Enter password";
      return;
    }
    else {
      $query = "SELECT member_id, password FROM members WHERE username = ?";
      $stmt = makeStmt($query);
      $stmt->bind_param("s", $username);
      $stmt->bind_result($member_id, $password_db);
      $stmt->execute();
      $stmt->fetch();
      if (password_verify($password, $password_db)){
        $_SESSION['member_id'] = $member_id;
        echo 1;
      } else {
        echo 0;
      }
    }
  } else {
    header("Location: ../index.php");
  }
  return;
?>
