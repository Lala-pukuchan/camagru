<?php

include("db/connection.php");

session_start();

if (isset($_POST['delete_post_btn'])) {
  $post_id = $_POST['post_id'];
  $stmt = $conn->prepare("DELETE FROM posts WHERE id = ? and user_id = ?");
  $stmt->bind_param("ii", $post_id, $_SESSION['id']);

  $_SESSION['post'] = $_SESSION['post'] - 1;
  
  if ($stmt->execute()) {
    header("location: profile.php?success_message=post deleted succesfully");
  } else {
    header("location: profile.php?error_message=error occurred. try again.");
  }
  exit();


} else {
  header("location: index.php");
  exit();
}

?>