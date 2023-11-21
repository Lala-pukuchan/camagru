<?php 

// Start or Resume Session
session_start();

// Clear Session Data
session_unset();

// Destroy the Session
session_destroy();

// Redirect to Login Page
header("location: login.php");

exit();

?>