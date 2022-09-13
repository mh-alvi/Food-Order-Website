<?php
// starting session
session_start();


// create contants for store non repeating values
define('SITEURL', 'http://localhost/project1/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'food-item');

// Execute query to save data in database
$conn = mysqli_connect(LOCALHOST, 'root', '') or die(mysqli_error($conn)); // Database connection
$db_select = mysqli_select_db($conn, 'food-item') or die(mysqli_error($conn)); // Selecting database

?>