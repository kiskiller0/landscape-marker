<?php
//logger:
include "../logger.php";
//eologger

header("Content-type: application/json");

if (empty($_POST)) {
    echo json_encode(["error" => true, "msg" => "no data supplied!"]);
    die(); // prevent multiple fetch replies
}


$wantedKeys = ['username', 'password', 'email'];

foreach ($wantedKeys as $key) {
    if (!in_array($key, array_keys($_POST)) || trim($_POST[$key]) == '') {
        echo json_encode([
            "error" => true, "msg" =>
            "$key field is empty"
        ]);
        die(); // prevent multiple fetch replies
    }
}


// preparing profile picture upload:
$allowedTypes = ['jpeg', 'jpg', 'png'];
$path = "../public/profiles/";

if (!empty($_FILES)) {
    try {
        if ($_FILES['picture']['type'] == '')
            throw new Exception("empty file submit");
        else {
            $extension = explode("/",  $_FILES['picture']['type'])[1];
        }
    } catch (Exception $err) {
        echo json_encode(["error" => true, "msg" => 'unsupported type!']);
        die();
    }
    $tmpProfile = $_FILES["picture"]["tmp_name"];
    if (in_array($extension, $allowedTypes)) {
        move_uploaded_file($tmpProfile, $path . $_POST['username'] . '.' . $extension);
        echo json_encode(["error" => false, "msg" => "file accepted!"]);
    } else {
        echo json_encode(["error" => true, "msg" => "filetype not supported!"]);
    }
} else {
    echo json_encode(["error" => true, "msg" => "no image supplied!"]);
}

/*
nutshell:
pdo connects to table users
[*]-form is read into $_POST
[]-username is checked, if available
[]-check email, if available
[]-set password (regardless of strength)
[*]-if the above checks pass, check profile pic if size in range // done by php.ini
[*]-if filetype correct, copy it to public/profiles/username.extension,
[]-and set the field ppic in the table user as username.extension
[]-if all the above, redirect to login.php
*/
// echo "</pre>";
