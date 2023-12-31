<?php

// config for cloudinary
require 'vendor/autoload.php';

use Cloudinary\Cloudinary;

// Include the Cloudinary configuration
$config = require 'cloudinary/config.php';

// Initialize Cloudinary with the configuration settings
$cloudinary = new Cloudinary($config);

session_start();

include("db/connection.php");

include("cloudinary/config.php");

if (isset($_POST['upload_image-btn'])) {

    $id = $_SESSION['id'];
    $username = $_SESSION['username'];
    $profile_image = $_SESSION['image'];
    $caption = $_POST['caption'];
    $hashtags = $_POST['hashtags'];
    $image = $_FILES['image']['tmp_name'];
    // $stampFilename = $_POST['stamp'];
    // $stampPath = "assets/images/stamps/" . $stampFilename;
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

        // Create image resource from base64 string
        $im = imagecreatefromstring($imageData);

        // Create a data stream from the decoded image data
        try {
            $response = $cloudinary->uploadApi()->upload("data:image/png;base64," . base64_encode($imageData), [
                'folder' => 'uploads/'
            ]);
            $uploadedFileUrl = $response['secure_url'];
        } catch (Exception $e) {
            error_log('Error uploading to Cloudinary: ' . $e->getMessage());
            header("location: camera.php?error_message=Error uploading image");
            exit();
        }

    } elseif ($selectedOption == 'upload' && isset($_FILES['image'])) {

        // Process uploaded image
        $image = $_FILES['image']['tmp_name'];
        $imageType = exif_imagetype($image);

        // Define the image name
        $image_name = 'uploaded_image_' . time();
        $image_name .= ($imageType == IMAGETYPE_PNG) ? '.png' : '.jpg';

        // create IM
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $im = imagecreatefromjpeg($image);
                break;
            case IMAGETYPE_PNG:
                $im = imagecreatefrompng($image);
                break;
            default:
                header("location: camera.php?error_message=Invalid image format");
                exit();
        }

        // upload tmp file
        try {
            $response = $cloudinary->uploadApi()->upload($image, [
                'folder' => 'uploads/'
            ]);
            $uploadedFileUrl = $response['secure_url'];
        } catch (Exception $e) {
            error_log('Error uploading to Cloudinary: ' . $e->getMessage());
            header("location: camera.php?error_message=Error uploading image without stamp");
            exit();
        }
        
    } else {
        // Handle error
        header("location: camera.php?error_message=No image provided");
        exit();
    }

    // Your stamp positioning logic here
    $marge_right = 50; // This could be dynamic based on the number of stamps
    $marge_top = 10;   // This could also be dynamic

    // Check if at least one stamp is selected and 'no_stamp' is not selected
    if (isset($_POST['stamp']) && !in_array('no_stamp', $_POST['stamp'])) {

        foreach ($_POST['stamp'] as $index => $stampFilename) {

            $stampPath = "assets/images/stamps/" . $stampFilename;

            // Stamp image resource
            $stamp = imagecreatefrompng($stampPath);
            if (!$stamp) {
                imagedestroy($im);
                die("Failed to create stamp image from file");
            }

            // Adjust margins for subsequent stamps
            if ($index > 0) {
                $marge_right += 50 * $index; // Increment right margin for each stamp
                $marge_top += 30 * $index;   // Increment top margin for each stamp (you can adjust this value as needed)
            }

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

            // Start output buffering
            ob_start();
            imagepng($im); // Output the image data
            $imageData = ob_get_contents(); // Get the image data from buffer
            ob_end_clean(); // End and clean the buffer

            // Clean up
            imagedestroy($im);
            imagedestroy($stamp);
            imagedestroy($resizedStamp);

        }

        // Upload the stamped image data to Cloudinary
        try {
            $response = $cloudinary->uploadApi()->upload("data:image/png;base64," . base64_encode($imageData), [
                'folder' => 'uploads/'
            ]);
            $uploadedFileUrl = $response['secure_url'];
        } catch (Exception $e) {
            error_log('Error uploading to Cloudinary: ' . $e->getMessage());
            header("location: camera.php?error_message=Error uploading image");
            exit();
        }
    }


    // put stamp if stamp is selected
    // if ($stampFilename !== 'no_stamp') {

    //     // stamp image resource
    //     $stamp = imagecreatefrompng($stampPath);
    //     if (!$stamp) {
    //         imagedestroy($im);
    //         die("Failed to create stamp image from file");
    //     }

    //     // Set the margins for the stamp (top right corner)
    //     $marge_right = 50;
    //     $marge_top = 10;
    //     $sx = imagesx($stamp);
    //     $sy = imagesy($stamp);
    //     $imWidth = imagesx($im);
    //     $imHeight = imagesy($im);

    //     // Determine the size ratio
    //     $maxStampWidth = $imWidth * 0.2;
    //     $ratio = $maxStampWidth / $sx;
    //     $newStampWidth = intval($maxStampWidth);
    //     $newStampHeight = intval($sy * $ratio);

    //     // Resize the stamp
    //     $resizedStamp = imagecreatetruecolor($newStampWidth, $newStampHeight);
    //     imagealphablending($resizedStamp, false);
    //     imagesavealpha($resizedStamp, true);
    //     imagecopyresampled($resizedStamp, $stamp, 0, 0, 0, 0, $newStampWidth, $newStampHeight, $sx, $sy);

    //     // Copy the stamp image onto our photo using the margin offsets and the photo
    //     imagecopy($im, $resizedStamp, $imWidth - $newStampWidth - $marge_right, $marge_top, 0, 0, $newStampWidth, $newStampHeight);

    //     // Start output buffering
    //     ob_start();
    //     imagepng($im); // Output the image data
    //     $imageData = ob_get_contents(); // Get the image data from buffer
    //     ob_end_clean(); // End and clean the buffer

    //     // Clean up
    //     imagedestroy($im);
    //     imagedestroy($stamp);
    //     imagedestroy($resizedStamp);

    //     // Upload the stamped image data to Cloudinary
    //     try {
    //         $response = $cloudinary->uploadApi()->upload("data:image/png;base64," . base64_encode($imageData), [
    //             'folder' => 'uploads/'
    //         ]);
    //         $uploadedFileUrl = $response['secure_url'];
    //     } catch (Exception $e) {
    //         error_log('Error uploading to Cloudinary: ' . $e->getMessage());
    //         header("location: camera.php?error_message=Error uploading image");
    //         exit();
    //     }
    // }

    // insert into posts table
    $stmt = $conn->prepare("INSERT INTO posts (user_id, likes, image, caption, hashtags, date, username, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssss", $id, $like, $uploadedFileUrl, $caption, $hashtags, $date, $username, $profile_image);

    // update post number in user table
    if ($stmt->execute()) {

        // increase number of post
        $stmt = $conn->prepare("UPDATE users SET post = post + 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // update session
        $_SESSION["post"] = $_SESSION["post"] + 1;

        // redirect with success message
        header("location: camera.php?success_message=Post has been created successfully&image_name=" . $image_name);
        exit();

    } else {

        // redirect with error message
        header("location: camera.php?error_message=error occured, try again");
        exit();
    }

} else {

    header("location: camera.php?error_message=error occured, try again");
    exit();
}

?>