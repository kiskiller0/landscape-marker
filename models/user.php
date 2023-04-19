<?php
class user
{
  private $dsn;
  private $db = "learning";
  private $host = "localhost";
  private $username = "root";
  private $password = '';
  private $pdo;
  private $minUsernameLength = 10;
  private $minPasswordLength = 12;

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

  public function getByEmail($email)
  {
    $s = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
    $s->execute([$email]);
    return $s->fetch();
  }

  public function verifyUsername($username)
  {
    return !$this->getByUsername($username) && strlen($username) >= $this->minUsernameLength;
  }

  public function verifyEmail($email)
  {
    // return !$this->getByUsername($username) && strlen($username) >= $this->minUsernameLength;
    return !$this->getByEmail($email);
  }

  public function verifyPassword($password)
  {
    // return !$this->getByUsername($username) && strlen($username) >= $this->minUsernameLength;
    return strlen($password) >= $this->minPasswordLength;
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
    $username = $userData['username'];
    $password = $userData['password'];
    $email = $userData['email'];
    $picture = $userData['picture'];

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
