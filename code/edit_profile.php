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
          <img src="<?php echo "assets/images/" . $_SESSION['image']; ?>" class="edit-profile-image" alt="" />
          <input type="file" name="image" class="form-control" />
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <p class="form-control">email</p>
        </div>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" name="username" id="username" placeholder="username" />
        </div>
        <div class="mb-3">
          <label for="bio" class="form-label">Bio</label>
          <textarea name="bio" id="bio" class="form-control" cols="30" rows="3"></textarea>
        </div>
        <div class="mb-3">
          <input name="update_profile_btn" id="update_profile_btn" name="update_profile_btn" class="update-profile-btn"
            value="update" type="submit" />
        </div>
      </form>
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
        <button class="logout-btn">logout</button>
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