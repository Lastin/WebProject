<?php
  session_start();
  require_once("../functions.php");
  if(!isset($_SESSION['member_id']) ||
  !isset($_POST['post_id']) || $_POST['post_id']== "" ||
  !isset($_POST['comment']) || $_POST['comment'] == ""){
    echo composeWarning("insufficient data!");
    return;
  }


  $post_id = sanitiseString($_POST['post_id']);
  $comment = sanitiseString($_POST['comment']);
  $member_id = $_SESSION['member_id'];
  $poster_id = getPosterId();
  $length = strlen($comment);

  if($length > 4000){
    echo composeWarning("Message is too long! Up to 4000 characters");
    return;
  }
  if($member_id == $poster_id || isFriend($member_id, $poster_id)){
    $query = "INSERT INTO comments (post_id, commenter_id, comment)
    VALUES (?, ?, ?)";
    $stmt = makeStmt($query);
    $stmt->bind_param("iis", $post_id, $member_id, $comment);
    $stmt->execute();
    echo composeCommentHTML();
    return;
  } else {
    echo  composeWarning("insufficient priviliges");
    return;
  }

  function getPosterId(){
    global $post_id;
    $query = "SELECT poster_id FROM posts WHERE post_id = ? LIMIT 1";
    $stmt = makeStmt($query);
    $stmt->bind_param("i", $post_id);
    $stmt->bind_result($poster_id);
    $stmt->execute();
    $stmt->fetch();
    return $poster_id;
  }

  function composeCommentHTML(){
    global $comment;
    global $member_id;
    $commenter_photo_id = getProfileImageId($member_id);
    $commenter_name = getMemberFullName($member_id);
    return
    "<div class='comment'>
      <img src='actions/getImage.php?image_id=".$commenter_photo_id."' class='poster-img'>
      <a href='#' class='profile-link'>".$commenter_name.":</a>
      <span>".$comment."</span>
    </div>";
  }

  function composeWarning($message){
    return
    "<div class='comment'>
      <bold><span style='color: red'>".$message."</span></bold>
    </div>";
  }
?>
