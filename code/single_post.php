<?php include("includes/header.php") ?>

<?php

include("db/connection.php");

if (isset($_GET['post_id'])) {
  $post_id = $_GET['post_id'];
  $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
  $stmt->bind_param("i", $post_id);
  $stmt->execute();
  $post_array = $stmt->get_result();
} else {
  header("location: index.php");
}

?>

<!--section-->
<section class="main single-post-container">
  <div class="wrapper">
    <div class="left-col">

      <!--posts-->
      <?php foreach ($post_array as $post) { ?>
        <div class="post">
          <div class="info">
            <div class="user">
              <div class="profile-pic">
                <img src="<?php echo "assets/images/" . $post['profile_image']; ?>" alt="" />
              </div>
              <p class="username">
                <?php echo $post["username"]; ?>
              </p>
            </div>

            <?php if ($post['user_id'] == $_SESSION['id']) { ?>

              <button class="profile-btn profile-settings-btn" id="options-btn" aria-label="profile settings">
                <i class="fas fa-ellipsis-h options"></i>
              </button>

            <?php } ?>

          </div>
          <img class="post-image" src="<?php echo "assets/images/" . $post['image']; ?>" alt="" />
          <div class="post-content">
            <div class="reaction-wrapper">
              <!--<i class="icon fas fa-heart"></i>
              <i class="icon fas fa-comment"></i>-->
            </div>
            <p class="likes">
              <?php echo $post['likes']; ?> Likes</p>
            <p class="description">
              <span><?php echo $post['caption']; ?></span><?php echo $post['hashtags']; ?>
            </p>
            <p class="post-time"><?php echo date("M,Y", strtotime($post['date'])); ?></p>
          </div>
          <div class="comment-wrapper">
            <img class="icon" src="assets/images/profile.png" alt="" />
            <input type="text" class="comment-box" placeholder="Add a comment" />
            <button class="comment-btn">Comment</button>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="right-col">
      <!--profile-->
      <?php include("profile_card.php"); ?>

      <!--suggestions-->
      <?php include("suggestion_side_area.php"); ?>
    </div>
  </div>
</section>
<!--script-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/5d47e6cf8c.js"></script>
</body>

</html>