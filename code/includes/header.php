<?php

session_start();

// if user is not logged in, redirect to login page
if (!isset($_SESSION['id'])) {

    header("Location: login.php");
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Camagru</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="icon" href="assets/images/logo.png" type="image/x-icon">
</head>

<body>
    <!--navigation bar-->
    <nav class="navbar">
        <div class="nav-wrapper">
            <img class="brand-img" src="assets/images/logo.png" />
            <!--<form class="search-form" action="">
                <input type="text" class="search-box" placeholder="search..." />
            </form>-->
            <div class="nav-items">
                <a href="index.php" style="color: #000;"><i class="icon fas fa-home"></i></a>
                <!--<i class="icon fas fa-plus"></i>-->
                <!--<i class="icon fas fa-heart"></i>-->
                <a href="logout.php" style="color: #000;">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
                <div class="icon user-profile">
                    <a href="profile.php" style="color: #000;"><i class="icon fas fa-user"></i></a>
                </div>
            </div>
        </div>
    </nav>