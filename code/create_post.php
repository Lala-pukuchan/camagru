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
    $stampPath = "assets/images/stamps/" . $stampFilename;
    $like = 0;
    $date = date("Y-m-d H:i:s");
    $selectedOption = $_POST['selectedOption'];

    // Determine if the image is uploaded or captured
    if ($selectedOption == 'webcam') {
        // Process captured webcam image
        $imageDataUrl = $_POST['capturedImage'];
        list(, $imageDataUrl) = explode(',', $imageDataUrl);
        $imageData = base64_decode($imageDataUrl);

        // Define the image name
        $image_name = 'captured_image_' . time() . '.png';

        // Save the image
        file_put_contents('assets/images/save/' . $image_name, $imageData);
    } elseif ($selectedOption == 'upload' && isset($_FILES['image'])) {
        // Process uploaded image
        $image = $_FILES['image']['tmp_name'];
        $imageType = exif_imagetype($image);

        // Define the image name
        $image_name = 'uploaded_image_' . time();
        $image_name .= ($imageType == IMAGETYPE_PNG) ? '.png' : '.jpg';

        // Move the uploaded file
        move_uploaded_file($image, 'assets/images/save/' . $image_name);
    } else {
        // Handle error
        header("location: camera.php?error_message=No image provided");
        exit();
    }

    // Load the image for stamp processing
    switch (exif_imagetype('assets/images/save/' . $image_name)) {
        case IMAGETYPE_JPEG:
            $im = imagecreatefromjpeg('assets/images/save/' . $image_name);
            break;
        case IMAGETYPE_PNG:
            $im = imagecreatefrompng('assets/images/save/' . $image_name);
            break;
        default:
            header("location: camera.php?error_message=Invalid image format");
            exit();
    }

    // stamp image resource
    $stamp = imagecreatefrompng($stampPath);
    if (!$stamp) {
        imagedestroy($im);
        die("Failed to create stamp image from file");
    }

    // Set the margins for the stamp (top right corner)
    $marge_right = 50;
    $marge_top = 10;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);
    $imWidth = imagesx($im);
    $imHeight = imagesy($im);

    // Determine the size ratio
    $maxStampWidth = $imWidth * 0.2;
    $ratio = $maxStampWidth / $sx;
    $newStampWidth = intval($maxStampWidth);
    $newStampHeight = intval($sy * $ratio);

    // Resize the stamp
    $resizedStamp = imagecreatetruecolor($newStampWidth, $newStampHeight);
    imagealphablending($resizedStamp, false);
    imagesavealpha($resizedStamp, true);
    imagecopyresampled($resizedStamp, $stamp, 0, 0, 0, 0, $newStampWidth, $newStampHeight, $sx, $sy);

    // Copy the stamp image onto our photo using the margin offsets and the photo
    imagecopy($im, $resizedStamp, $imWidth - $newStampWidth - $marge_right, $marge_top, 0, 0, $newStampWidth, $newStampHeight);
    imagepng($im, "assets/images/save/" . $image_name);

    // Clean up
    imagedestroy($im);
    imagedestroy($stamp);
    imagedestroy($resizedStamp);

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