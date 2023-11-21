<?php include("includes/header.php"); ?>

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

      <?php include("get_latest_posts.php"); ?>

      <!--posts-->
      <?php foreach ($posts as $post) { ?>

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
            <i class="fas fa-ellipsis-h options"></i>
          </div>
          <img class="post-image" src="<?php echo "assets/images/" . $post['image']; ?>" alt="" />
          <div class="post-content">
            <div class="reaction-wrapper">
              <i class="icon fas fa-heart"></i>
              <i class="icon fas fa-comment"></i>
            </div>
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
          <div class="comment-wrapper">
            <img class="icon" src="assets/images/profile.png" alt="" />
            <input type="text" class="comment-box" placeholder="Add a comment" />
            <button class="comment-btn">Post</button>
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
            <a class="page-link" 
              href="<?php if ($page_no >= $total_no_of_pages) {
              echo "#";
            } else {
              echo "?page_no=" . ($page_no + 1);
            } ?>">Next</a>
          </li>
        </ul>
      </nav>

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