<?php

include("db/connection.php");

if (isset($_POST['delete_post_btn'])) {
  $post_id = $_POST['post_id'];
  $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
  $stmt->bind_param("i", $post_id);
  
  if ($stmt->execute()) {
    header("location: profile.php?success_message=post deleted succesfully");
  } else {
    header("location: edit_post.php?error_message=error occurred. try again.");
  }
  exit();


} else {
  header("location: index.php");
  exit();
}

?>