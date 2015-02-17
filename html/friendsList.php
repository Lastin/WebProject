<?php
  $user = $_POST['user'];
  $query = "SELECT * FROM members WHERE NOT user = " .$user. ";
  
?>
