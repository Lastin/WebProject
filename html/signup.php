<?php // Example 26-5: signup.php
  require_once 'header.php';

  $regform = "
  <script>$(function(){
    $('#datepicker').datepicker({
      maxDate:'-13y'
    });
  });</script>
  <form method='post' action='login.php'>
  <table>
  <tr>
  <td><label class='fieldname'>First name</label></td>
  <td><input type='text' class='glowing-border' maxlength='50' name='firstname'></td>
  </tr>
  <tr>
  <td><label class='fieldname'>Last name</label></td>
  <td><input type='text' class='glowing-border' name='lastname'></td>
  </tr>
  <tr>
  <td><label class='fieldname'>City</label></td>
  <td><input type='text' class='glowing-border' maxlength='50' name='city'></td>
  </tr>
  <tr>
  <td><label class='fieldname'>Country</label></td>
  <td><input type='text' class='glowing-border' maxlength='50' name='country'></td>
  </tr>
  <tr>
  <td><label class='fieldname'>Date of birth</label></td>
  <td><input type='text' class='glowing-border' maxlength='50' name='dob' id='datepicker'></td>
  </tr>
  <tr>
  <td><label class='fieldname'>Password</label></td>
  <td><input type='password' class='glowing-border' minlength='6' maxlength='32' name='pass'></td>
  </tr>
  <tr>
  <td><label class='fieldname'>Repeat password</label></td>
  <td><input type='password' class='glowing-border' minlength='6' maxlength='32' name='pass2'></td>
  </tr>
  <tr>
  <td colspan='2' align=center><input type='submit' class='btn' value='Register'><td>
  </tr>
  </table>
  </form>";

  echo <<<_END
  <script>
    function checkUser(user)
    {
      if (user.value == '')
      {
        O('info').innerHTML = ''
        return
      }

      params  = "user=" + user.value
      request = new ajaxRequest()
      request.open("POST", "checkuser.php", true)
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
      request.setRequestHeader("Content-length", params.length)
      request.setRequestHeader("Connection", "close")

      request.onreadystatechange = function()
      {
        if (this.readyState == 4)
          if (this.status == 200)
            if (this.responseText != null)
              O('info').innerHTML = this.responseText
      }
      request.send(params)
    }

    function ajaxRequest()
    {
      try { var request = new XMLHttpRequest() }
      catch(e1) {
        try { request = new ActiveXObject("Msxml2.XMLHTTP") }
        catch(e2) {
          try { request = new ActiveXObject("Microsoft.XMLHTTP") }
          catch(e3) {
            request = false
      } } }
      return request
    }
  </script>
  <div class='main'><h3>Please enter your details to sign up</h3>
_END;

  $error = $user = $pass = "";
  if (isset($_SESSION['user'])) destroySession();

  if (isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")
      $error = "Not all fields were entered<br><br>";
    else
    {
      $result = queryMysql("SELECT * FROM members WHERE user='$user'");

      if ($result->num_rows)
        $error = "That username already exists<br><br>";
      else
      {
        //queryMysql("INSERT INTO members VALUES('$user', '$pass')");
        registerUser($user, $pass);
        die("<h4>Account created</h4>Please Log in.<br><br>");
      }
    }
  }

  echo $regform;
?>
  </body>
</html>
