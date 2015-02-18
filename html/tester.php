<?php
  require_once("functions.php");
  $message = " \n asdaasdasd";
  $regex = "/[^\n\s]+/";
  echo preg_match($regex, $message);
  $trimmed =  trim(" \n  ");
  echo strlen($trimmed);
  echo sanitiseString($trimmed);
?>
