<?php
  session_start();
  require_once("../functions.php");
  if(!isset($_SESSION['member_id']) || !isset($_POST['post_content']) || $_POST['post_content'] == ""){
    return makeWarning("Insufficient data!");
  }
  $post_content = $_POST['post_content'];
  $post_content = trim($post_content);
  $post_content = sanitiseString($post_content);
  $length = strlen($post_content);
  $member_id = $_SESSION['member_id'];
  if($length > 4000){
    return makeWarning("Post is too long");
  }
  if(!validate($post_content)){
    return makeWarning("Post contains not allowed tags or characters");
  }

  $query = "INSERT INTO posts (poster_id, content) VALUES (?, ?)";
  $stmt = makeStmt($query);
  $stmt->bind_param("is", $member_id, $post_content);
  $stmt->execute();
  $post_id = $stmt->insert_id;
  $response = array(
    "success" => 1,
    "post" => makePost()
  );
  echo json_encode($response);

  function makeWarning($message){
    $warning =
    "<div class='postWarning'>
      $message
    </div>";
    $response = array(
      "success" => 0,
      "warning" => $warning
    );
    echo json_encode($response);
    return;

  }

  function makePost(){
    global $post_id;
    global $member_id;
    global $post_content;
    $post_content = str_replace("\\n", "<br>", $post_content);
    $profile_image_id = getProfileImageId($member_id);
    $poster_name = getMemberFullName($member_id);
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
        </div>
        <form class='comment-form' onsubmit='writeComment($post_id, this); return false'>
          <div class='comment-box'>
          <input type='text' name='comment' id=".$post_id."postCommentInput maxlength=4000 placeholder='Write a comment' class='glowing-border comment-input'>
          </div>
        </form>
      </div>
    </div>";
  }

  function validate($post_content){
    return true;
  }
?>
