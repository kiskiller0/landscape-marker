<?php
session_start();

include "./views/partials/header.html";
if (!empty($_SESSION)) {
    echo "redirecting to home ...";
} else {
    include "./views/partials/welcome.html";
}
if (!empty($GLOBAL['msg']))
    echo $GLOBAL['msg'];
else {
    echo "no globalMsg!!";
}
?>


<?php
include "./views/partials/footer.html";
