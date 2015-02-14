<?php
  function addFriend($friend_id) {
  if(!isFriend($friend_id)){
    $query = "INSERT INTO friends
    VALUES ('$this->member_id', '$friend_id')";
    queryMysql($query);
  }
?>
