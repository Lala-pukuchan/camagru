<?php
$servername = "db";  // Your DB host
$username = "user";  // Your DB username
$password = "password";  // Your DB password
$dbname = "mydatabase";  // Your DB name

// Function to establish a database connection
function connectDB() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
