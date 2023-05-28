<?php


// echo json_encode(["files" => [...$_FILES], 'post' => [...$_POST]]);
// die();

session_start();

header('content-type: application/json');
include "../models/post.php";


// I should check for userid also, not just username
// but there is no reason for only one of them to exist alone!
// thus I should cut the redundancy!
if (!in_array('username', array_keys($_SESSION))) {
    if (!in_array('userid', array_keys($_SESSION))) {
        // #TODO: []-this is assumed redundant, and is gonna be cut in future code reviews!
        die(json_encode(['error' => true, 'msg' => 'not logged in!']));
    }
}


// sanitization:
function sanitize($item)
{
    return htmlspecialchars($item);
}

foreach ($_POST as $key => $value) {
    $_POST[$key] = sanitize($value);
}
// checking the uploaded image: (images are mandatory!)


// echo json_encode(['files' => $_FILES]);
// die();


if (!in_array('imgsrc', array_keys($_FILES)) || !$_FILES['imgsrc']['type'] || count($_FILES['imgsrc']) < 2) {
    echo json_encode(['error' => true, 'msg' => 'no image selected!']);
    die();
} else {
    // [*]-check img type!
    // [*]-upload it to pictures folder and assign postid as an image name
    $allowed_types = ['jpeg', 'jpg', 'png'];
    $type = explode('/', $_FILES['imgsrc']['type'])[1];
    if (in_array($type, $allowed_types)) {
        // first, create the post:
        if ($lastPost = $post->createPost([...$_POST, 'userid' => $_SESSION['userid']])) {
            echo json_encode(['error' => false, 'msg' => 'post created!']);
        } else {
            echo json_encode(['error' => true, 'msg' => 'post not created!']);
        }
        // TODO: move the file moving code inside the if statment, before returning json
        // [*]-do the upload and name assignment
        $fpath = "../public/posts/";
        $fpath .= $lastPost ? (int)$lastPost['id'] : 1;
        if (!move_uploaded_file($_FILES['imgsrc']['tmp_name'], $fpath)) {
            echo json_encode(['error' => true, 'msg' => 'could not upload picture']);
        }
        // echo json_encode(['error' => false, 'msg' => 'image uploaded successfully!']);
    }
}



