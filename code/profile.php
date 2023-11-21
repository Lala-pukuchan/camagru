<?php include("includes/header.php"); ?>

<header class="profile-header">
  <header class="profile-container">
    <div class="profile">
      <div class="profile-image">
        <img src="<?php echo "assets/images/" . $_SESSION['image']; ?>" alt="" />
      </div>
      <div class="profile-user-setting">
        <h1 class="profile-user-name">
          <?php echo $_SESSION['username']; ?>
        </h1>

        <!--edit profile-->
        <form action="edit_profile.php" method="get" style="display: inline-block;">
          <button class="profile-btn profile-edit-btn">Edit Profile</button>
        </form>

        <button class="profile-btn profile-settings-btn" area-label="profile settings">
          <i class="fas fa-cog"></i>
        </button>
      </div>
      <div class="profile-stats">
        <ul>
          <li><span class="profile-stat-count">
              <?php echo $_SESSION['post']; ?>
            </span> posts</li>
          <li><span class="profile-stat-count">
              <?php echo $_SESSION['followers']; ?>
            </span> followers</li>
          <li><span class="profile-stat-count">
              <?php echo $_SESSION['following']; ?>
            </span> following</li>
        </ul>
      </div>
      <div class="profile-bio">
        <p>
          <span class="profile-real-name">
            <?php echo $_SESSION['username']; ?>
          </span>
          <?php echo $_SESSION['bio']; ?>
        </p>
      </div>
    </div>
  </header>
</header>

<main>
  <div class="profile-container">
    <div class="gallery">
      <div class="gallery-item">
        <img src="assets/images/1.jpg" class="gallery-image" alt="" />
        <div class="gallery-item-info">
          <ul>
            <li class="gallery-item-likes">
              <span class="hide-gallery-element">Likes:</span>
              <i class="fas fa-heart"></i>
            </li>
            <li class="gallery-item-comments">
              <span class="hide-gallery-element">Comments:</span>
              <i class="fas fa-comment"></i>
            </li>
          </ul>
        </div>
      </div>
      <div class="gallery-item">
        <img src="assets/images/1.jpg" class="gallery-image" alt="" />
        <div class="gallery-item-info">
          <ul>
            <li class="gallery-item-likes">
              <span class="hide-gallery-element">Likes:</span>
              <i class="fas fa-heart"></i>
            </li>
            <li class="gallery-item-comments">
              <span class="hide-gallery-element">Comments:</span>
              <i class="fas fa-comment"></i>
            </li>
          </ul>
        </div>
      </div>
      <div class="gallery-item">
        <img src="assets/images/1.jpg" class="gallery-image" alt="" />
        <div class="gallery-item-info">
          <ul>
            <li class="gallery-item-likes">
              <span class="hide-gallery-element">Likes:</span>
              <i class="fas fa-heart"></i>
            </li>
            <li class="gallery-item-comments">
              <span class="hide-gallery-element">Comments:</span>
              <i class="fas fa-comment"></i>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</main>

<!--script-->
<script>
  setInterval(() => {
    changeImg();
  }, 2000);
  function changeImg() {
    var images = document
      .getElementById("slide-content")
      .getElementsByTagName("img");
    var i = 0;
    for (i = 0; i < images.length; i++) {
      var image = images[i];
      if (image.classList.contains("active")) {
        image.classList.remove("active");

        if (i == images.length - 1) {
          var nextImage = images[0];
          nextImage.classList.add("active");
          break;
        }

        var nextImage = images[i + 1];
        nextImage.classList.add("active");
        break;
      }
    }
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/5d47e6cf8c.js"></script>
</body>

</html>