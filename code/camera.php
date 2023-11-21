<?php include("includes/header.php"); ?>

<!--show success message-->
<?php if (isset($_GET['success_message'])) { ?>

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
  <div class="camera">
    <div class="camera-image">

      <!--display image-->
      <?php if (isset($_GET['image_name'])) { ?>
        <img style="width: 500px;" src="<?php echo "assets/images/" . $_GET['image_name']; ?>" alt="" />
      <?php } else { ?>
        <img style="width: 500px;" src="assets/images/1.jpg" alt="" />
      <?php } ?>

      <form action="create_post.php" method="post" enctype="multipart/form-data" class="camera-form">
        <div class="form-group">
          <input type="file" name="image" class="form-control" required />
        </div>
        <div class="form-group">
          <input type="text" name="caption" class="form-control" placeholder="type captions..." required />
        </div>
        <div class="form-group">
          <input type="text" name="hashtags" class="form-control" placeholder="type hashtags..." required />
        </div>
        <div class="form-group">
          <button type="submit" name="upload_image-btn" class="upload-btn">
            Submit
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/5d47e6cf8c.js"></script>
</body>

</html>