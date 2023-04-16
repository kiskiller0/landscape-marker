<?php

if (empty($_POST)) {
    echo json_encode(["error" => true, "msg" => "no data supplied!"]);
}

foreach ($_POST as $key => $val) {
    if (trim($val) == '') {
        echo json_encode(["error" => true, "msg" => '$key field is empty!']);
    }
}

// echo "<pre>";

// foreach ($_POST as $key => $val) {
//     echo $key . "  ==>  " . $val . "\n";
// }

// preparing profile picture upload:
$allowedTypes = ['jpeg', 'jpg', 'png'];
$path = "../public/profiles/";

if (!empty($_FILES)) {
    $extension = explode("/",  $_FILES['picture']['type'])[1];
    var_dump($_FILES);
    $tmpProfile = $_FILES["picture"]["tmp_name"];
    if (in_array($extension, $allowedTypes)) {
        echo json_encode(["error" => false]);
        move_uploaded_file($tmpProfile, $path . $_POST['username'] . '.' . $extension);
    } else {
        echo json_encode(["error" => true, "msg" => "filetype not supported!"]);
    }
} else {
    echo json_encode(["error" => true, "msg" => "no image supplied!"]);
}
echo "</pre>";


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