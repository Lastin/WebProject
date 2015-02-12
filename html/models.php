<?php
function getDocBegin() {
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

function getDocEnd() {
  return
  "   <script src='scripts/drawLogo.js'></script>
      <script src='scripts/postActions.js'></script>
      <script src='scripts/resizing.js'></script>
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
?>
