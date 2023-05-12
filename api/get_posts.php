<?php
header("content-type: application/json");

include "../models/post.php";
include "../models/user.php";

// test api:
// if (empty($_POST) || !in_array('id', array_keys($_POST))) {
//   echo json_encode(['error' => true, 'msg' => 'no data!']);
// } else {
//   echo json_encode(['error' => false, 'posts' => [['id' => $_POST['id'] + 1, 'content' => 'message at ' . time()]]]);
// }


// actual api:
if (!in_array('id', array_keys($_POST))) {
    $posts = $post->getLastPosts();
} else {
    $posts = $post->getLastPosts($_POST['id']);
    // TODO: []- check if id is a legit number
    // also, if the absence of id from posts yields null, than, we won't need an else clause.
}

$postsWithUserData = array();

foreach ($posts as $currentPost) {
    $user = $User->getById($currentPost['userid']);
    array_push($postsWithUserData, [...$currentPost, 'user' => ['username' => $user['username'], 'picture' => $user['picture']]]);
    // array_push($postsWithUserData, json_encode([...$currentPost, 'username' => $username]));
}

echo json_encode(['error' => false, 'posts' => $postsWithUserData]);

//echo json_encode(['error' => false, 'posts' => $post->getLastPosts($_POST['id'])]);
