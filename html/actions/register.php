<?php
  session_start();
  require_once("../functions.php");
  if(
    !isset($_POST['username'])  ||
    !isset($_POST['fname'])     ||
    !isset($_POST['lname'])     ||
    !isset($_POST['city'])      ||
    !isset($_POST['country'])   ||
    !isset($_POST['pass1'])     ||
    !isset($_POST['pass2'])
  ) header("Location: ../index.php");
  $username = sanitiseString($_POST['username']);
  $fname = sanitiseString($_POST['fname']);
  $lname = sanitiseString($_POST['lname']);
  $city = sanitiseString($_POST['city']);
  $country = sanitiseString($_POST['country']);
  $pass1 = sanitiseString($_POST['pass1']);
  $pass2 = sanitiseString($_POST['pass2']);

  $username_l = strlen($username);
  $fname_l = strlen($fname);
  $lname_l = strlen($lname);
  $pass1_l = strlen($pass1);

  if($pass1 == $pass2) {
    if($pass1_l >= 6 && $pass1_l <= 16) {
      if($username_l >=3 && $username_l <= 32){
        if($fname_l >= 3 && $fname_l <= 255){
          if($lname_l >= 3 && $lname_l <= 255){
            if(!checkUserExists($username)){
              $query = "INSERT INTO members (username, password, fname, lname, city, country)
                        VALUES (?, ?, ?, ?, ?, ?)";
              $stmt = makeStmt($query);
              $stmt->bind_param("ssssss", $username, $pass1, $fname, $lname, $city, $country);
              $stmt->execute();
              $member_id = $stmt->insert_id;
              $_SESSION['member_id'] = $member_id;
              echo 1;
              return;
            }
          }
        }
      }
    }
  }
  echo 0;
  return;
?>
