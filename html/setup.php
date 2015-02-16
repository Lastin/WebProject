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
              'member_id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
              username VARCHAR(32) NOT NULL,
              password VARCHAR(61) NOT NULL,
              fname VARCHAR(255),
              lname VARCHAR(255),
              city VARCHAR(255),
              country VARCHAR(255)');

  createTable('messages',
              'message_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              sender_id MEDIUMINT NOT NULL,
              receiver_id MEDIUMINT NOT NULL,
              time TIMESTAMP,
              message VARCHAR(4096),
              isread TINYINT(1) DEFAULT 0,
              CONSTRAINT message_sender_fk
                FOREIGN KEY (sender_id)
                REFERENCES members(member_id)
                ON DELETE CASCADE,
              CONSTRAINT message_receiver_fk
                FOREIGN KEY (receiver_id)
                REFERENCES members(member_id)
                ON DELETE CASCADE');

  createTable('friends',
              'member_id MEDIUMINT NOT NULL,
              friend_id MEDIUMINT NOT NULL,
              CONSTRAINT friend_user_fk
                FOREIGN KEY (member_id)
                REFERENCES members(member_id),
              CONSTRAINT users_friend_fk
                FOREIGN KEY (friend_id)
                REFERENCES members(member_id),
              PRIMARY KEY (member_id, friend_id)');

  createTable('posts',
              'post_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              time TIMESTAMP,
              poster_id MEDIUMINT NOT NULL,
              content VARCHAR(4096),
              CONSTRAINT poster_fk
                FOREIGN KEY (poster_id)
                REFERENCES members(member_id)');

  createTable('admires',
              'post_id INT UNSIGNED NOT NULL,
              admirer_id MEDIUMINT NOT NULL,
              CONSTRAINT post_fk
                FOREIGN KEY (post_id)
                REFERENCES posts(post_id),
              CONSTRAINT admirer_fk
                FOREIGN KEY (admirer_id)
                REFERENCES members(member_id)');

  createTable('comments',
              'comment_id INT UNSIGNED NOT NULL PRIMARY KEY,
              post_id INT UNSIGNED NOT NULL,
              commenter_id MEDIUMINT NOT NULL,
              comment VARCHAR(4096),
              time TIMESTAMP,
              CONSTRAINT commenter_fk
                FOREIGN KEY (commenter_id)
                REFERENCES members(member_id)');

  createTable('images',
              'image_id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
              owner_id MEDIUMINT NOT NULL,
              image BLOB,
              CONSTRAINT image_owner_fk
                FOREIGN KEY (owner_id)
                REFERENCES members(member_id)');

  $password_aaaaaa = "\$2y\$10\$D8bEv8JE97lJvlNFDh3PD.nn0j/L3V58CXk7WGW.CKFvhYzxIC4ly";
  $message = "test message from setup file";
  queryMysql("INSERT INTO members (username, password)
              VALUES ('restricted', 'wont_get_in')");
  queryMysql("INSERT INTO images (owner_id, image) VALUES (1, '".mysql_escape_string(file_get_contents('images/default.jpg'))."')");
  queryMysql("INSERT INTO members (username, password, fname, lname) VALUES ('user1', '$password_aaaaaa', 'name1', 'lname1')");
  queryMysql("INSERT INTO members (username, password, fname, lname) VALUES ('user2', '$password_aaaaaa', 'name2', 'lname2')");
  queryMysql("INSERT INTO members (username, password, fname, lname) VALUES ('user3', '$password_aaaaaa', 'name3', 'lname3')");
  queryMysql("INSERT INTO members (username, password, fname, lname) VALUES ('user4', '$password_aaaaaa', 'name4', 'lname4')");
  queryMysql("INSERT INTO members (username, password, fname, lname) VALUES ('user5', '$password_aaaaaa', 'name5', 'lname5')");
  queryMysql("INSERT INTO members (username, password, fname, lname) VALUES ('user6', '$password_aaaaaa', 'name6', 'lname6')");
  queryMysql("INSERT INTO members (username, password, fname, lname) VALUES ('user7', '$password_aaaaaa', 'name7', 'lname7')");
  queryMysql("INSERT INTO members (username, password, fname, lname) VALUES ('user8', '$password_aaaaaa', 'name8', 'lname8')");
  queryMysql("INSERT INTO members (username, password, fname, lname) VALUES ('user9', '$password_aaaaaa', 'name9', 'lname9')");
  queryMysql("INSERT INTO members (username, password, fname, lname) VALUES ('user10', '$password_aaaaaa', 'name10', 'lname10')");

  queryMysql("INSERT INTO friends VALUES (2, 3)");
  queryMysql("INSERT INTO friends VALUES (2, 4)");
  queryMysql("INSERT INTO friends VALUES (2, 5)");
  queryMysql("INSERT INTO friends VALUES (3, 4)");
  queryMysql("INSERT INTO friends VALUES (3, 5)");
  queryMysql("INSERT INTO friends VALUES (3, 6)");
  queryMysql("INSERT INTO friends VALUES (4, 6)");
  queryMysql("INSERT INTO friends VALUES (4, 7)");
  queryMysql("INSERT INTO friends VALUES (4, 8)");


  queryMysql("INSERT INTO messages (sender_id, receiver_id, message) VALUES (2, 3, '$message')");
  queryMysql("INSERT INTO messages (sender_id, receiver_id, message) VALUES (2, 3, '$message')");
  queryMysql("INSERT INTO messages (sender_id, receiver_id, message) VALUES (2, 3, '$message')");
  queryMysql("INSERT INTO messages (sender_id, receiver_id, message) VALUES (2, 3, '$message')");
  queryMysql("INSERT INTO messages (sender_id, receiver_id, message) VALUES (2, 3, '$message')");
  queryMysql("INSERT INTO messages (sender_id, receiver_id, message) VALUES (2, 3, '$message')");
  queryMysql("INSERT INTO messages (sender_id, receiver_id, message) VALUES (2, 3, '$message')");
  echo "sample data added";
?>

    <br>...done.
  </body>
</html>
