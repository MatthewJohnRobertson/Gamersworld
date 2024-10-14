<?php
// Database connection details
$server = "localhost";
$user = "root";  // replace with your database username
$password = "";  // replace with your database password
$database = "laravel";

// Connect to database
$mysql = new mysqli($server, $user, $password, $database);

// Check connection
if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
} else {
    echo "Success";
    die;
}
