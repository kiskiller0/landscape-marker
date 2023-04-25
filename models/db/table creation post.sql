use learning;

drop table post;
drop table comment;

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
    imgsrc VARCHAR(33), -- should be as long as a uuid
    date DATETIME DEFAULT CURRENT_TIMESTAMP
);



