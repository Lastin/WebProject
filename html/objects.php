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
      $query = "SELECT fname, lname, city, country FROM members WHERE member_id = ? LIMIT 1";
      $stmt = makeStmt($query);
      $stmt->bind_param("i", $member_id);
      $stmt->bind_result($fname, $lname, $city, $country);
      $stmt->execute();
      $stmt->fetch();
      $this->member_id = $member_id;
      $this->fname = $fname;
      $this->lname = $lname;
      $this->city = $city;
      $this->country = $country;
    }

    function getPosts() {

    }

    function getFriends() {
      $friends = array();
      $query = "SELECT members.member_id, members.fname, members.lname
                FROM members
                JOIN friends
                ON members.member_id = friends.member_id
                OR members.member_id = friends.friend_id
                WHERE members.member_id != ?
                AND (friends.member_id = ?
                OR friends.friend_id = ?)";
      $stmt = makeStmt($query);
      $stmt->bind_param("iii", $this->member_id, $this->member_id, $this->member_id);
      $stmt->bind_result($member_id, $fname, $lname);
      $stmt->execute();
      while($stmt->fetch()){
        $friend = new Friend();
        $friend->member_id = $member_id;
        $friend->fname = $fname;
        $friend->lname = $lname;
        array_push($friends, $friend);
      }
      return $friends;
    }

    function fetchAllMessages(){
      $messages = array();
      $query = "SELECT * FROM messages
                WHERE receiver_id = ?
                OR sender_id = ?
                ORDER BY time DESC";
      $stmt = makeStmt($query);
      $stmt->bind_param("ii", $this->member_id, $this->member_id);
      $stmt->bind_result($message_id, $sender_id, $receiver_id, $time, $content, $isread);
      $stmt->execute();
      while($stmt->fetch()){
        $message = new Message();
        $message->message_id = $message_id;
        $message->sender_id = $sender_id;
        $message->receiver_id = $receiver_id;
        $message->time = $time;
        $message->message = $content;
        $message->isread = $isread;
        array_push($messages, $message);
      }
      return $messages;
    }
  }

  class Message {
    public $message_id;
    public $sender_username;
    public $receiver_username;
    public $time;
    public $message;
    public $isread;
  }

  class Friend {
    public $member_id;
    public $fname;
    public $lname;
  }
?>
