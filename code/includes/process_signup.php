<?php

session_start();

include("../db/connection.php");

if (isset($_POST['signup_btn'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // make sure password match
    if ($password != $password_confirm) {
        header('location:../signup.php?error_message=passwords dont match');
        exit;
    }

    // check whether user already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? or email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header('location:../signup.php?error_message=user already exists');
        exit;
    } else {
        $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        $hashed_password = md5($password);
        $stmt->bind_param('sss', $username, $email, $hashed_password);

        // if user created successfully then return user info
        if ($stmt->execute()) {
            $stmt = $conn->prepare('SELECT id, username, email, image, followers, following, post FROM users WHERE username = ?');
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->bind_result($id, $username, $email, $image, $followers, $following, $post);
            $stmt->fetch();

            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['image'] = $image;
            $_SESSION['followers'] = $followers;
            $_SESSION['following'] = $following;
            $_SESSION['post'] = $post;
            
            // redirect to index.php
            header('location:../index.php');

        } else {
            header('location:../signup.php?error_message=error occured');
            exit();
        }
    }

} else {
    header('location:../signup.php?error_message=error occured');
}


?>