<?php
  if(isset($_SESSION['user_id'])){
    destroy_session();
  }
  location('index.php');
?>
