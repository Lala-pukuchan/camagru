<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Email settings
    $to = "ruruover1105@gmail.com";  // Replace with your fixed email address
    $subject = "Test Email";
    $message = "This is a test email sent from the PHP script.";
    $headers = "From: webmaster@example.com";  // Replace with a valid sender email address

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Email sending failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Email</title>
</head>
<body>
    <form method="post" action="email_sender.php">
        <button type="submit" name="sendEmailBtn">Send Email</button>
    </form>
</body>
</html>
