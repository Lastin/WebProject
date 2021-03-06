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
    <body>";
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

function makePoster(){
  return
  "<div class='post poster'>
    <p><b>Write your post:</b></p>
    <form onsubmit='writeNewPost(this); return false'>
      <div class='inputContainer'>
        <textarea maxlength='4000' name='newPostTextarea' class='newPostInput' rows=8 ></textarea>
        <input type='submit' class='postSubmitBtn' value='Post!'>
      </div>
    </form>
    <div id='newPostWarning'>

    </div>
  </div>";
}

function makePostsContainer(){
  return
  "<div class='main-panel' id='main-panel'>
    ".makePoster()."
    <div id='posts_container'>
    </div>
  </div>";
}

function makeRightPanel($user) {
  return
  "<div class='right-panel glow-box' id='right-panel'>
    <a href='index.php'>
      <canvas width=350 height=100 id='logo'></canvas>
    </a>
    <div class='user'>
      <div class=inputWrapper>
        <img src='actions/getImage.php?image_id=".getProfileImageId($user->member_id)."' class='profile-img' onclick='changeImage()'/>
        <input type='file' class='hidden' id='imageSelector' onchange='uploadImage()'>
      </div>
      <a href='#' onclick='viewProfile($user->member_id)'>"
        .$user->fname." ".$user->lname.
      "</a>
      <button type=button onclick='logout()'  class=fancy-btn>Logout</button>
    </div>
    ".getSideTabbedPanel($user)."
  </div>";
}

function makeWelcomePage() {
  return
  getWelcomeTopBox() .
  "<div class='top-login-box glow-box'>
    ".getRegistrationForm()."
  </div>";

    /*<div class='main-panel'>
      <center>
      <div class='glow-box'>"
        .getRegistrationForm().
      "</div>
  </center>
  </div>";*/
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
  "<div class='top-login-box glow-box'>
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
              .listInvites($member->member_id)
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
    "<table>
      <tr>
        <td>
          <p>You got no friends.</p>
        </td>
      </tr>
    </table>
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
          <td><a href='#' class='profile-link' onclick='viewProfile($friend->member_id)'>$friend_description</a></td>
          <td class='msgbutton'><a onclick='popChatWith($friend->member_id, \"$friend_description\")' href='#'><img src='images/msg.png'/></a></td>
        </tr>
      </table>
    </div>";
  }
  return $friends_list;
}

function getSearchTab(){
  return "
  <div class='searchTab'>
    <form id='searchForm' onsubmit='searchFriend(this); return false;'>
      <input type='text' name='searchMemberInput' onsubmit='return false' class ='glowing-border search-input' placeholder='Type name and/or surname'>
    </form>
    <div id='searchResult'>
      <table id='searchResultTable'>
      </table>
    </div>
  </div>
  ";
}

function getMessagesTab($member){
  $messages = $member->fetchAllMessages();
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
          <a href='#' class='profile-link'>".getMemberFullName($message->sender_id)."</a>
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

function requesterProfile($friend_id){
  $inviter_name = getMemberFullName($friend_id);
  $profile_image_id = getProfileImageId($friend_id);
  return
  "<tr>
    <td>
      <img src='actions/getImage.php?image_id=$profile_image_id' class='poster-img'/>
    </td>
    <td>
      <a href='#' class='profile-link' onclick='viewProfile($friend_id)'>$inviter_name</a>
    </td>
  </tr>";
}

function listInvites($member_id){
  $requests_stmt = getInvites($member_id);
  $requests_stmt->bind_result($requester_id);
  $requests_stmt->execute();
  $invites =
  "<div id='searchResult'>
    <table class='invitesTable'>
      <th>
        <td colspan='2'>Friend requests:</td>
      </th>";
  $requests_stmt->store_result();
  if($requests_stmt->num_rows < 1) return;
  while($requests_stmt->fetch()){
    $invites .= requesterProfile($requester_id);
  }
  $invites .=
  " </table>
  </div>";
  return $invites;
}
?>
