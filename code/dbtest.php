<?php
include 'dbconfig.php';

$conn = connectDB();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";

$conn->close();
?>

