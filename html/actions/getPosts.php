<?php
  require_once("../functions.php");
  require_once("../objects.php");
  if(!isset($_SESSION['member_id'])){
    return;
  }

  function getPosts(){
    $member_id = $_SESSION['member_id'];
    $posts = getPostsForUser($member_id);
    $html_posts = "";
    foreach($posts as $post){
      $html_posts .= makePost($post);
    }
    return $html_posts;
  }

  function getPostsForUser($member_id){
    $query = "SELECT members.member_id FROM members
              JOIN friends
              ON members.member_id = friends.member_id
              OR members.member_id = friends.friend_id
              WHERE members.member_id != '$member_id'
              AND (friends.member_id = '$member_id'
              OR friends.friend_id = '$member_id')";
    $results = queryMysql($query);
    $posts_query = "SELECT * FROM POSTS WHERE "
    foreach($results as $result){
      $condition = "poster_id = '$result['member_id']'";
      if($results->fetch_field() != null){
        $posts_query .= " AND ";
      }
    }
    $posts_query .= " ORDER BY post_id DESC";
    return queryMysql($posts_query);
  }

  function makePost($post){
    $post_content = $post['content'];
    $profile_photo_id = getPhotoId($post['poster_id']);
    $post_id = $post['post_id'];
    return
    "<div class='post'>
      <div>
        <img src='actions/getImage.php?image_id=".$profile_photo_id."' class='poster-img'>
        <a href='#' class='profile-link'>Bill Wilson:</a>
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
