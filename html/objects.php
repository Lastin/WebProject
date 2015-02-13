<?php
  require_once "functions.php";
  class Member {
    public $username;
    public $fname;
    public $lname;
    public $city;
    public $country;
    function fetchUserData($username) {
      $query = "SELECT * FROM members WHERE username = '$username' LIMIT 1";
      $result = queryMysql($query)->fetch_assoc();
      $this->username = $username;
      $this->fname = $result['fname'];
      $this->lname = $result['lname'];
      $this->city = $result['city'];
      $this->country = $result['country'];
    }

    function getPosts() {

    }

    function getFriends() {
      $friends = array();
      $query = "SELECT members.username, fname, lname, city, country FROM members
                JOIN friends
                ON members.username = friends.friend_username
                WHERE friends.username = '$this->username'
                OR friends.friend_username = '$this->username'";
      $results = queryMysql($query);
      foreach($results as $result){
        array_push($friends, $this->arrayToMember($result));
      }
      return $friends;
      //SELECT * FROM members JOIN friends ON members.username = friends.friend_username WHERE members.username = 'testaaa';
    }

    function arrayToMember($array) {
      $member = new Member;
      $member->username = $array['username'];
      $member->fname = $array['fname'];
      $member->lname = $array['lname'];
      $member->city = $array['city'];
      $member->country = $array['country'];
      return $member;
    }

    function addFriend($username) {
      if(!isFriend($username)){
        $query = "INSERT INTO friends
                  VALUES ('$this->username', '$username')";
        queryMysql($query);
      }
      //INSERT INTO friends VALUES ('testaaa', 'testaab');
    }

    function isFriend($username) {
      $query = "SELECT 1 FROM friends
                WHERE username = '$this->username'
                AND friend_username = '$username'
                OR username = '$username'
                AND friend_isername = '$this->username'";
      $result = queryMysql($query);
      if(mysqli_num_rows($result) < 1)
        return false;
      return true;
    }

    function fetchImage(){
      $query = "SELECT image FROM images
                WHERE owner_username = '$this->username'";
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

    function getMessages(){
      return "";
    }
  }

  class Post{

  }
?>
