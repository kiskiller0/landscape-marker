USE learning;

DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS user;


CREATE TABLE user(
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(25) UNIQUE NOT NULL,
    password VARCHAR(25) NOT NULL,
    picture VARCHAR(35) DEFAULT 'user.png',
    email VARCHAR(25) UNIQUE NOT NULL
);

CREATE TABLE post(
    id INT PRIMARY KEY AUTO_INCREMENT,
    userid INT REFERENCES user(id),
    content VARCHAR(255),
    date DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE comment(
    id INT PRIMARY KEY AUTO_INCREMENT,
    userid INT REFERENCES user(id),
    postid INT REFERENCES post(id),
    cotent VARCHAR(255),
    imgsrc VARCHAR(33),
    -- should be as long as a uuid
    date DATETIME DEFAULT CURRENT_TIMESTAMP
);