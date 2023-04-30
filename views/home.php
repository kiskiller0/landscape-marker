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
        <div class=""><i class="fa-solid fa-house-user clickable"></i></div>
      </div>
      <div class="search">
        <div class="bar">
          <i class="fa-solid fa-magnifying-glass clickable"></i>
        </div>
        <input type="text" name="query" placeholder="lookup a landscape!" />
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
      <div class="camera clickable">
        <i class="fa-sharp fa-solid fa-camera-retro"></i>
        <i class="fa-sharp fa-solid fa-plus"></i>
      </div>
    </section>
    <div class="popup blog hidden">
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
    <div class="popup_background hidden"></div>
  </div>


  <!-- include views/scripts/home.js -->
  <script src="views/scripts/home.js"></script>
</body>

</html>