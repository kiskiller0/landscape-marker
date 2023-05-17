<?php
include "views/partials/header.html";
?>

<link rel="stylesheet" href="views/style/home.css">
<title>Home Sweet Home!</title>
</head>

<body>
<div class="page">
    <section id="topbar">
        <div class="home">
            <img src="" alt="" class="userImg">
        </div>
        <div class="search">
            <div class="bar">
                <i class="fa-solid fa-magnifying-glass clickable"></i>
            </div>
            <input type="text" name="query" placeholder="lookup a landscape!"/>
        </div>
        <div id="functions">
            <div class="darkmode"><i class="fa-solid fa-moon clickable"></i></div>
            <div class="parameters"><i class="fa-solid fa-ellipsis clickable"></i></div>
        </div>
    </section>


    <section id="content">
        <div class="realContent"></div>
    </section>

    <section id="footer">
        <div class="functionTrigger clickable">
            <i class="fa-sharp fa-solid fa-camera-retro"></i>
            <i class="fa-sharp fa-solid fa-plus"></i>
        </div>

        <div class="functionTrigger clickable">
            <i class="fa-sharp fa-solid fa-camera-retro"></i>
            <i class="fa-sharp fa-solid fa-plus"></i>
        </div>

        <div class="functionTrigger clickable">
            <i class="fa-sharp fa-solid fa-camera-retro"></i>
            <i class="fa-sharp fa-solid fa-plus"></i>
        </div>
    </section>
    <div class="popup blog hidden" id="add_post">
        <div class="controls">
            <i class="fa-solid fa-xmark clickable"></i>
        </div>
        <div class="blog_content">
            <form action="api/send_post.php" method="post" enctype="multipart/form-data">
                <textarea name="content" placeholder="say something"></textarea>

                <div class="file">
                    <input type="file" name="imgsrc">
                    <i class="fa-regular fa-image"></i>
                </div>

                <input type="submit" value="submit">
            </form>
        </div>

    </div>


    <div class="popup hidden" id="parameters">
        <div class="controls">
            <i class="fa-solid fa-xmark clickable"></i>
        </div>
        <div class="parameters_content">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet architecto asperiores commodi maxime
                minima officiis optio porro quo sunt ullam.</p>
            <a href="api/logout.php">Logout</a>
        </div>
    </div>


    <div class="popup hidden" id="add_place">
        <div class="controls">
            <i class="fa-solid fa-xmark clickable"></i>
        </div>
        <div class="parameters_content">
            <p>Add a place:</p>
        </div>
    </div>

    <div class="popup hidden" id="add_event">
        <div class="controls">
            <i class="fa-solid fa-xmark clickable"></i>
        </div>
        <div class="parameters_content">
            <p>Add an event</p>
        </div>
    </div>

    <div class="popup_background hidden"></div>
</div>


<!-- include views/scripts/home.js -->
<script src="views/scripts/home.js"></script>
<!-- this is for image preview before sending the post: -->
<script src="views/scripts/send_post.js"></script>
</body>

</html>