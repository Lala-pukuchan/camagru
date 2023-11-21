<?php

session_start();

// if user is not logged in, redirect to login page
if (!isset($_SESSION['id'])) {

  header("Location: login.php");
  exit();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Camagru</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <!--navigation bar-->
  <nav class="navbar">
    <div class="nav-wrapper">
      <img class="brand-img" src="assets/images/logo.png" />
      <form class="search-form" action="">
        <input type="text" class="search-box" placeholder="search..." />
      </form>
      <div class="nav-items">
        <i class="icon fas fa-home"></i>
        <i class="icon fas fa-plus"></i>
        <i class="icon fas fa-heart"></i>
        <div class="icon user-profile">
          <i class="icon fas fa-user"></i>
        </div>
      </div>
    </div>
  </nav>
  <!--section-->
  <section class="main">
    <div class="wrapper">
      <div class="left-col">
        <!--status-->
        <div class="status-wrapper">
          <div class="status-card">
            <div class="profile-pic">
              <img src="assets/images/profile.png" />
            </div>
            <p class="username">username</p>
          </div>
          <div class="status-card">
            <div class="profile-pic">
              <img src="assets/images/profile.png" />
            </div>
            <p class="username">username</p>
          </div>
          <div class="status-card">
            <div class="profile-pic">
              <img src="assets/images/profile.png" />
            </div>
            <p class="username">username</p>
          </div>
        </div>
        <!--posts-->
        <div class="post">
          <div class="info">
            <div class="user">
              <div class="profile-pic">
                <img src="assets/images/profile.png" />
              </div>
              <p class="username">username</p>
            </div>
            <i class="fas fa-ellipsis-h options"></i>
          </div>
          <img class="post-image" src="assets/images/1.jpg" alt="" />
          <div class="post-content">
            <div class="reaction-wrapper">
              <i class="icon fas fa-heart"></i>
              <i class="icon fas fa-comment"></i>
            </div>
            <p class="likes">2,154 Likes</p>
            <p class="description">
              <span>username</span>this is a post by username
            </p>
            <p class="post-time">2021/12/08</p>
          </div>
          <div class="comment-wrapper">
            <img class="icon" src="assets/images/profile.png" alt="" />
            <input type="text" class="comment-box" placeholder="Add a comment" />
            <button class="comment-btn">Post</button>
          </div>
        </div>
      </div>
      <div class="right-col">
        <!--profile-->
        <div class="profile-card">
          <div class="profile-pic">
            <img src="assets/images/profile.png" alt="" />
          </div>
          <div>
            <p class="username">username</p>
            <p class="sub-text">sub-text</p>
          </div>

          <!--logout-->
          <form action="logout.php" method="get">
            <button class="logout-btn">logout</button>
          </form>
          
        </div>
        <!--suggestions-->
        <p class="suggestion-text">Suggestions for you</p>

        <div class="suggestion-card">
          <div class="suggestion-pic">
            <img src="assets/images/profile.png" alt="" />
          </div>
          <div>
            <p class="username">username</p>
            <p class="sub-text">sub-text</p>
          </div>
          <button class="follow-btn">follow</button>
        </div>
      </div>
    </div>
  </section>
  <!--script-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/5d47e6cf8c.js"></script>
</body>

</html>