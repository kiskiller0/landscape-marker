<?php
session_start();
header('content-type: application/json');

if (!in_array('username', array_keys($_SESSION))) {
  echo json_encode(['error' => true, 'msg' => 'no user logged in! stop testing my API\'s!']);
  die();
}

include "../models/post.php";
include "../models/user.php";

// posts before adding usernames to them:
$namelessPosts = $post->getLastPosts();

$posts = array();

foreach ($namelessPosts as $post) {
  $username = $User->getById($post['userid'])['username'];
  array_push($posts, [...$post, 'username' => $username]);
}

echo json_encode(['error' => '?', 'data' => $posts]);
