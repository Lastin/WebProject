<?php // Example 26-1: functions.php
  $dbhost  = 'localhost';       // Unlikely to require changing
  $dbname  = 'test';           // Modify these...
  $dbuser  = 'localhost';           // ...variables according
  $dbpass  = '';           // ...to your installation
  $appname = "Social Network";  // ...and preference

  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($connection->connect_error) die($connection->connect_error);

  function createTable($name, $query)
  {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
  }

  function dropTable($name){
    queryMysql("DROP TABLE IF EXISTS $name");
    echo "Table '$name' dropped or doesn't exist.<br>";
  }

  function queryMysql($query)
  {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    return $result;
  }

  function destroySession()
  {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
  }

  function sanitizeString($var)
  {
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $connection->real_escape_string($var);
  }

  function showProfile($user)
  {
    if (file_exists("$user.jpg"))
      echo "<img src='$user.jpg' style='float:left;'>";

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if ($result->num_rows)
    {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
    }
  }

  function registerUser($user, $password){
    $encrypted = encrypt($password);
    queryMysql("INSERT INTO members(user, pass) VALUES('$user', '$encrypted')");
  }

  function encrypt($password){
    $options = [
      'cost' => 10,
      'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
    ];
    return password_hash($password, PASSWORD_BCRYPT, $options);
  }
?>
