<?php
  session_start();
  if(isset($_SESSION['member_id'])){
    session_destroy();
  }
  header('Location: ../index.php');
?>
