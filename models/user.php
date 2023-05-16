<?php

class user
{
    private $dsn;
    private $db = "learning";
    private $host = "localhost";
    private $username = "root";
    private $password = 'bader';
    private $pdo;
    private $minUsernameLength = 4;
    private $minPasswordLength = 4;

    public function __construct()
    {
        $this->dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db;
        $this->pdo = new PDO($this->dsn, $this->username, $this->password);
    }

    public function getByUsername($username)
    {
        $s = $this->pdo->prepare("SELECT * FROM user WHERE username = ?");
        $s->execute([$username]);
        return $s->fetch();
    }

    public function getUsernameLike($username)
    {
        $s = $this->pdo->prepare("SELECT * FROM user WHERE username LIKE ?");
        $s->execute(["%$username%"]);
        return $s->fetchAll();
    }

    public function getById($id)
    {
        $s = $this->pdo->prepare("SELECT * FROM user WHERE id = ?");
        $s->execute([$id]);
        return $s->fetch();
    }

    public function getByUsernameAndPassword($username, $password)
    {
        // this is redundant!
        $user = $this->getByUsername($username);
        if ($user['password'] == $password) {
            return $user;
        }
        return false;
    }

    public function getByEmail($email)
    {
        $s = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
        $s->execute([$email]);
        return $s->fetch();
    }

    public function verifyUsername($username)
    {
        // TODO: []- provide the reason for refusal as in: username already in use!
        return $username && !$this->getByUsername($username) && strlen($username) >= $this->minUsernameLength;
    }

    public function verifyEmail($email)
    {
        // return !$this->getByUsername($username) && strlen($username) >= $this->minUsernameLength;
        // TODO: []- provide the reason for refusal as in: email already in use!
        return $email && !$this->getByEmail($email);
    }

    public function verifyPassword($password)
    {
        // return !$this->getByUsername($username) && strlen($username) >= $this->minUsernameLength;
        // TODO: []- provide the reason for refusal as in: password too short
        return $password && strlen($password) >= $this->minPasswordLength;
    }


    private function createUser($userData)
    {
        // should only be called by inner methods:
        $s = $this->pdo->prepare("INSERT INTO user(username, email, password, picture) VALUES(?, ?, ?, ?)");
        // $s->execute([$username = $userData['username'], $email = $userData['email'], $password = $userData['password']]); // does it asign the values to the variables and make them visible in this whole scope?
        $s->execute([$userData['username'], $userData['email'], $userData['password'], $userData['picture']]);
        return $s->fetch(); // ? what does it return?
    }


    public function addUser($userData)
    {

        $username = in_array('username', array_keys($userData)) ? $userData['username'] : null;
        $password = in_array('password', array_keys($userData)) ? $userData['password'] : null;
        $email = in_array('email', array_keys($userData)) ? $userData['email'] : null;
        $picture = in_array('picture', array_keys($userData)) ? $userData['picture'] : null;

        if (!$this->verifyUsername($username)) {
            return ['error' => true, 'msg' => 'username doesn\'t meet criteria!'];
        }

        if (!$this->verifyPassword($password)) {
            return ['error' => true, 'msg' => 'password doesn\'t meet criteria!'];
        }

        if (!$this->verifyEmail($email)) {
            // #TODO: verifyEmail returns a message telling you the reason just like addUser does!
            return ['error' => true, 'msg' => 'email doesn\'t meet criteria!'];
        }

        $this->createUser($userData);
        return ['error' => false, 'msg' => 'created user' . $userData["username"] . ' correctly!'];
    }

    #TODO: profile pic is just a boolean: true of fals, if true fetch /public/profiles/username.png else fetch default.png
}

$User = new user();
// var_dump($User->addUser($_POST));
