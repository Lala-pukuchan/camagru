<?php

session_start();

include("../db/connection.php");


if (isset($_POST['login_btn'])) {

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT id, username, email, image, followers, following, post, bio, notification, email_confirmed FROM users WHERE email = ? AND password = ?");

    $stmt->bind_param("ss", $email, $password);

    $stmt->execute();

    $stmt->store_result();

    // if user exists
    if ($stmt->num_rows() > 0) {
        $stmt->bind_result($id, $username, $email, $image, $followers, $following, $post, $bio, $notification, $email_confirmed);
        $stmt->fetch();

        // Check if the email is confirmed
        if ($email_confirmed) {
            // Email is confirmed, proceed with login
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['image'] = $image;
            $_SESSION['followers'] = $followers;
            $_SESSION['following'] = $following;
            $_SESSION['post'] = $post;
            $_SESSION['bio'] = $bio;
            $_SESSION['notification'] = $notification;

            header('location:../index.php');
        } else {
            // Email is not confirmed, redirect to a relevant page
            header('location:../login.php?error_message=Please confirm your email address.');
        }

    } else {
        header('location:../login.php?error_message=Email or password is incorrect');
        exit;
    }


} else {
    header('location:../login.php?error_message=error occured');
    exit;
}

?>