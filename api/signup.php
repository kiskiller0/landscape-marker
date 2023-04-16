<?php

if (empty($_POST)) {
    die("redirecting you back to /views/signup ....");
}

echo "<pre>";

foreach ($_POST as $key => $val) {
    echo $key . "  ==>  " . $val . "\n";
}

// preparing profile picture upload:
$allowedTypes = ['jpeg', 'jpg', 'png'];
$path = "../public/profiles/";

if (!empty($_FILES)) {
    $extension = explode("/",  $_FILES['picture']['type'])[1];
    var_dump($_FILES);
    $tmpProfile = $_FILES["picture"]["tmp_name"];
    if (in_array($extension, $allowedTypes)) {
        move_uploaded_file($tmpProfile, $path . $_POST['username'] . '.' . $extension);
    } else {
        echo "image format not supported!\nyou have to manually change the image later in your user settings!";
    }
} else {
    echo "no file supplied!";
}
echo "</pre>";


/*
nutshell:
pdo connects to table users
form is read into $_POST
username is checked, if available, check email, if available, set password (regardless of strength)
if the above checks pass, check profile pic if size in range, if filetype correct, copy it to public/profiles/username.extension,
and set the field ppic in the table user as username.extension
if all the above, redirect to login.php
*/