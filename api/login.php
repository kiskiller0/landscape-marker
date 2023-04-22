<?php
session_start();
//logger:
include "../logger.php";
//eologger
if (!empty($_SESSION)) {
    if (in_array('username', $_SESSION)) {
        echo json_encode(["username" => $_SESSION['username']]);
    }
}
// including db model:
include "../models/user.php";


header("Content-type: application/json");


// var_dump($u = $User->getByUsername($_POST['username']));


if ($u = $User->getByUsername($_POST['username'])) {
    if ($u['password'] == $_POST['password']) {
        echo json_encode(['error' => false, 'msg' => "user \"" . $_POST['username'] . ':', "values:" => [...$u]]);
        $_SESSION['username'] = $_POST['username'];
    } else {
        echo json_encode(['error' => true, 'msg' => "password is wrong!"]);
    }
} else {
    echo json_encode(['error' => true, 'msg' => "user \"" . $_POST['username'] . '" is non-existent!']);
}
