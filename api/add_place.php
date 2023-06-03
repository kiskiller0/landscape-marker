<?php

session_start();

header('content-type: application/json');
include "../models/place.php";


// I should check for userid also, not just username
// but there is no reason for only one of them to exist alone!
// thus I should cut the redundancy!
if (!in_array('username', array_keys($_SESSION))) {
    if (!in_array('userid', array_keys($_SESSION))) {
        // #TODO: []-this is assumed redundant, and is gonna be cut in future code reviews!
        die(json_encode(['error' => true, 'msg' => 'not logged in!']));
    }
}

//foreach ($Place->getNeededFields() as $field) {
//    if ($field == 'userid')
//        continue;
//    if (!in_array($field, array_keys($_POST)))
//        die(sprintf('filed %s doesn\'t exist!', $field));
//}

$needed_fields = ['name', 'description', 'latitude', 'longitude']; // the needed_fields field does contain userid

// checking the presence of all fields
// and sanitizing the $_POST array
foreach ($needed_fields as $field) {
    $_POST[$field] = htmlspecialchars($_POST[$field]);
    if (!in_array($field, array_keys($_POST)) || trim($_POST[$field]) == '') {
        die(json_encode(['error' => true, 'msg' => $field . ' does not exists']));
    }
}

if (!in_array('imgsrc', array_keys($_FILES)) || $_FILES['imgsrc']['tmp_name'] == '') {
    die(json_encode(['error' => true, 'msg' => 'no img supplied for the place!']));
}

//echo json_encode(['error' => false, 'msg' => [...$_POST, ...$_FILES]]);
// TODO: checking the unicity of the place name, and latitude and longitude


// ====================

if (!in_array('imgsrc', array_keys($_FILES)) || !$_FILES['imgsrc']['type'] || count($_FILES['imgsrc']) < 2) {
    die(json_encode(['error' => true, 'msg' => 'no image selected!']));
} else {
    // [*]-check img type!
    // [*]-upload it to pictures folder and assign place as an image name
    $allowed_types = ['jpeg', 'jpg', 'png'];
    $type = explode('/', $_FILES['imgsrc']['type'])[1];
    if (in_array($type, $allowed_types)) {
        // first, create the post:
        $result = $Place->addNew([...$_POST, 'userid' => $_SESSION['userid']]);
        if ($result['error']) {
            die(json_encode($result));
        }

        $lastPost = $Place->getLastInserted();

        if ($lastPost['error']) {
            die(json_encode($lastPost));
        }

        $lastPost = $lastPost['msg'];
        // TODO: move the file moving code inside the if statment, before returning json
        // [*]-do the upload and name assignment
        $fpath = sprintf("../public/places/%s", $lastPost['id']);
//        $fpath .= $lastPost ? (int) : 1;
        if (!move_uploaded_file($_FILES['imgsrc']['tmp_name'], $fpath)) {
            die(json_encode(['error' => true, 'msg' => 'could not upload picture']));
        } else {
            die(json_encode(['error' => false, 'msg' => 'success']));
        }
    }
}



