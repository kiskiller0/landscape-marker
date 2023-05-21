<?php

if (!in_array('id', array_keys($_POST)) || trim($_POST['id']) == '') {
    die(json_encode(['error' => true, 'msg' => 'you did not supply any qrcode!']));
}
die(json_encode(['error' => false, 'msg' => "your qrcode: " . $_POST['id']]));




