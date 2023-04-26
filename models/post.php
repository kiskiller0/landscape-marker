<?php
class Post
{
  private $dsn;
  private $db = "learning";
  private $host = "localhost";
  private $username = "root";
  private $password = '';
  private $pdo;
  private $batch = 15; // number of posts to fetch per page (pagination)

  public function __construct()
  {
    $this->dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db;
    $this->pdo = new PDO($this->dsn, $this->username, $this->password);
  }

  public function getByUserid($userid)
  {
    $s = $this->pdo->prepare("SELECT * FROM post WHERE userid = ?");
    $s->execute([$userid]);
    return $s->fetch();
  }

  public function createPost($postData)
  {
    $s = $this->pdo->prepare("INSERT INTO post(content, userid) VALUES(?, ?)");
    $s->execute([$postData['content'], $postData['userid']]);
    return $s->fetch(); // ? what does it return?
  }

  public function addPost($postData)
  {
    // is it plausible to verify userid and stuff? since it is in the session anyway?
  }

  public function getAllPosts()
  {
    $s = $this->pdo->prepare("SELECT * FROM post");
    $s->execute();
    return $s->fetchAll(); // ? what does it return?
  }

  public function getPosts($page)
  {
    $s = $this->pdo->prepare("SELECT * FROM post LIMIT " . $this->batch . ", " . $page * $this->batch);
    $s->execute();
    return $s->fetchAll(); // ? what does it return?
  }
}

$post = new Post();