<?php
session_start();

include "./views/partials/header.html";
if (!empty($_SESSION)) {
    echo "redirecting to home ...";
} else {
    include "./views/partials/welcome.html"; //#TODO: animate the placeholder: setTimout, everytime add a letter!
}
?>


<?php
include "./views/partials/footer.html";
