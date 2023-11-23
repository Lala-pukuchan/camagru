<?php

session_start();

include("db/connection.php");

if (isset($_POST['upload_image-btn'])) {

    $id = $_SESSION['id'];
    $username = $_SESSION['username'];
    $profile_image = $_SESSION['image'];
    $caption = $_POST['caption'];
    $hashtags = $_POST['hashtags'];
    $image = $_FILES['image']['tmp_name'];
    $stampFilename = $_POST['stamp'];
    $like = 0;
    $date = date("Y-m-d H:i:s");


    $imageDataUrl = $_POST['capturedImage'];

    // Convert data URL to image data
    list($type, $imageDataUrl) = explode(';', $imageDataUrl);
    list(, $imageDataUrl) = explode(',', $imageDataUrl);
    $imageData = base64_decode($imageDataUrl);

    // Determine the image type
    $imageType = '';
    if (stristr($type, 'png')) {
        $imageType = 'png';
    } else if (stristr($type, 'jpeg') || stristr($type, 'jpg')) {
        $imageType = 'jpg';
    }

    // Save the image
    $imageName = 'captured_image_' . time() . '.' . $imageType;
    file_put_contents('assets/images/' . $imageName, $imageData);

    $image_name = strval(time()) . ".jpg";
    $stampPath = "assets/images/stamps/" . $stampFilename;

    // check if stamp file exists
    if (!file_exists($stampPath)) {
        header("location: camera.php?error_message=stamp file does not exist");
        exit();
    }
    // check if stamp file is readable
    if (!is_readable($stampPath)) {
        header("location: camera.php?error_message=stamp file is not readable");
        exit();
    }

    // check image type and create image resource
    list($width, $height, $imageType) = getimagesize($image);
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $im = imagecreatefromjpeg($image);
            break;
        case IMAGETYPE_PNG:
            $im = imagecreatefrompng($image);
            break;
        default:
            header("location: camera.php?error_message=upload image must be jpg or png");
            exit();
    }

    // stamp image resource
    $stamp = imagecreatefrompng($stampPath);
    if (!$stamp) {
        imagedestroy($im);
        die("Failed to create stamp image from file");
    }

    // Set the margins for the stamp (top right corner)
    $marge_right = 10;
    $marge_top = 10;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);

    imagealphablending($im, true); // Setting alpha blending on
    imagesavealpha($im, true); // Save alpha channel information

    imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, $marge_top, 0, 0, imagesx($stamp), imagesy($stamp));
    // Save the final image as PNG to preserve transparency
    imagepng($im, "assets/images/save/" . str_replace('.jpg', '.png', $image_name));

    // Save the final image to the assets/images directory
    //imagejpeg($im, "assets/images/save/" . $image_name);


    // Clean up
    imagedestroy($im);
    imagedestroy($stamp);

    // insert into posts table
    $stmt = $conn->prepare("INSERT INTO posts (user_id, likes, image, caption, hashtags, date, username, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssss", $id, $like, $image_name, $caption, $hashtags, $date, $username, $profile_image);


    if ($stmt->execute()) {

        // store img in assets/images
        move_uploaded_file($image, "assets/images/" . $image_name);

        // increase number of post
        $stmt = $conn->prepare("UPDATE users SET post = post + 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $_SESSION["post"] = $_SESSION["post"] + 1;

        header("location: camera.php?success_message=Post has been created successfully&image_name=" . $image_name);
        exit();
    } else {

        header("location: camera.php?error_message=error occured, try again");
        exit();
    }


} else {

    header("location: camera.php?error_message=error occured, try again");
    exit();
}

?>