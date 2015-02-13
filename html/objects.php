<?php
  require_once "functions.php";
  class Member {
    public $member_id;
    public $username;
    public $fname;
    public $lname;
    public $city;
    public $country;
    function fetchUserData($member_id) {
      $query = "SELECT * FROM members WHERE member_id = '$member_id' LIMIT 1";
      $result = queryMysql($query)->fetch_assoc();
      $this->member_id = $member_id;
      $this->username = $result['username'];
      $this->fname = $result['fname'];
      $this->lname = $result['lname'];
      $this->city = $result['city'];
      $this->country = $result['country'];
    }

    function getPosts() {

    }

    function getFriends() {
      $friends = array();
      $query = "SELECT * FROM members
                JOIN friends
                ON members.member_id = friends.friend_id
                WHERE friends.member_id = '$this->member_id'
                OR friends.friend_id = '$this->member_id'";
      $results = queryMysql($query);
      foreach($results as $result){
        array_push($friends, $this->arrayToMember($result));
      }
      return $friends;
      //SELECT * FROM members JOIN friends ON members.username = friends.friend_username WHERE members.username = 'testaaa';
    }

    function arrayToMember($array) {
      $member = new Member;
      $member->member_id = $array['friend_id'];
      $member->username = $array['username'];
      $member->fname = $array['fname'];
      $member->lname = $array['lname'];
      $member->city = $array['city'];
      $member->country = $array['country'];
      return $member;
    }

    function addFriend($friend_id) {
      if(!isFriend($friend_id)){
        $query = "INSERT INTO friends
                  VALUES ('$this->member_id', '$friend_id')";
        queryMysql($query);
      }
      //INSERT INTO friends VALUES ('testaaa', 'testaab');
    }

    function isFriend($someones_id) {
      $query = "SELECT 1 FROMusername friends
                WHERE member_id = '$this->member_id'
                AND friend_id = '$someones_id'
                OR member_id = '$someones_id'
                AND friend_id = '$this->username'";
      $result = queryMysql($query);
      if(mysqli_num_rows($result) < 1)
        return false;
      return true;
    }

    function fetchImage(){
      $query = "SELECT image FROM images
                WHERE owner_id = '$this->member_id'";
      $result = queryMysql($query);
      if(mysqli_num_rows($result) < 1)
        $result = $this->fetchDefaultImage();
      $result = $result->fetch_assoc();
      return base64_encode($result['image']);
    }

    function fetchDefaultImage(){
      $query = "SELECT image FROM images
                WHERE image_id = 1";
      $result = queryMysql($query);
      return $result;
    }

    function fetchMessages(){
      $messages = array();
      $query = "SELECT * FROM messages
                WHERE receiver_id = '$this->member_id'
                OR sender_id = '$this->member_id'
                ORDER BY time DESC";
      $results = queryMysql($query);
      foreach($results as $result){
        $message = new Message;
        $message->arrayToMessage($result);
        array_push($messages, $message);
      }
      return $messages;
    }
  }

  class Post {

  }

  class Message {
    public $message_id;
    public $sender_username;
    public $receiver_username;
    public $sender_full_name;
    public $time;
    public $message;
    public $isread;
    function arrayToMessage($array){
      $this->message_id = $array['message_id'];
      $this->sender_id = $array['sender_id'];
      $this->receiver_id = $array['receiver_id'];
      $this->time = $array['time'];
      $this->message = $array['message'];
      $this->isread = $array['isread'];
      $this->sender_full_name = $this->fetchUserFullName();
    }

    function fetchUserFullName(){
      $query = "SELECT fname, lname
                FROM members
                WHERE member_id = '$this->sender_id' LIMIT 1";
      $result = queryMysql($query)->fetch_assoc();
      return $result['fname'] . " " . $result['lname'];
    }
  }
?>
