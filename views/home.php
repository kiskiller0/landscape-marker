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
    </section>

    <section id="footer">
      <div class="camera clickable">
        <i class="fa-sharp fa-solid fa-camera-retro"></i>
        <i class="fa-sharp fa-solid fa-plus"></i>
      </div>
    </section>
    <div class="blog">
      <div class="controls">
        <i class="fa-solid fa-xmark clickable"></i>
      </div>
      <div class="blog_content"></div>
    </div>
  </div>

</body>

</html>