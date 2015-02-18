<?php
  require_once("../functions.php");
  session_start();
  if(!isset($_SESSION['member_id']) || !isset($_GET['id']) || $_GET['id'] == ""){
    header("Location: ../index.php");
  }
  $friend_id = sanitiseString($_GET['id']);
  $member_id = $_SESSION['member_id'];

  $query = "SELECT * FROM posts"


  function makePost($post){
    $post_content = $post['content'];
    $post_content = str_replace("\\n", "<br>", $post_content);
    $profile_image_id = getProfileImageId($post['poster_id']);
    $poster_name = getMemberFullName($post['poster_id']);
    $post_id = $post['post_id'];
    return
    "<div class='post'>
      <div>
        <img src='actions/getImage.php?image_id=".$profile_image_id."' class='poster-img'>
        <a href='#' class='profile-link'>".$poster_name.":</a>
        <p>".$post_content."</p>
      </div>
      <hr>
      <a href='#' onclick='admire()' class='admirer'>Admire!</a>
      <div class='comment-section'>
        <div id='".$post_id."postComments'>
          ".getComments($post_id)."
        </div>
        <form class='comment-form' onsubmit='writeComment($post_id, this); return false'>
          <div class='comment-box'>
            <input type='text' name='comment' id=".$post_id."postCommentInput maxlength=4000 placeholder='Write a comment' class='glowing-border comment-input'>
          </div>
        </form>
      </div>
    </div>";
  }


  function getComments($post_id){
    $query = "SELECT * FROM comments
              WHERE post_id = '$post_id'
              ORDER BY post_id";
    $comments = queryMysql($query);
    $html_comments = "";
    foreach($comments as $comment){
      $html_comments .= makeComment($comment);
    }
    return $html_comments;
  }

  function makeComment($comment){
    $commenter_id = $comment['commenter_id'];
    $commenter_image_id = getProfileImageId($commenter_id);
    $commenter_name = getMemberFullName($commenter_id);
    $comment = $comment['comment'];
    return
    "<div class='comment'>
    <img src='actions/getImage.php?image_id=".$commenter_image_id."' class='poster-img'>
    <a href='#' class='profile-link'>".$commenter_name.":</a>
    <span>".$comment."</span>
    </div>";
  }
?>
