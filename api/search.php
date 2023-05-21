<?php


if (!empty($_GET) && in_array('search', array_keys($_GET))) {
    echo "you want to look for '" . $_GET['search'] . "'<br><hr>";
    if (strlen($_GET['search']) < 4) {
        die('search starts from 4 letters!');
    }
} else {
    echo "screw you!";
    die();
}

include "../views/partials/header.html";

include "../models/user.php";
include "../models/post.php";


function filterUsers($item)
{
    $neededTraits = ['username', 'picture', 'id'];
    $tmpItem = [];
    foreach ($neededTraits as $trait) {
        $tmpItem[$trait] = $item[$trait];
    }
    return $tmpItem;
}

function filterPosts($item)
{
    $neededTraits = ['content', 'id'];
    $tmpItem = [];
    foreach ($neededTraits as $trait) {
        $tmpItem[$trait] = $item[$trait];
    }
    return $tmpItem;
}

// removing unneeded fields, such as PASSWORD!
$users = array_map('filterUsers', $User->getUsernameLike($_GET['search']));
$posts = array_map('filterPosts', $post->getTitleLike($_GET['search']));

//var_dump($users);
//var_dump($posts);
?>
    <link rel="stylesheet" href="../../views/style/search.css">
    <title>Search:</title>
    <body>
    <div class="parent">
        <div class="posts">
            <h2>posts:</h2>
            <?php
            foreach ($posts as $p) {
                echo "<div class=\"post\">";
                echo "<img src=\"../../public/posts/" . $p['id'] . "\" />";
                echo "<p>" . $p['content'], '</p>';
//                var_dump($p);
                echo "</div>";

                echo "<hr>";
            }
            ?>
        </div>
        <div class="users">
            <h2>users</h2>

            <?php
            foreach ($users as $u) {
                var_dump($u);
                echo "<hr>";
            }
            ?>
        </div>
    </div>
    </body>

<?php

include "../views/partials/footer.html";


