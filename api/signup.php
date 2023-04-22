<?php
//logger:
include "../logger.php";
//eologger

// including db model:
include "../models/user.php";

header("Content-type: application/json");

if (empty($_POST)) {
	echo json_encode(["error" => true, "msg" => "no data supplied!"]);
	die(); // prevent multiple fetch replies
}

// preparing profile picture upload:
$allowedTypes = ['jpeg', 'jpg', 'png'];
$path = "../public/profiles/";

$picture = false; //this boolean is to know whether we received an image for the profile

if (!empty($_FILES)) {
	try {
		if ($_FILES['picture']['type'] !== '') {
			$extension = explode("/",  $_FILES['picture']['type'])[1];
			$tmpProfile = $_FILES["picture"]["tmp_name"];
			if (in_array($extension, $allowedTypes)) {
				move_uploaded_file($tmpProfile, $path . $_POST['username'] . '.' . $extension);
				// echo json_encode(["error" => false, "msg" => "file accepted!"]);
				$picture = true;
			}
		}
	} catch (Exception $err) {
	}
}
// var_dump($User->addUser(['picture' => true, ...$_POST]));
echo json_encode($User->addUser(['picture' => $picture, ...$_POST]));
// var_dump(['picture' => true, ...$_POST]);
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
