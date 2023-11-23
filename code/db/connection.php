<?php

$host = 'db';
$username = getenv('MYSQL_USER');
$password = getenv('MYSQL_PASSWORD');
$database = getenv('MYSQL_DATABASE');

$conn = mysqli_connect($host, $username, $password, $database)
    or die("Could not connect to database");

?>
