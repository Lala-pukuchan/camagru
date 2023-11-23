<?php

session_start();

include("db/connection.php");

if (isset($_POST['follow_btn'])) {
    $user_id = $_SESSION['id'];
    $other_user_id = $_POST['other_user_id'];

    // insert into followers table
    $stmt = $conn->prepare("INSERT INTO followings (user_id, other_user_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $other_user_id);

    // increase users following
    $stmt1 = $conn->prepare("UPDATE users SET following = following + 1 WHERE id = ?");
    $stmt1->bind_param("i", $user_id);

    // increase other users followers
    $stmt2 = $conn->prepare("UPDATE users SET followers = followers + 1 WHERE id = ?");
    $stmt2->bind_param("i", $other_user_id);

    $stmt->execute();
    $stmt1->execute();
    $stmt2->execute();

    // update following
    $_SESSION['following'] = $_SESSION['following'] + 1;

    header("location: profile.php?success_message=You are now following this person");

} else {
    header("location: index.php");
    exit();
}


?>