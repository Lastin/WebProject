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
              password VARCHAR(61) NOT NULL,
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
              CONSTRAINT friend_user_fk
                FOREIGN KEY (username)
                REFERENCES members(username),
              CONSTRAINT users_friend_fk
                FOREIGN KEY (friend_username)
                REFERENCES members(username),
              PRIMARY KEY (username, friend_username)');

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

  $password_aaaaaa = "\$2y\$10\$D8bEv8JE97lJvlNFDh3PD.nn0j/L3V58CXk7WGW.CKFvhYzxIC4ly";
  $message = "some long message some long message some long message some long message some long message
  ";
  queryMysql("INSERT INTO members VALUES ('restricted', 'restrictedrestrictedrestricted', null, null, null, null)");
  queryMysql("INSERT INTO images (owner_username, image) VALUES ('restricted', '".mysql_escape_string(file_get_contents('images/default.png'))."')");
  queryMysql("INSERT INTO members VALUES ('user1', '$password_aaaaaa', 'name1', 'lname1', null, null)");
  queryMysql("INSERT INTO members VALUES ('user2', '$password_aaaaaa', 'name2', 'lname2', null, null)");
  queryMysql("INSERT INTO members VALUES ('user3', '$password_aaaaaa', 'name3', 'lname3', null, null)");
  queryMysql("INSERT INTO members VALUES ('user4', '$password_aaaaaa', 'name4', 'lname4', null, null)");
  queryMysql("INSERT INTO members VALUES ('user5', '$password_aaaaaa', 'name5', 'lname5', null, null)");
  queryMysql("INSERT INTO members VALUES ('user6', '$password_aaaaaa', 'name6', 'lname6', null, null)");
  queryMysql("INSERT INTO members VALUES ('user7', '$password_aaaaaa', 'name7', 'lname7', null, null)");
  queryMysql("INSERT INTO members VALUES ('user8', '$password_aaaaaa', 'name8', 'lname8', null, null)");
  queryMysql("INSERT INTO members VALUES ('user9', '$password_aaaaaa', 'name9', 'lname9', null, null)");
  queryMysql("INSERT INTO members VALUES ('user10', '$password_aaaaaa', 'name10', 'lname10', null, null)");
  queryMysql("INSERT INTO friends VALUES ('user1', 'user2')");
  queryMysql("INSERT INTO friends VALUES ('user1', 'user3')");
  queryMysql("INSERT INTO friends VALUES ('user1', 'user4')");
  queryMysql("INSERT INTO friends VALUES ('user2', 'user3')");
  queryMysql("INSERT INTO friends VALUES ('user2', 'user4')");
  queryMysql("INSERT INTO friends VALUES ('user2', 'user5')");
  queryMysql("INSERT INTO friends VALUES ('user3', 'user4')");
  queryMysql("INSERT INTO friends VALUES ('user3', 'user5')");
  queryMysql("INSERT INTO friends VALUES ('user3', 'user6')");
  queryMysql("INSERT INTO messages (sender_username, receiver_username, message) VALUES ('user1', 'user2', '$message')");
  queryMysql("INSERT INTO messages (sender_username, receiver_username, message) VALUES ('user1', 'user2', '$message')");
  queryMysql("INSERT INTO messages (sender_username, receiver_username, message) VALUES ('user1', 'user2', '$message')");
  queryMysql("INSERT INTO messages (sender_username, receiver_username, message) VALUES ('user1', 'user2', '$message')");
  queryMysql("INSERT INTO messages (sender_username, receiver_username, message) VALUES ('user1', 'user2', '$message')");
  queryMysql("INSERT INTO messages (sender_username, receiver_username, message) VALUES ('user1', 'user2', '$message')");
  queryMysql("INSERT INTO messages (sender_username, receiver_username, message) VALUES ('user1', 'user2', '$message')");
  echo "sample data added";
?>

    <br>...done.
  </body>
</html>
