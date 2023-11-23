<?php

session_start();

include("db/connection.php");

if (isset($_POST['comment_btn'])) {
    $user_id = $_SESSION['id'];
    $username = $_SESSION['username'];
    $profile_image = $_SESSION['image'];
    $post_id = $_POST['post_id'];
    $comment_text = $_POST['comment_text'];
    $date = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, username, profile_image, comment_text, date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $post_id, $user_id, $username, $profile_image, $comment_text, $date);

    if ($stmt->execute()) {

        // success message
        header("location: single_post.php?post_id=" . $post_id . "&success_message=Comment added successfully!");

        // notification
        $stmt = $conn->prepare("SELECT user_id FROM posts WHERE id = ?");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $stmt->bind_result($post_user_id);
        $stmt->fetch();
        $stmt->close();

        if (isset($post_user_id)) {
            $sql = "SELECT email, notification FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $post_user_id);
            $stmt->execute();
            $stmt->bind_result($post_user_email, $notification);
            $stmt->fetch();
            $stmt->close();
        }

        if (isset($notification) && $notification) {
            $to = $post_user_email;
            $subject = 'Comment Notification';
            $message = 'Someone has commented on your post.';
            $headers = 'From: webmaster@example.com' . "\r\n" .
                'Reply-To: webmaster@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            if (!mail($to, $subject, $message, $headers)) {
                echo 'Mailer Error: Unable to send email.';
            } else {
                echo 'Notification sent successfully.';
            }
        }

    } else {
        header("location: single_post.php?post_id=" . $post_id . "&error_message=Something went wrong. Please try again!");
    }
    exit();

} else {
    header("location: index.php");
    exit();
}
?>