<?php
session_start();
if (!in_array('username', array_keys($_SESSION))) {
  echo json_encode(['error' => true, 'msg' => 'no user logged in! stop testing my API\'s!']);
  die();
}


echo "<pre>";

var_dump($_POST);

echo "<hr>";

var_dump($_FILES);
