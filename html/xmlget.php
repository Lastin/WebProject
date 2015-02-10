<?php // xmlget.php
  if (isset($_GET['url']))
  {
    // Send raw HTTP header
    header('Content-Type: text/xml');
    // Send contents of xml file
    $file = "http://".sanitizeString($_GET['url']);
    echo file_get_contents($file);
  }

  function sanitizeString($var)
  {
    $var = strip_tags($var);    // Del HTML/PHP tags
    $var = htmlentities($var);  // <b> -> &lt;b&gt;
    return stripslashes($var);  // It\'s -> It's
  }
?>