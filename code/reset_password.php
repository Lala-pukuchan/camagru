<?php

session_start();
include("db/connection.php");

if (isset($_POST['reset_password_btn'])) {

    // posted username
    $username = $_POST['username'];

    // get email from db
    $stmtEmail = $conn->prepare("SELECT email FROM users WHERE username = ?");
    $stmtEmail->bind_param("s", $username);
    $stmtEmail->execute();
    $stmtEmail->bind_result($email);
    $stmtEmail->fetch();
    $stmtEmail->close();

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
    $stmt->close();
}

?>
