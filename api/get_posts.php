<?php
header("content-type: application/json");

include "../models/post.php";

if (empty($_POST)) {
  echo json_encode(['error' => true, 'msg' => 'no data!']);
} else {

  echo json_encode($_POST);

  // echo json_encode(['error' => false, 'posts' => $post->getPostsOlderThan(400000, 5)]);
  // getting n posts older than $_POST['last']
}
