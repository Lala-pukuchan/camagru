<?php include("includes/header_public_gallery.php"); ?>

<!--section-->
<section class="main">
  <div class="wrapper">
    <div class="left-col">

      <!--show success message-->
      <?php if (isset($_GET['success_message'])) { ?>

        <p class="text-center alert-success" id="success_message" style="color:green">
          <?php echo $_GET['success_message']; ?>
        </p>

      <?php } ?>

      <!--show error message-->
      <?php if (isset($_GET['error_message'])) { ?>

        <p class="text-center alert-danger" id="error_message" style="color:red">
          <?php echo $_GET['error_message']; ?>
        </p>

      <?php } ?>

      <!--posts-->
      <?php include("get_latest_posts.php"); ?>

      <?php foreach ($posts as $post) { ?>

        <div class="post">
          <div class="info">
            <div class="user">
              <div class="profile-pic">
                <img src="<?php echo $post['profile_image']; ?>" alt="" />
              </div>
              <p class="username">
                <?php echo $post["username"]; ?>
              </p>
            </div>

            <!--link to single post-->
            <a href="single_post.php?post_id=<?php echo $post['id']; ?>" style="color:#000;">
              <i class="fas fa-ellipsis-h options"></i>
            </a>

          </div>
          <img class="post-image" src="<?php echo $post['image']; ?>" alt="" />
          <div class="post-content">
            <div class="reaction-wrapper"></div>
            <p class="likes">
              <?php echo $post['likes']; ?>
            </p>
            <p class="description">
              <span>
                <?php echo $post['caption']; ?>
              </span>
              <?php echo $post['hashtags']; ?>
            </p>
            <p class="post-time">
              <?php echo date("M, Y,", strtotime($post['date'])); ?>
            </p>
          </div>
        </div>

      <?php } ?>

      <!--pagenation-->
      <nav aria-label="Page navigation example" class="mt-3">
        <ul class="pagination justify-content-center">
          <li class="page-item 
            <?php if ($page_no <= 1) {
              echo 'disabled';
            } ?>">
            <a class="page-link <?php if ($page_no <= 1) {
              echo "#";
            } else {
              echo '?page_no=' . ($page_no - 1);
            } ?>" href="#" tabindex="-1">Previous</a>
          </li>
          <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
          <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>
          <li class="page-item"><a class="page-link" href="?page_no=3">3</a></li>

          <?php if ($page_no >= 3) { ?>
            <li class="page-item"><a class="page-link" href="#">...</a></li>
            <li class="page-item"><a class="page-link" href="<?php echo "?page_no=" . $page_no; ?>"></a></li>
          <?php } ?>
          <li class="page-item <?php if ($page_no >= $total_no_of_pages) {
            echo 'disabled';
          } ?>">
            <a class="page-link" href="<?php if ($page_no >= $total_no_of_pages) {
              echo "#";
            } else {
              echo "?page_no=" . ($page_no + 1);
            } ?>">Next</a>
          </li>
        </ul>
      </nav>

    </div>
    <!--<div class="right-col"></div>-->
  </div>
</section>
<!--script-->
<script src="https://kit.fontawesome.com/5d47e6cf8c.js"></script>
</body>

</html>