<?php

session_start();

include("../db/connection.php");

if (isset($_POST['signup_btn'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $bio = "not set yet";
    $image = "default.png";

    // make sure password match
    if ($password != $password_confirm) {
        header('location:../signup.php?error_message=passwords dont match');
        exit;
    }

    // Password complexity check
    if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,}$/', $password)) {
        header('location:../signup.php?error_message=password not complex enough');
        exit;
    }

    // check whether user already exists
    //$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? or email = ?");
    //$stmt->bind_param("ss", $username, $email);
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header('location:../signup.php?error_message=user already exists');
        exit;
    } else {
        $email_confirm_token = bin2hex(random_bytes(16));
        $stmt = $conn->prepare('INSERT INTO users (username, email, image, password, bio, email_confirm_token) VALUES (?, ?, ?, ?, ?)');
        $hashed_password = md5($password);
        $stmt->bind_param('ssssss', $username, $email, $image, $hashed_password, $bio, $email_confirm_token);

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
            header('location:../signup.php?success_message=please check your email to confirm your registration');

            // send confirmation email
            $to = $email;
            $subject = 'Confirm your email';
            $headers = 'From: webmaster@example.com' . "\r\n" .
                'Reply-To: webmaster@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            $confirmLink = "http://localhost:1080/confirm_email.php?email_confirm_token=" . $email_confirm_token;
            $message = 'Please click on the following link to confirm your registration: ' . $confirmLink;

            if (!mail($to, $subject, $message, $headers)) {
                echo $message;
            } else {
                echo 'Notification sent successfully.';
            }

        } else {
            header('location:../signup.php?error_message=error occured');
            exit();
        }
    }

} else {
    header('location:../signup.php?error_message=error occured');
}


?>