<?php
$dbhost  = '';
$dbname  = '';
$dbuser  = '';
$dbpass  = ''; //stop changing password nav
$appname = "Social Network";

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error) die($connection->connect_error);

function createTable($name, $query) {
  queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
  echo "Table '$name' created or already exists.<br>";
}

function dropTable($name) {
  queryMysql("DROP TABLE IF EXISTS $name");
  echo "Table '$name' dropped or doesn't exist.<br>";
}

function queryMysql($query) {
  global $connection;
  $result = $connection->query($query);
  if (!$result) die($connection->error);
  return $result;
}

function queryMysqlGetInsertId($query){
  global $connection;
  $result = $connection->query($query);
  if (!$result) die($connection->error);
  return $connection->insert_id;
}

function destroySession() {
  $_SESSION = array();
  if (session_id() != "" || isset($_COOKIE[session_name()]))
  setcookie(session_name(), '', time()-3600, '/');
  session_destroy();
}

function sanitiseString($var) {
  global $connection;
  $var = strip_tags($var);
  $var = htmlentities($var);
  $var = stripslashes($var);
  return $connection->real_escape_string($var);
}

function encrypt($password) {
  $options = array(
    'cost' => 10,
    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
  );
  return password_hash($password, PASSWORD_BCRYPT, $options);
}

function makeStmt($query){
  global $connection;
  $stmt = $connection->stmt_init();
  $stmt->prepare($query);
  return $stmt;
}

function checkUserExists($username) {
  $query = "SELECT 1 FROM members WHERE username = ? LIMIT 1";
  $stmt = makeStmt($query);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  //$stmt->store_result();
  if($stmt->fetch())
    return 1;
  return 0;
}

function getProfileImageId($member_id){
  $query = "SELECT image_id FROM images
            WHERE owner_id = ?";
  $stmt = makeStmt($query);
  $stmt->bind_param("i", $member_id);
  $stmt->bind_result($image_id);
  $stmt->execute();
  if($stmt->fetch())
    return $image_id;
  return 1;
}

function getMemberFullName($member_id){
  $query = "SELECT fname, lname FROM members WHERE member_id = ? LIMIT 1";
  $stmt = makeStmt($query);
  $stmt->bind_param("i", $member_id);
  $stmt->bind_result($fname, $lname);
  $stmt->execute();
  $stmt->fetch();
  return $fname ." ". $lname;
}

function getMemberLocation($member_id){
  $query = "SELECT city, country FROM members WHERE member_id = ? LIMIT 1";
  $stmt = makeStmt($query);
  $stmt->bind_param("i", $member_id);
  $stmt->bind_result($city, $country);
  $stmt->execute();
  $stmt->fetch();
  if($city == "" && $country == ""){
    return "Unknown";
  }
  if($city == ""){
    return $country;
  }
  if($country == ""){
    return $city;
  }
  return $city .", ". $country;
}

function isFriend($member_id, $someones_id) {
  $query = "SELECT 1 FROM friends
            WHERE (member_id = ?
            AND friend_id = ?)
            OR (member_id = ?
            AND friend_id = ?)";
  $stmt = makeStmt($query);
  $stmt->bind_param("ssss", $member_id, $someones_id, $someones_id, $member_id);
  $stmt->execute();
  if($stmt->fetch())
    return true;
  return false;
}

function confirmFriendship($member_id, $friend_id){
  if(removeRequest($member_id, $friend_id) > 0 && $friend_id != $member_id){
    $query = "INSERT INTO friends (member_id, friend_id)
              VALUES (?, ?)";
    $stmt = makeStmt($query);
    $stmt->bind_param("ii", $member_id, $friend_id);
    $stmt->execute();
    return $stmt->affected_rows;
  }
  return 0;
}

function removeRequest($member_id, $friend_id){
  $query = "DELETE FROM friend_requests
            WHERE (requester_id = ? AND friend_id = ?)
            OR (friend_id = ? AND requester_id = ?)";
  $stmt = makeStmt($query);
  $stmt->bind_param("iiii", $member_id, $friend_id, $member_id, $friend_id);
  $stmt->execute();
  return $stmt->affected_rows;
}

function searchRequests($member_id, $friend_id){
  $query = "SELECT requester_id FROM friend_requests
            WHERE (requester_id = ? AND friend_id = ?)
            OR (friend_id = ? AND requester_id = ?)";
  $stmt = makeStmt($query);
  $stmt->bind_param("iiii", $friend_id, $member_id, $friend_id, $member_id);
  $stmt->bind_result($requester_id);
  $stmt->execute();
  $stmt->fetch();
  return $requester_id;
}

function getInvites($member_id){
  $query = "SELECT requester_id FROM friend_requests
            WHERE friend_id = ?";
  $stmt = makeStmt($query);
  $stmt->bind_param("i", $member_id);
  return $stmt;
}

?>
