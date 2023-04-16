<?php
$globalMsg = 'hello, world!';

if (empty($_POST)) {
    die("redirecting you back to /views/login ....");
}

echo "<pre>";

foreach ($_POST as $key => $val) {
    echo $key . "  ==>  " . $val . "\n";
}

echo "</pre>";
