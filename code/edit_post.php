<!--show success message-->
<?php if (isset($_GET['success_message'])) { ?>

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
    exit();
  }



  ?>

  <p class="text-center alert-success mt-4" id="success_message" style="color:green">
    <?php echo $_GET['success_message']; ?>
  </p>

<?php } ?>

<!--show error message-->
<?php if (isset($_GET['error_message'])) { ?>

  <p class="text-center alert-danger mt-4" id="error_message" style="color:red">
    <?php echo $_GET['error_message']; ?>
  </p>

<?php } ?>

<div class="camera-container">
  <?php foreach ($post_array as $post) { ?>
    <div class="camera">
      <div class="camera-image">

        <!--display image-->
        <?php if (isset($_GET['image_name'])) { ?>
          <img style="width: 500px;" src="<?php echo "assets/images/" . $_GET['image_name']; ?>" alt="" />
        <?php } else { ?>
          <img style="width: 500px;" src="<?php echo "assets/images/" . $post['image']; ?>" alt="" />
        <?php } ?>

        <form action="update_post.php" method="post" enctype="multipart/form-data" class="camera-form">
          <div class="form-group">
            <input type="file" name="new_image" class="form-control" required />
            <input type="hidden" name="old_image_name" class="form-control" value="<?php echo $post['image']; ?>" />
            <input type="hidden" name="post_id" class="form-control" value="<?php echo $post['id']; ?>" />
          </div>
          <div class="form-group">
            <input type="text" name="caption" class="form-control" placeholder="type captions..."
              value="<?php echo $post['caption']; ?>" />
          </div>
          <div class="form-group">
            <input type="text" name="hashtags" class="form-control" placeholder="type hashtags..."
              value="<?php echo $post['hashtags']; ?>" />
          </div>
          <div class="form-group">
            <button type="submit" style="width:100%;" name="update_post_btn" class="upload-btn">
              Update Post
            </button>
          </div>
        </form>
      </div>
    </div>
  <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/5d47e6cf8c.js"></script>
</body>

</html>