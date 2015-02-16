<?php
  session_start();
  require_once("../functions.php");
  if(!isset($_SESSION['member_id']) || !isset($_POST['oldest_loaded'])){
    header("Location: ../index.php");
  }

  $oldest_loaded = sanitiseString($_POST['oldest_loaded']);
  $data = array(
    "data" => getPosts(),
    "oldest_loaded" => $oldest_loaded
  );
  echo json_encode($data);

  function getPosts(){
    global $oldest_loaded;
    $member_id = $_SESSION['member_id'];
    $posts = getPostsForUser($member_id);
    $html_posts = "";
    foreach($posts as $post){
      $html_posts .= makePost($post);
      if($oldest_loaded > $post['post_id']){
        $oldest_loaded = $post['post_id'];
      }
    }
    return $html_posts;
  }

  function getPostsForUser($member_id){
    global $oldest_loaded;
    $condition = "";
    if($oldest_loaded > 0) {
      $condition = " WHERE posts.post_id < $oldest_loaded";
    }

    $observed_people = "SELECT DISTINCT(members.member_id)
                        FROM members JOIN friends
                        ON members.member_id = friends.member_id
                        OR members.member_id = friends.friend_id WHERE
                        friends.member_id = '$member_id' OR
                        friends.friend_id = '$member_id'";
    $query = "SELECT posts.* FROM posts
              JOIN ($observed_people) AS observed
              ON posts.poster_id = observed.member_id
              ".$condition."
              ORDER BY posts.post_id DESC LIMIT 20";
    return queryMysql($query);
  }

  function makePost($post){
    $post_content = $post['content'];
    $profile_photo_id = getProfileImageId($post['poster_id']);
    $poster_name = getMemberFullName($post['poster_id']);
    $post_id = $post['post_id'];
    return
    "<div class='post'>
      <div>
        <img src='actions/getImage.php?image_id=".$profile_photo_id."' class='poster-img'>
        <a href='#' class='profile-link'>".$poster_name.":</a>
        <p>".$post_content."</p>
      </div>
      <hr>
      <a href='#' onclick='admire()' class='admirer'>Admire!</a>
      <div class='comment-section'>
        ".getComments($post_id)."
        <form class='comment-form'>
          <div class='comment-box'>
          <input type='text' id=".$post_id."postCommentInput maxlength=255 placeholder='Write a comment' class='glowing-border comment-input'>
        </div>
        </form>
      </div>
    </div>";
  }

  function makeComment($comment){
    $commenter_id = $comment['commenter_id'];
    $commenter_photo_id = getPhotoId($comment['commenter_id']);
    $commenter_name = getMemberFullName($commenter_id);
    $comment = $comment['comment'];
    return
    "<div class='comment'>
      <img src='actions/getImage.php?image_id=".$commenter_photo_id."' class='poster-img'>
      <a href='#' class='profile-link'>".$commenter_name.":</a>
      <span>".$comment."</span>
    </div>";
  }

  function getComments($post_id){
    $query = "SELECT * FROM comments
              WHERE post_id = '$post_id'
              ORDER BY time DESC";
    $comments = queryMysql($query);
    $html_comments = "";
    foreach($comments as $comment){
      $html_comments .= makeComment($comment);
    }
    return $html_comments;
  }

  function getAdmires(){

  }
?>
