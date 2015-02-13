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
      $query = "SELECT members.username, fname, lname, city, country FROM members
                JOIN friends
                ON members.username = friends.friend_username
                WHERE friends.username = '$this->username'
                OR friends.friend_username = '$this->username'";
      $result = queryMysql($query)->fetch_array();
      var_dump($result);
      return $result;
      //SELECT * FROM members JOIN friends ON members.username = friends.friend_username WHERE members.username = 'testaaa';
    }

    function addFriend($username){
      if(!isFriend($username)){
        $query = "INSERT INTO friends
                  VALUES ('$this->username', '$username')";
        queryMysql($query);
      }
      //INSERT INTO friends VALUES ('testaaa', 'testaab');
    }

    function isFriend($username){
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
  }

  class Post{

  }
?>
