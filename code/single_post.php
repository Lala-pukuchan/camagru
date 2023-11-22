<?php include("includes/header.php") ?>

<?php

include("db/connection.php");

if (isset($_GET['post_id'])) {
  $post_id = $_GET['post_id'];
  $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
  $stmt->bind_param("i", $post_id);
  $stmt->execute();
  $post_array = $stmt->get_result();


  // for comment pagenation
  if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    $page_no = $_GET['page_no'];
  } else {
    $page_no = 1;
  }

  $stmt = $conn->prepare('SELECT COUNT(*) as total_comments FROM comments WHERE post_id = ?');
  $stmt->bind_param('i', $post_id);
  $stmt->execute();
  $stmt->bind_result($total_comments);
  $stmt->store_result();
  $stmt->fetch();

  $total_comments_per_page = 10;

  $offset = ($page_no - 1) * $total_comments_per_page;

  $total_no_of_pages = ceil($total_comments / $total_comments_per_page);

  $stmt = $conn->prepare("SELECT * FROM comments WHERE post_id = $post_id ORDER BY id DESC LIMIT $offset, $total_comments_per_page");
  $stmt->execute();
  $comments = $stmt->get_result();

} else {
  header("location: index.php");
}

?>

<!--section-->
<section class="main single-post-container">
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
              <button onclick="document.getElementById('popup-comment<?php echo $comment['id']; ?>').style.display = 'block';" class="profile-btn profile-settings-btn" id="options-btn" aria-label="profile settings">
                <i class="fas fa-ellipsis-h options"></i>
              </button>

            <?php } ?>

            <div class="popup" id="popup">
              <div class="popup-window">
                <span class="close-popup" id="close_popup">&times;</span>
                <a href="edit_post.php?post_id=<?php echo $post['id']; ?>">Edit Post</a>
                <form action="delete_post.php" method="post">
                  <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                  <input type="submit" name="delete_post_btn" value="Delete Post" class="delete-post-btn">

                </form>
              </div>
            </div>

          </div>
          <img class="post-image" src="<?php echo "assets/images/" . $post['image']; ?>" alt="" />
          <div class="post-content">
            <div class="reaction-wrapper">
              <!--<i class="icon fas fa-heart"></i>
              <i class="icon fas fa-comment"></i>-->
            </div>
            <p class="likes">
              <?php echo $post['likes']; ?> Likes
            </p>
            <p class="description">
              <span>
                <?php echo $post['caption']; ?>
              </span>
              <?php echo $post['hashtags']; ?>
            </p>
            <p class="post-time">
              <?php echo date("M,Y", strtotime($post['date'])); ?>
            </p>

            <!--comments-->
            <?php foreach ($comments as $comment) { ?>
              <div class="comment-element">
                <img src="<?php echo "assets/images/" . $comment['profile_image']; ?>" class="icon" alt="">
                <p>
                  <?php echo $comment['comment_text']; ?>
                  <span>
                    <?php echo date("M, Y,", strtotime($comment['date'])); ?>
                  </span>
                </p>
              
                <!--manage comments-->
                <?php if ($comments['user_id'] == $_SESSION['id']) { ?>
                  <button onclick="" class="profile-btn profile-settings-btn" id="options_btn" aria-label="profile settings">
                    <i class="fas fa-edit"></i>
                  </button>

                  <div class="popup" id="popup-comment<?php echo $comment['id']; ?>" >
                    <div class="popup-window">
                      <span onclick="document.getElementById('popup-comment<?php echo $comment['id']; ?>').style.display = 'none';" 
                        class="close-popup" id="close_popup<?php echo $comment['id']; ?>"
                        style="font-size: 30px;">&times;</span>
                      <a href="edit_comment.php?commnet_id=<?php echo $comment['id']; ?>&post_id=<?php echo $post['id']; ?>">Edit Comment</a>
                      <form action="delete_comment.php" method="post">
                        <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                        <input type="text" name="post_id" value="<?php echo $post['id']; ?>">
                        <input class="delete-comment-btn" type="submit" name="delete_comment_btn" value="Delete Comment">
                      </form>
                    </div>
                  </div>
                <?php } ?>
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
                    echo 'single_post.php?post_id=' . $post_id . '&page_no=' . ($page_no - 1);
                  } ?>">
                    < </a>
                </li>

                <li class="page-item <?php if ($page_no >= $total_no_of_pages) {
                  echo 'disabled';
                } ?>">
                  <a class="page-link" href="<?php if ($page_no >= $total_no_of_pages) {
                    echo "#";
                  } else {
                    echo 'single_post.php?post_id=' . $post_id . '&page_no=' . ($page_no + 1);
                  } ?>">
                    > </a>
                </li>
              </ul>
            </nav>


          </div>
          <div class="comment-wrapper">
            <img class="icon" src="<?php echo "assets/images/" . $_SESSION['image']; ?>" alt="" />
            <form action="store_comment.php" class="comment-wrapper" method="post">
              <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
              <input type="text" class="comment-box" placeholder="Add a comment" name="comment_text" />
              <button class="comment-btn" name="comment_btn" type="submit">Comment</button>
            </form>
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
<script>

  var popupWindow = document.getElementById("popup");
  var optionsBtn = document.getElementById("options_btn");
  var closeWindow = document.getElementById("close_popup");

  optionsBtn.addEventListener("click", (e) => {
    e.preventDefault();
    popupWindow.style.display = "block";
  });

  closeWindow.addEventListener("click", (e) => {
    e.preventDefault();
    popupWindow.style.display = "none";
  });

  window.addEventListener("click", (e) => {
    if (e.target == popupWindow) {
      popupWindow.style.display = "none";
    }
  });




</script>

</body>

</html>