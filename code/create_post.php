<?php

session_start();

include("db/connection.php");

if (isset($_POST['upload_image-btn'])) {

    $id = $_SESSION['id'];
    $username = $_SESSION['username'];
    $profile_image = $_SESSION['image'];
    $caption = $_POST['caption'];
    $hashtags = $_POST['hashtags'];
    $image = $_FILES['image']['tmp_name']; // file
    $like = 0;
    $date = date("Y-m-d H:i:s");

    $image_name = strval(time()) . ".jpg";

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