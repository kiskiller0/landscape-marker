show databases;

create database learning;

use learning;

CREATE TABLE user(
	id INT PRIMARY KEY,
    username VARCHAR(25) UNIQUE NOT NULL,
    password VARCHAR(25) NOT NULL,
    picture VARCHAR(35) DEFAULT 'user.png',
    email VARCHAR(25) UNIQUE NOT NULL
);