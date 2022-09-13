<?php
//1. include constant.php to access siteurl
include('../config/constants.php');
//2. destroy the session
session_destroy(); //unset $_SESSION['user'];

//2. redirect to login page
header("location:" .SITEURL. 'backend/login.php');

?>