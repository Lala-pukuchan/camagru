<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Camagru | SignUp</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
  <div class="container">
    <div class="main-container">
      <div class="main-content">
        <div class="slide-container" style="background-image: url('assets/images/mobile-frame.png')">
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
            <form action="includes/process_signup.php" class="login-form" id="signup-form" method="POST">

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
                  <input type="text" name="email" placeholder="Type your email..." required />
                </div>
              </div>
              <div class="form-group">
                <div class="login-input">
                  <input type="text" name="username" placeholder="Type your username..." required />
                </div>
              </div>
              <div class="form-group">
                <div class="login-input">
                  <input type="password" name="password" id="password" placeholder="Type your password..." required />
                </div>
              </div>
              <div class="form-group">
                <div class="login-input">
                  <input type="password" name="password_confirm" id="password_confirm"
                    placeholder="Type your password again..." required />
                </div>
              </div>
              <div class="btn-group">
                <button class="login-btn" id="signup_btn" type="submit" name="signup_btn">
                  Sign Up
                </button>
              </div>
            </form>
            <div class="or">
              <hr />
              <span>OR</span>
              <hr />
            </div>
            <div class="goto">
              <p>Already have an account? <a href="login.php">Login</a></p>
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
      var password_confirm = document.getElementById('password_confirm').value;
      var error_message = document.getElementById('error_message');

      if (password.length <= 8) {
        error_message.innerHTML = "Password length should be more than 8";
        return false;
      }

      if (password != password_confirm) {
        error_message.innerHTML = "Password don't match";
        return false;
      }
      return true;
    }

    //document.getElementById("signup-form").addEventListener("submit", (e)=> {
    //  e.preventDefault();

    //  verifyForm();
    //})



  </script>
  </body>

</html>