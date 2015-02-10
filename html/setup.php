<!DOCTYPE html>
<html>
  <head>
    <title>Setting up database</title>
  </head>
  <body>

    <h3>Setting up...</h3>

<?php // Example 26-3: setup.php
  require_once 'functions.php';

  //dropping all tables
  dropTable('members');
  dropTable('messages');
  dropTable('friends');
  dropTable('profiles');

  //creating tables;
  createTable('members',
              'user_id MEDIUMINT NOT NULL AUTO_INCREMENT,
              user VARCHAR(16),
              pass VARCHAR(64),
              INDEX(user(6)),
              PRIMARY KEY (user_id)');

  createTable('messages',
              'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              auth VARCHAR(16),
              recip VARCHAR(16),
              pm CHAR(1),
              time TIMESTAMP,
              message VARCHAR(4096),
              INDEX(auth(6)),
              INDEX(recip(6))');

  createTable('friends',
              'user VARCHAR(16),
              friend VARCHAR(16),
              INDEX(user(6)),
              INDEX(friend(6))');

  createTable('profiles',
              'user VARCHAR(16),
              text VARCHAR(4096),
              INDEX(user(6))');
?>

    <br>...done.
  </body>
</html>
