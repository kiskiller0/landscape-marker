<?php

class Post
{
    private $dsn;
    private $db = "learning";
    private $host = "localhost";
    private $username = "root";
    private $password = 'bader';
    private $pdo;
    private $batch = 2; // number of posts to fetch per page (pagination)

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
        if ($s->execute([$postData['content'], $postData['userid']])) {
            $lastPostId = $this->pdo->lastInsertId();
            $s = $this->pdo->prepare('SELECT * FROM post WHERE id = ?');
            $s->execute([$lastPostId]);
            return $s->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }


    public function getAllPosts()
    {
        $s = $this->pdo->prepare("SELECT * FROM post");
        $s->execute();
        return $s->fetchAll(); // ? what does it return?
    }


    public function getLastPosts($id = null)
    {
        if ($id) {
            // get posts older than $id
            $sql = "SELECT * FROM post WHERE id < $id ORDER BY id DESC LIMIT " . $this->batch . ";";
            $s = $this->pdo->prepare("SELECT * FROM post WHERE id < ? ORDER BY id DESC LIMIT ?");
            $s->bindValue(1, $id, PDO::PARAM_INT);
            $s->bindValue(2, (int)$this->batch, PDO::PARAM_INT);
            // $s->execute([(int)$id, (int)$this->batch]);
            $s->execute();
            return $s->fetchAll(); // ? what does it return?
        }

        $s = $this->pdo->prepare("SELECT * FROM post ORDER BY id DESC LIMIT " . $this->batch);
        $s->execute();
        return $s->fetchAll(); // ? what does it return?
    }

    public function getLastPost()
    {
        $s = $this->pdo->prepare("SELECT * FROM post ORDER BY id DESC LIMIT 1");
        $s->execute();
        return $s->fetchAll(); // ? what does it return?
    }

    public function getTitleLike($title)
    {
        $s = $this->pdo->prepare("SELECT * FROM post WHERE content LIKE ?");
        $s->execute(["%$title%"]);
        return $s->fetchAll();
    }
}

$post = new Post();
