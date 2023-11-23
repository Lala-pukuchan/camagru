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

  <!-- Webcam Feed -->
  <video id="webcam" style="width: 500px; height: auto;" autoplay></video>
  <button id="captureButton">Capture Image</button>

  <!-- Image Preview (after capturing) -->
  <canvas id="canvas" style="width: 500px; height: auto; display: none;"></canvas>

  <div class="camera">
    <div class="camera-image">

      <!--display image-->
      <img id="imagePreview" style="width: 500px;" src="assets/images/1.jpg" alt="" />

      <!--post-->
      <form action="create_post.php" method="post" enctype="multipart/form-data" class="camera-form">

        <!-- Captured Image -->
        <div class="form-group">
          <input type="hidden" name="capturedImage" id="capturedImage">
        </div>

        <!-- Image Upload -->
        <div class="form-group">
          <input type="file" name="image" id="imageInput" class="form-control" required />
        </div>

        <!-- Stamp Gallery -->
        <div class="stamp-gallery">
          <label>Select a Stamp:</label>
          <div class="stamp-options">
            <label>
              <input type="radio" name="stamp" value="stamp1.png">
              <img src="assets/images/stamps/stamp1.png" alt="Stamp 1" class="stamp-preview">
            </label>
          </div>
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


<main>
  <div class="profile-container">
    <div class="gallery">

      <?php include("get_user_post.php"); ?>

      <?php foreach ($posts as $post) { ?>

        <div class="gallery-item" style="flex: 1 0 2rem; !important">
          <img src="<?php echo "assets/images/save/" . $post['image']; ?>" class="gallery-image" alt="" />
          <div class="gallery-item-info">
            <ul>
              <li class="gallery-item-likes">
                <span class="hide-gallery-element">
                  Likes:
                  <?php echo $post['likes']; ?>
                </span>
                <i class="fas fa-heart"></i>
              </li>
            </ul>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/5d47e6cf8c.js"></script>
<script>
  document.getElementById('imageInput').addEventListener('change', function (event) {
    if (event.target.files && event.target.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        document.getElementById('imagePreview').src = e.target.result;
      };

      reader.readAsDataURL(event.target.files[0]);
    }
  });
</script>

<script>
  document.getElementById('imageInput').addEventListener('change', function (event) {
    if (event.target.files && event.target.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        document.getElementById('imagePreview').src = e.target.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  });
</script>
<script>
  const webcamElement = document.getElementById('webcam');
  const canvasElement = document.getElementById('canvas');
  const captureButton = document.getElementById('captureButton');
  const hiddenInput = document.getElementById('capturedImage');
  const context = canvasElement.getContext('2d');

  // Request access to the webcam
  navigator.mediaDevices.getUserMedia({ video: true })
    .then((stream) => {
      webcamElement.srcObject = stream;
    })
    .catch((err) => {
      console.error("Error accessing the webcam", err);
    });

  // Capture the current frame from the webcam and draw it into the canvas
  captureButton.addEventListener('click', () => {
    // Draw the video frame to the canvas
    context.drawImage(webcamElement, 0, 0, canvasElement.width, canvasElement.height);

    // Convert the canvas image to a data URL and set it as the value of the hidden input
    let imageDataURL = canvasElement.toDataURL('image/png');
    hiddenInput.value = imageDataURL;
  });
</script>

</body>

</html>