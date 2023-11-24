<?php

session_start();
include("db/connection.php");

if (isset($_POST['reset_password_btn'])) {
    $email = $_POST['email'];

    // Generate a random temporary password
    $temporaryPassword = bin2hex(random_bytes(8)); // 16 characters long

    // Hash the temporary password
    $hashedTempPassword = md5($temporaryPassword);

    // Update the database with the hashed temporary password
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashedTempPassword, $email);
    if ($stmt->execute()) {
        // Send the temporary password to the user's email
        $to = $email;
        $subject = "Your Temporary Password";
        $message = "Your temporary password is: " . $temporaryPassword . "\nPlease log in and change your password immediately.";
        $headers = "From: webmaster@example.com";
        
        if (mail($to, $subject, $message, $headers)) {
            header('location:../login.php?success_message=An email with a temporary password has been sent to your email address.');
        } else {
            header('location:../login.php?error_message=Failed to send the email with a temporary password.');
        }
    } else {
        header('location:../login.php?error_message=Failed to update the password.');
    }
}

?>
