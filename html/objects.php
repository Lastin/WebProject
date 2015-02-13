<?php
  require_once "functions.php";
  class User{
    public $username;
    public $fname;
    public $lname;
    public $city;
    public $country;
    function fetchUserData($username){
      $query = "SELECT * FROM members WHERE username = '$username' LIMIT 1";
      $result = queryMysql($query)->fetch_assoc();
      $this->username = $username;
      $this->fname = $result['fname'];
      $this->lname = $result['lname'];
      $this->city = $result['city'];
      $this->country = $result['country'];
    }

    function getPosts(){

    }

    function getFriends(){
      $query = "SELECT friend_username FROM friends WHERE username = $username";
    }
  }

  class Post{

  }
?>
