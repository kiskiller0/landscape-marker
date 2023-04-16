<?php


$host = "localhost";
$user = "root";
$pass = "";
$db = "learning";
$table = "user";
// DSN: data source name:
$dsn = "mysql:host=" . $host . ";dbname=" . $db;
// create pdo instance:
$pdoConnection = new PDO($dsn, $user, $pass);
//PDO query:
$stmt = $pdoConnection->query('SELECT * from ' . $table . ';');

//$pdoConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ)

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    var_dump($row);
}


// prepared statements
// positional parameters
$sql = 'SELECT * FROM ' . $table . ' WHERE  username = ?';
$stmt = $pdoConnection->prepare($sql);
$stmt->execute(['kiskiller0']);

// named parameters
$sql = 'SELECT * FROM ' . $table . ' WHERE username = :username AND password = :password';
$stmt = $pdoConnection->prepare($sql);
$stmt->execute(['username' => 'kiskiller0', 'password' => 'secret']);

$results = $stmt->fetchAll();

var_dump($results);
