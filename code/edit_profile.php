<?php include("includes/header.php"); ?>

<!--section-->
<section class="main">
  <div class="wrapper">
    <div class="left-col">
      <h3>Update Profile</h3>

      <!--show error message-->
      <?php if (isset($_GET['error_message'])) { ?>

        <p class="text-center alert-danger" id="error_message" style="color:red">
          <?php echo $_GET['error_message']; ?>
        </p>

      <?php } ?>

      <form action="update_profile.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <img src="<?php echo $_SESSION['image']; ?>" class="edit-profile-image" alt="" />
          <input type="file" name="image" class="form-control" />
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="text" class="form-control" name="email" id="email" placeholder="email"
            value="<?php echo $_SESSION['email'] ?>" required />
        </div>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" name="username" id="username" placeholder="username"
            value="<?php echo $_SESSION['username'] ?>" required />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password"
            placeholder="Enter new password if you wish to change it">
        </div>
        <div class="mb-3">
          <label class="form-label">Notifications</label>
          <div>
            <input type="radio" id="notify_yes" name="notification" value="1" <?php echo ($_SESSION['notification'] == 1 ? 'checked' : ''); ?>>
            <label for="notify_yes">Yes</label>
          </div>
          <div>
            <input type="radio" id="notify_no" name="notification" value="0" <?php echo ($_SESSION['notification'] == 0 ? 'checked' : ''); ?>>
            <label for="notify_no">No</label>
          </div>
        </div>
        <div class="mb-3">
          <input name="update_profile_btn" id="update_profile_btn" name="update_profile_btn" class="update-profile-btn"
            value="update" type="submit" />
        </div>
      </form>
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
<script src="https://kit.fontawesome.com/5d47e6cf8c.js"></script>
</body>

</html>