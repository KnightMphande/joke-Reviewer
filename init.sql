
CREATE DATABASE db2;

use db2;

 CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY, 
 name VARCHAR(300) NOT NULL, 
 email VARCHAR(50) NOT NULL,
 user_password VARCHAR(50) NOT NULL,
 created_at TIMESTAMP default CURRENT_TIMESTAMP, 
 updated_at TIMESTAMP default CURRENT_TIMESTAMP
 );

 CREATE TABLE jokes (
 id INT PRIMARY KEY,
 setup VARCHAR(30),
 punchline VARCHAR(30)
 );

 CREATE TABLE reviews (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NULL,
 joke_id INT NULL,
 rating INT NOT NULL,
 FOREIGN KEY (user_id) REFERENCES users(id),
 FOREIGN KEY (joke_id) REFERENCES jokes(id)
 );

INSERT INTO users (name, email, user_password)
VALUES ('Knight', 'knight@email.com', 'qwerty');
