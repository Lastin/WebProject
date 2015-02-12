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
              username VARCHAR(16),
              password VARCHAR(61),
              fname VARCHAR(255),
              lname VARCHAR(255),
              city VARCHAR(255),
              country VARCHAR(255),
              INDEX(username),
              PRIMARY KEY (user_id, username)');

  createTable('messages',
              'message_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              sender_id MEDIUMINT NOT NULL,
              receiver_id MEDIUMINT NOT NULL,
              time TIMESTAMP,
              message VARCHAR(4096),
              INDEX(sender_id),
              INDEX(receiver_id)');

  createTable('friends',
              'user_id MEDIUMINT NOT NULL,
              friend_id MEDIUMINT NOT NULL,
              INDEX(user_id),
              INDEX(friend_id)');

  createTable('posts',
              'post_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              time TIMESTAMP,
              poster_id MEDIUMINT NOT NULL,
              content VARCHAR(4096)');

  createTable('comments',
              'post_id INT UNSIGNED NOT NULL,
              time TIMESTAMP,
              INDEX(post_id)');

  createTable('images',
              'image_id MEDIUMINT NOT NULL AUTO_INCREMENT,
              user_id MEDIUM INT NOT NULL,
              image BLOB');
?>

    <br>...done.
  </body>
</html>
