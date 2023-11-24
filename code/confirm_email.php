<?php

include("db/connection.php");

if (isset($_GET['email_confirm_token'])) {
    $token = $_GET['email_confirm_token'];

    // Prepare the statement
    $stmt = $conn->prepare('SELECT id FROM users WHERE email_confirm_token = ?');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $stmt->store_result();

    // Check if a user with that token exists
    if ($stmt->num_rows > 0) {
        // If user found, update the database to confirm the email
        $update_stmt = $conn->prepare('UPDATE users SET email_confirmed = 1 WHERE email_confirm_token = ?');
        $update_stmt->bind_param('s', $token);
        $update_stmt->execute();

        // Redirect to the index page with a success message
        header('location: index.php?success_message=Registration successful');
        exit;
    } else {
        // Redirect to an error page or display an error
        header('location: error_page.php?error_message=Invalid token');
        exit;
    }
} else {
    // Token not set in URL
    header('location: error_page.php?error_message=Token not provided');
    exit;
}
?>