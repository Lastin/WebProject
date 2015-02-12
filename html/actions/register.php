<?php
  require_once("../functions.php");
  if(
    !isset($_POST['username'])  ||
    !isset($_POST['fname'])     ||
    !isset($_POST['lname'])     ||
    !isset($_POST['city'])      ||
    !isset($_POST['country'])   ||
    !isset($_POST['pass1'])     ||
    !isset($_POST['pass2'])
  ) return false;
  $username = sanitiseString($_POST['username']);
  $fname = sanitiseString($_POST['fname']);
  $lname = sanitiseString($_POST['lname']);
  $city = sanitiseString($_POST['city']);
  $country = sanitiseString($_POST['country']);
  $pass1 = sanitiseString($_POST['pass1']);
  $pass2 = sanitiseString($_POST['pass2']);
  if(!checkUserExists($username)){
    if(strcmp($pass1, $pass2) == 0){
      $encrypted = encrypt($pass1);
      $values = '\''. $username  .'\',\''.
                      $encrypted .'\',\''.
                      $fname     .'\',\''.
                      $lname     .'\',\''.
                      $city      .'\',\''.
                      $country   .'\'';
      $query = "INSERT INTO members (username, password, fname, lname, city, country)
                VALUES (". $values .")";
      try{
        queryMysql($query);
        $_SESSION['username'] = $username;
        echo 1;
      } catch(mysqli_sql_exception $e) {
        echo 0;
      }
    }
  }
?>
