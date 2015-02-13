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
      <script src='scripts/interaction.js'></script>
      <script src='scripts/registration_scripts.js'></script>
      <script src='scripts/login_scripts.js'></script>
    </body>
  </html>";
}

function makeRightPanel($user) {
  return
  "<div class='right-panel glow-box' id='right-panel'>
    <canvas width=350 height=100 id='logo'></canvas>
    <div class='user'>
      <a href=''>"
        .$user->fname." ".$user->fname.
      "</a>
      <button type=button onclick='logout()'  class=fancy-btn>Logout</button>
      <button type=button class=fancy-btn>Settings</button>
    </div>
    ".getSideTabbedPanel()."
  </div>";
}

function makeMainPanel($posts) {
  $beginning = "<div class='main-panel'>";
  $posts = "";
  foreach($posts as $post){
    $posts .= makePost($post);
  }
  $ending = "</div>";
}

function makePost($post) {
  $beginning =
  "<div class='post'>
    <p>".$post->content."</p>
    <hr>
    <a href='#' onclick='admire()' class='admirer'>Admire!</a>
    <div class='comment-section'>
      <div class='comment'>
        <img src='photos/wilson.jpg' class='poster-img'>
        <a href='#' class='profile-link'>Bill Wilson:</a>
        <span >some place holder</span>
      </div>";
    $comments = $post->comments;
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
  "<form id='registerForm' method='POST'>
    <p>Welcome, please register or login with an existing account.</p>
    <table class='form-table'>
      <tr>
        <td>
          <input type='text' name='username' id='username' maxlength='32' placeholder='Username*' class='glowing-border' onblur='checkUser(this)'>
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
            <input type='button' onclick='registerUser()' value='Register' class='fancy-btn'>
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
    <form id='loginForm' method='POST'>
      <table class='form-table'>
        <tr>
          <td><input type='text' placeholder='Username' name='username' onchange='cleanMessage()' class='glowing-border'></td>
          <td><input type='password' placeholder='Password' name='password' onchange='cleanMessage()' class='glowing-border' id='password'></td>
          <td><input type='button' onclick='tryLogin()' value='Login' class='fancy-btn'></td>
          <td><div class='info_box' id='login_error_box'></div></td>
        </tr>
      </table>
    </form>
  </div>";
}

function getSideTabbedPanel() {
  return
  "<div class='side-tabbled-panel'>
    <table>
      <tr>
        <td>
          <ul class='tabs'>
            <li class='tab-tile active'><a href='#'>Your mates</a></li>
            <li class='tab-tile'><a href='#'>Search people</a></li>
            <li class='tab-tile'><a href='#'>Messages</a></li>
          </ul>
        </td>
      </tr>
      <tr>
        <td>
          <div class='side-content'>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
            <p>asdasdadas</p>
          </div>
        </td>
      </tr>
    </table>
  </div>";
}

//echo makeDocBegin() . makeWelcomePage() . makeDocEnd();
?>
