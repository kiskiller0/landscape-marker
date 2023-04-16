<?php

// this is a fetch api endpoint, reply with json!
// make the generated name random (a security feature)
$path = "../public/tmpprofiles/";
if (!empty($_FILES)) {
    $ext = explode("/",  $_FILES['picture']['type'])[1];
    move_uploaded_file($_FILES['picture']['tmp_name'], $path . "tmp" . $ext);
}
