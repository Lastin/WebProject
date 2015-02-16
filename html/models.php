<?php
require_once("functions.php");

function makeDocBegin() {
  return
  "<!DOCTYPE html>
  <html>
    <head>
      <title>SocialNetwork</title>
      <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js'></script>
      <link rel='stylesheet' href=style.css>
    </head>
    <body>
      <div class='main-panel'></div>";
}

function makeDocEnd() {
  return
  "
  <script src='scripts/drawLogo.js'></script>
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
    ".getSideTabbedPanel($user)."
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

function getSideTabbedPanel($member) {
  return
  "<div class='side-tabbled-panel'>
    <table>
      <tr>
        <td>
          <ul class='tabs'>
            <li class='tab-tile active' id='mates-tab-btn'><a href='#'>Your mates</a></li>
            <li class='tab-tile' id='search-tab-btn'><a href='#'>Search people</a></li>
            <li class='tab-tile' id='msg-tab-btn'><a href='#'>All Messages</a></li>
          </ul>
        </td>
      </tr>
      <tr>
        <td>
          <div class='side-content' >
            <div id='mates'>"
              .listFriends($member->getFriends()).
            "</div>
            <div id='search'>"
              .getSearchTab().
            "</div>
            <div id='messages'>"
              .getMessagesTab($member).
            "</div>
          </div>
        </td>
      </tr>
    </table>
  </div>";
}

function listFriends($friends){
  $friends_list = "";
  if(count($friends) == 0){
    $friends_list .=
    "   <tr>
          <td>
            <p>You don't have any friends YET</p>
          </td>
        </tr>
    ";
  }
  foreach($friends as $friend){
    $friend_description = $friend->fname ." ". $friend->lname;
    $profile_image_id = getProfileImageId($friend->member_id);
    $friends_list .=
    "<div class='friend-name separator'>
      <table>
        <tr>
          <td><img src='actions/getImage.php?image_id=$profile_image_id' class='poster-img'/></td>
          <td><a href='#' class='profile-link'>$friend_description</a></td>
          <td class='msgbutton'><a onclick='popChatWith($friend->member_id, \"$friend_description\")' href='#'><img src='images/msg.png'/></a></td>
        </tr>
      </table>
    </div>";
  }
  return $friends_list;
}

function getSearchTab(){
  return "";
}

function getMessagesTab($member){
  $messages = $member->fetchMessages();
  $messages_list = "";
  if(count($messages) == 0){
    $messages_list .=
    "<table>
      <tr>
        <td>
          <p>You have no new messages messages</p>
        </td>
      </tr>
    </table>";

  }
  foreach($messages as $message){
    $messages_list .=
    "<div class='separator message'>
      <table>
        <tr>
          <a href='#' class='profile-link'>$message->sender_full_name</a>
        </tr>
        <tr>
          <td ><textarea class='messageTextarea' disabled>$message->message</textarea></td>
        </tr>
      </table>
    </div>";
  }
  return $messages_list;
}

function makeChatBoxesContainer(){
  return "
  <div class=chatBoxesContainer id=chatBoxesContainer>
  </div>";
}
?>
