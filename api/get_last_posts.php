<?php


// TODO: []- remove this entirely and tuck it under get_posts, by sending a request with a different
// body, you can access the get_posts endpoint conditionally!
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

foreach ($namelessPosts as $currentPost) {
  $username = $User->getById($currentPost['userid'])['username'];
  array_push($posts, [...$currentPost, 'username' => $username]);
}

echo json_encode(['error' => '?', 'posts' => $posts]);
