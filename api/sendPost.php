<?php
session_start();


if (!in_array('username', $_SESSION)) {
  echo json_encode(["error" => true, 'msg' => 'nice try mry hacker!']);
  die();
}

echo json_encode(["error" => false, 'msg' => 'treating your post mr ' . $_SESSION['username']]);
