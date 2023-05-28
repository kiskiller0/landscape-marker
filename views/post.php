<?php
session_start();

if (!in_array('id', array_keys($_GET))) {
    die(json_encode(['error' => true, 'msg' => 'no id supplied!']));
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post: <?php echo $_GET['id'] || "undefined!" ?></title>
</head>
<body>


<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/models/comment.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/post.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/models/user.php";

$wantedPost = $post->getByUniqueValue('id', $_GET['id']);

if ($wantedPost['error']) {
    die(json_encode(['error' => true, 'msg' => 'missing post!']));
}

$comments = $Comment->getByField("postid", $_GET['id'], EQ);

$wantedPost = $wantedPost['msg'];

// getting user info from userid:

echo "<div class='post'>";
echo sprintf("<div class='content'>%s</div>", $wantedPost['content']);
echo sprintf("<div class='date'>%s</div>", $wantedPost['date']);
echo "<hr>";
echo "</div>";
?>

<div class="add_comment">
    <form action="../../api/add_comment.php" method="post">
        <textarea name="content" cols="30" rows="10"></textarea>
        <input type="submit" value="send">
    </form>
</div>

<div class="comments">
    <?php
    if (!$comments['error'] && count($comments['data'])) {
        // show all comments:
        foreach ($comments as $comment) {
            echo '<div class="comment">';
            echo sprintf("<p>%s</p>", $comment['content']);
            echo sprintf("<p>by: %s</p>", $comment['userid']);
            echo sprintf("<p>at: %s</p>", $comment['date']);
            echo '</div>';
        }
    } else {
        if ($_SESSION['userid'] == $wantedPost['userid']) {
            echo "<p>no comments yet! you subscribe to our advertisment service, give us money, and we give you traffic! win-win!</p>";
        } else {
            echo "no comments, be the first!";
        }
//        var_dump($_SESSION);
    }
    ?>
</div>

</body>
<script src="./scripts/post.js"></script>
</html>
