<?php
header("content-type: application/json");

include "../models/post.php";


// test api:
// if (empty($_POST) || !in_array('id', array_keys($_POST))) {
//   echo json_encode(['error' => true, 'msg' => 'no data!']);
// } else {
//   echo json_encode(['error' => false, 'posts' => [['id' => $_POST['id'] + 1, 'content' => 'message at ' . time()]]]);
// }



// actual api:
if (empty($_POST)) {
  echo json_encode($post->getLastPosts());
} else {
  if (in_array('id', array_keys($_POST))) {
    // TODO: []- check if id is a legit number
    // also, if the absence of id from posts yields null, than, we won't need an else clause.
    echo json_encode(['error' => false, 'posts' => $post->getLastPosts($_POST['id'])]);
  }
}
