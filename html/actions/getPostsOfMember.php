<?php
  session_start();
  require_once("../functions.php");
  if(!isset($_SESSION['member_id']) || !isset($_POST['id']) || $_POST['id'] == ""){
    header("Location: ../index.php");
  }
  $friend_id = sanitiseString($_POST['id']);
  $member_id = $_SESSION['member_id'];


  if($friend_id != $member_id && !isFriend($member_id, $friend_id)){
    header("Location: ../index.php");
  }

  $posts = getPosts();
  $array = array(
    "success" => 1,
    "posts" => $posts
  );
  echo json_encode($array);

  function getPosts(){
    global $friend_id;
    $posts = "";
    $query = "SELECT post_id, poster_id, content FROM posts
              WHERE poster_id = ?";
    $stmt = makeStmt($query);
    $stmt->bind_param("i", $friend_id);
    $stmt->bind_result($post_id, $poster_id, $content);
    $stmt->execute();
    while($stmt->fetch()){
      $stmt->store_result();
      $posts .= makePost($post_id, $poster_id, $content);
    }
    return $posts;
  }

  function makePost($post_id, $poster_id, $content){
    $content = str_replace("\\n", "<br>", $content);
    $profile_image_id = getProfileImageId($poster_id);
    $poster_name = getMemberFullName($poster_id);
    return
    "<div class='post'>
      <div>
        <img src='actions/getImage.php?image_id=".$profile_image_id."' class='poster-img'>
        <a href='#' class='profile-link'>".$poster_name.":</a>
        <p>".$content."</p>
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
    $query = "SELECT commenter_id, comment FROM comments
              WHERE post_id = ?
              ORDER BY post_id";
    $stmt = makeStmt($query);
    $stmt->bind_param("i", $post_id);
    $stmt->bind_result($commenter_id, $comment);
    $stmt->execute();
    $html_comments = "";
    while($stmt->fetch()){
      $stmt->store_result();
      $html_comments .= makeComment($commenter_id, $comment);
    }
    return $html_comments;
  }

  function makeComment($commenter_id, $comment){
    $commenter_image_id = getProfileImageId(3);//$commenter_id);
    $commenter_name = getMemberFullName($commenter_id);
    return
    "<div class='comment'>
      <img src='actions/getImage.php?image_id=".$commenter_image_id."' class='poster-img'>
      <a href='#' class='profile-link'>".$commenter_name.":</a>
      <span>".$comment."</span>
    </div>";
  }
?>
