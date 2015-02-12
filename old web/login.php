<?php // Example 26-7: login.php
  require_once 'header.php';

  echo "<div class='main'>";
  $error = $user = $pass = "";

  if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    $u_len = strlen($user);
    $p_len = strlen($pass);
    if ($u_len ==0)
      $error = "Enter user name";
    else if ($p_len == 0)
      $error = "Enter password";
    else {
        $result = queryMySQL("SELECT user,pass FROM members WHERE user='$user'");
        $result = $result->fetch_assoc();
        if (password_verify($pass, $result['pass'])){
          $_SESSION['user'] = $user;
          $_SESSION['pass'] = $pass;
          header("Location: members.php?view=$user");
        } else {
          $error = "Username/Password invalid";
        }
      }
  }
  if($error != "")
    echo "<div class='error-box'>$error</div>";
  echo <<<_END
  <form method='post' action='login.php'>
      <table>
        <tr>
          <td><label class='fieldname'>Username</label></td>
          <td><input type='text' class='glowing-border' minlength='10' maxlength='16' name='user' value='$user'></td>
        </tr>
        <tr>
          <td><label class='fieldname'>Password</label></td>
          <td><input type='password' class='glowing-border' maxlength='16' name='pass' value='$pass'></td>
        </tr>
        <tr>
          <td colspan="2" align=center><input type='submit' class="btn" value='Login'><td>
        </tr>
      </table>
  </form>
_END;
?>
  </body>
</html>
