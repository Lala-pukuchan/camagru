<?php

session_start();

include("db/connection.php");

if (isset($_POST['update_profile_btn'])) {

    $user_id = $_SESSION['id'];
    $user_name = $_POST['username'];
    $bio = $_POST['bio'];
    $image = $_FILES['image']['tmp_name'];
    $notification = $_POST['notification'];

    if ($image != "") {
        $image_name = $user_name . ".jpg";
    } else {
        $image_name = $_SESSION['image'];
    }

    if ($user_name != $_SESSION['username']) {

        // check whether username is unique
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");

        $stmt->bind_param("s", $user_name);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows() > 0) {
            header("location: edit_profile.php?error_message=Username already exists");
            exit();
        } else {
            updateUserProfile($conn, $user_name, $bio, $image_name, $notification, $user_id, $image);
        }
    } else {
        updateUserProfile($conn, $user_name, $bio, $image_name, $notification, $user_id, $image);
    }
} else {
    header("location: edit_profile.php?error_message=error occured, try again");
    exit();
}


function updateUserProfile($conn, $user_name, $bio, $image_name, $notification, $user_id, $image)
{
    $stmt = $conn->prepare("UPDATE users SET username = ?, bio = ?, image = ?, notification = ? WHERE id = ?");
    $stmt->bind_param("sssii", $user_name, $bio, $image_name, $notification, $user_id);

    if ($stmt->execute()) {
        if ($image != "") {
            // store image into the folder
            move_uploaded_file($image, "assets/images/" . $image_name);
        }

        // update session variables
        $_SESSION["username"] = $user_name;
        $_SESSION["bio"] = $bio;
        $_SESSION["image"] = $image_name;
        $_SESSION["notification"] = $notification;

        updateProfileImageAndUserNameInPostsTable($conn, $user_name, $image_name, $user_id);
        updateProfileImageAndUserNameInCommentsTable($conn, $user_name, $image_name, $user_id);

        header("location: profile.php?success_message=Profile updated successfully");
        exit();

    } else {
        header("location: edit_profile.php?error_message=error occured, try again");
        exit();
    }
}


function updateProfileImageAndUserNameInCommentsTable($conn, $user_name, $image_name, $user_id)
{
    $stmt = $conn->prepare("UPDATE comments SET username = ?, profile_image = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $user_name, $image_name, $user_id);
    $stmt->execute();
}

function updateProfileImageAndUserNameInPostsTable($conn, $user_name, $image_name, $user_id)
{
    $stmt = $conn->prepare("UPDATE posts SET username = ?, profile_image = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $user_name, $image_name, $user_id);
    $stmt->execute();
}



?>