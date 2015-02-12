<?php
function makeDocBegin() {
  return
  "<!DOCTYPE html>
  <html>
    <head>
      <title>SocialNetwork</title>
      <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js'></script>
      <link rel='stylesheet' href=style.css>
    </head>
    <body>";
}

function makeDocEnd() {
  return
  "   <script src='scripts/drawLogo.js'></script>
      <script src='scripts/postActions.js'></script>
      <script src='scripts/resizing.js'></script>
      <script src='scripts/registration_validator.js'></script>
    </body>
  </html>";
}

function makeRightPanel($user) {
  return
  "<div class='right-panel glow-box' id='right-panel'>
    <canvas width=350 height=100 id='logo'></canvas>
    <div class='user'>
      <a href=''>"
        .$user['fname']." ".$user['lname'].
      "</a>
      <button type=button class=fancy-btn>Logout</button>
      <button type=button class=fancy-btn>Settings</button>
    </div>
  </div>";
}

function makeMainPanel($posts) {
  $beginning = "<div class='main-panel'>";
  $posts = "";
  foreach($posts as $post){
    $posts .= makePost();
  }
  $ending = "</div>";
}

function makePost($content, $comments) {
  $beginning =
  "<div class='post'>
    <p>".$post_content."</p>
    <hr>
    <a href='#' onclick='admire()' class='admirer'>Admire!</a>
    <div class='comment-section'>
      <div class='comment'>
        <img src='photos/wilson.jpg' class='poster-img'>
        <a href='#' class='profile-link'>Bill Wilson:</a>
        <span >some place holder</span>
      </div>";
    $comments = "";
    foreach($comments as $comment){
      $comments .= makeComment($comment);
    }
    $ending = "
      <form class='comment-form'>
        <div class='comment-box'>
          <input type='text' maxlength=255 placeholder='Write a comment' class='glowing-border comment-input'>
        </div>
      </form>
    </div>
  </div>";
  return $beginning . $comments . $ending;
}

function makeComment($comment) {
  //TODO: get user photo and name
  $user = queryMysql("SELECT ");
  return
  "<div class='comment'>
    <img src='photos/wilson.jpg' class='poster-img'>
    <a href='#' class='profile-link'>Bill Wilson:</a>
    <span>some place holder</span>
  </div>";
}

function makeWelcomePage() {
  return
  getWelcomeTopBox() ."
    <div class='main-panel'>
      <center>
      <div class='glow-box'>"
        .getRegistrationForm().
      "</div>
  </center>
  </div>";
}

function getRegistrationForm(){
  return
  "<form method= 'POST' action='http://localhost/actions/register.php' onsubmit='return validateForm()'>
    <p>Welcome, please register or login with an existing account.</p>
    <table class='form-table'>
      <tr>
        <td>
          <input type='text' name='username' id='username' maxlength='16' placeholder='Username*' class='glowing-border' onblur='checkUser(this)'>
        </td>
        <td>
        <p id='username_info' class='info_box'></p>
        </td>
      </tr>
      <tr>
        <td>
          <input type='text' name='fname' id='fname' placeholder='First name*' class='glowing-border'>
        </td>
        <td>
          <input type='text' name='lname' id='lname' placeholder='Last name*' class='glowing-border'>
        </td>
      </tr>
      <tr>
        <td>
          <input type='text' name='city' maxlength='255' placeholder='City' class='glowing-border'>
        </td>
        <td>
          <input type='text' name='country' placeholder='Country' class='glowing-border'>
        </td>
      </tr>
      <tr>
        <td>
          <input type='password' id='pass1' name='pass1' maxlength=16 placeholder='Password*' class='glowing-border' onblur=comparePasswords()>
        </td>
        <td>
          <input type='password' id='pass2' name='pass2' maxlength=16 placeholder='Repeat password*' class='glowing-border' onblur=comparePasswords()>
        </td>
      </tr>
      <tr>
        <td colspan='2'>
          <div align='center'>
            <input type='submit' value='Register' class='fancy-btn'>
          </div>
        </td>
      </tr>
      <tr>
        <td colspan='2'>
          <div class='info_box' id='error_box'></div>
          <span>*(Required fields)</span>
        </td>
      </tr>
    </table>
  </form>";
}

function getWelcomeTopBox() {
  return
  "<div class='right-panel-top glow-box'>
    <canvas width=350 height=100 id='logo'></canvas>
    <form method='POST' action='http://localhost/actions/login.php'>
      <table class='form-table'>
        <tr>
          <td><input type='text' placeholder='Username' name='username' class='glowing-border'></td>
          <td><input type='text' placeholder='Password' name='password' class='glowing-border'></td>
          <td><input type='submit' value='Login' class='fancy-btn'></td>
        </tr>
      </table>
    </form>
  </div>";
}

//echo makeDocBegin() . makeWelcomePage() . makeDocEnd();
?>
