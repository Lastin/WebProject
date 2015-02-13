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
  dropTable('messages');
  dropTable('friends');
  dropTable('admires');
  dropTable('comments');
  dropTable('posts');
  dropTable('images');
  dropTable('members');

  //creating tables;
  createTable('members',
              'username VARCHAR(32) NOT NULL PRIMARY KEY,
              password VARCHAR(61),
              fname VARCHAR(255),
              lname VARCHAR(255),
              city VARCHAR(255),
              country VARCHAR(255)');

  createTable('messages',
              'message_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              sender_username VARCHAR(32) NOT NULL,
              receiver_username VARCHAR(32) NOT NULL,
              time TIMESTAMP,
              message VARCHAR(4096),
              isread TINYINT(1) DEFAULT 0,
              CONSTRAINT message_sender_fk
                FOREIGN KEY (sender_username)
                REFERENCES members(username)
                ON DELETE CASCADE,
              CONSTRAINT message_receiver_fk
                FOREIGN KEY (receiver_username)
                REFERENCES members(username)
                ON DELETE CASCADE');

  createTable('friends',
              'username VARCHAR(32) NOT NULL,
              friend_username VARCHAR(32) NOT NULL,
              CONSTRAINT friend_uMEDIUMINTser_fk
                FOREIGN KEY (username)
                REFERENCES members(username),
              CONSTRAINT users_friend_fk
                FOREIGN KEY (friend_username)
                REFERENCES members(username)');

  createTable('posts',
              'post_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              time TIMESTAMP,
              poster_username VARCHAR(32) NOT NULL,
              content VARCHAR(4096),
              CONSTRAINT poster_fk
                FOREIGN KEY (poster_username)
                REFERENCES members(username)');

  createTable('admires',
              'post_id INT UNSIGNED NOT NULL,
              admirer_username VARCHAR(32) NOT NULL,
              CONSTRAINT post_fk
                FOREIGN KEY (post_id)
                REFERENCES posts(post_id),
              CONSTRAINT admirer_fk
                FOREIGN KEY (admirer_username)
                REFERENCES members(username)');

  createTable('comments',
              'post_id INT UNSIGNED NOT NULL,
              commenter_username VARCHAR(32) NOT NULL,
              time TIMESTAMP,
              INDEX(post_id),
              CONSTRAINT commenter_fk
                FOREIGN KEY (commenter_username)
                REFERENCES members(username)');

  createTable('images',
              'image_id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
              owner_username VARCHAR(32) NOT NULL,
              image BLOB,
              CONSTRAINT image_owner_fk
                FOREIGN KEY (owner_username)
                REFERENCES members(username)');
?>

    <br>...done.
  </body>
</html>
