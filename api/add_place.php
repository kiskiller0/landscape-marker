<?php

$needed_fields = ['name', 'description', 'latitude', 'longitude'];

// checking the presence of all fields
foreach ($needed_fields as $field) {
    if (!in_array($field, array_keys($_POST)) || trim($_POST[$field]) == '') {
        die(json_encode(['error' => true, 'msg' => $field . ' does not exists']));
    }
}
if (!in_array('img', array_keys($_FILES)) || $_FILES['img']['tmp_name'] == '') {
    die(json_encode(['error' => true, 'msg' => 'no img supplied for the place!']));
}

echo json_encode(['error' => false, 'msg' => [...$_POST, ...$_FILES]]);
// TODO: checking the unicity of the place name, and latitude and longitude



