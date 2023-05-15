<?php

session_start();
include "../models/user.php";

if (empty($_SESSION) || !in_array('username', array_keys($_SESSION)) || !($user = $User->getByUsername($_SESSION['username']))) {
    echo json_encode(['error' => true, 'msg' => 'not logged in!']);
    die();
}


$neededFields = ['username', 'email', 'picture'];
$neededInfo = [];

foreach ($neededFields as $field) {
    $neededInfo[$field] = $user[$field];
}

echo json_encode(['error' => false, 'user' => $neededInfo]);