<?php

session_start();

// check if user is already logged in
if (isset($_SESSION['id'])) {
  header('location: index.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Camagru | Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="icon" href="assets/images/logo.png" type="image/x-icon" />
</head>

<body>
  <div class="container">
    <div class="main-container">
      <div class="main-content">
        <!-- <div class="slide-container" style="background-image: url('assets/images/mobile-frame.png')"> -->
        <div class="slide-container">
          <div class="slide-content" id="slide-content">
            <img src="assets/images/screen1.png" class="active" alt="screen1" />
            <img src="assets/images/screen2.png" alt="screen2" />
            <img src="assets/images/screen3.png" alt="screen3" />
            <img src="assets/images/screen4.png" alt="screen4" />
            <img src="assets/images/screen5.png" alt="screen5" />
          </div>
        </div>
        <div class="form-container">
          <div class="form-content box">
            <div class="logo">
              <img src="assets/images/logo.png" alt="" class="logo-img" />
            </div>
            <form action="includes/process_login.php" class="login-form" id="login-form" method="POST">

              <!--show success message-->
              <?php if (isset($_GET['success_message'])) { ?>

                <p class="text-center alert-success mt-4" id="success_message" style="color:green">
                  <?php echo $_GET['success_message']; ?>
                </p>

              <?php } ?>
              <!--show error message-->
              <?php if (isset($_GET['error_message'])) { ?>

                <p class="text-center alert-danger" id="error_message" style="color:red">
                  <?php echo $_GET['error_message']; ?>
                </p>

              <?php } ?>

              <div class="form-group">
                <div class="login-input">
                  <!--<input type="text" name="email" placeholder="Type your email..." required />-->
                  <input type="text" name="username" placeholder="Type your username..." required autocomplete="username"/>
                </div>
              </div>
              <div class="form-group">
                <div class="login-input">
                  <input type="password" name="password" id="password" placeholder="Type your password..." required autocomplete="current-password"/>
                </div>
              </div>
              <div class="btn-group">
                <button class="login-btn" id="login_btn" type="submit" name="login_btn">
                  Log In
                </button>
              </div>
            </form>
            <div class="or">
              <hr />
              <span>OR</span>
              <hr />
            </div>
            <div class="goto">
              <p>Don't have an account? <a href="signup.php"><br>Sign Up</a></p>
              <p>Want to see gallery without account? <a href="index_public.php">Gallery</a></p>
              <form action="reset_password.php" method="post">
                <p>Forgot your password? <br> Enter your username to reset it.</p>
                <div class="login-input">
                  <input type="text" name="username" placeholder="Enter your username" required>
                </div>
                <button type="submit" name="reset_password_btn" class="reset-password-btn mt-3">Reset Password</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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

    /* Sign Up */
    function verifyForm() {
      var password = document.getElementById('password').value;
      var error_message = document.getElementById('error_message');

      if (password.length <= 8) {
        error_message.innerHTML = "Password length should be more than 8";
        return false;
      }

      return true;
    }

    //document.getElementById("login-form").addEventListener("submit", (e)=> {
    //  e.preventDefault();

    //  verifyForm();
    //})
  </script>
  </body>

</html>