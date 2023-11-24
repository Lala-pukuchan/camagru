<?php

session_start();

include("db/connection.php");

if (isset($_POST['update_profile_btn'])) {

    $user_id = $_SESSION['id'];
    $user_name = $_POST['username'];
    $image = $_FILES['image']['tmp_name'];
    $notification = $_POST['notification'];
    $newPassword = null;
    if (!empty($_POST['password'])) {
        $newPassword = $_POST['password'];
    }

    // check whether username is valid
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $user_name)) {
        header("location: edit_profile.php?error_message=Invalid username");
        exit();
    }

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
            updateUserProfile($conn, $user_name, $image_name, $notification, $user_id, $image, $newPassword);
        }
    } else {
        updateUserProfile($conn, $user_name, $image_name, $notification, $user_id, $image, $newPassword);
    }
} else {
    header("location: edit_profile.php?error_message=error occured, try again");
    exit();
}


function updateUserProfile($conn, $user_name, $image_name, $notification, $user_id, $image, $newPassword)
{
    $stmt = $conn->prepare("UPDATE users SET username = ?, image = ?, notification = ? WHERE id = ?");
    $stmt->bind_param("ssii", $user_name, $image_name, $notification, $user_id);

    if ($stmt->execute()) {

        // if new password is not empty, update password
        if (!empty($newPassword)) {
            // Hash the new password
            $hashedPassword = md5($newPassword);
            // Update the password in the database
            $passwordStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $passwordStmt->bind_param("si", $hashedPassword, $user_id);
            $passwordStmt->execute();
        }

        if ($image != "") {
            // store image into the folder
            move_uploaded_file($image, "assets/images/" . $image_name);
        }

        // update session variables
        $_SESSION["username"] = $user_name;
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