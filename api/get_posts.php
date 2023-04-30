<?php
header("content-type: application/json");

if (empty($_POST)) {
  echo json_encode(['error' => true, 'msg' => 'no data!']);
} else {
  echo json_encode($_POST);
}
