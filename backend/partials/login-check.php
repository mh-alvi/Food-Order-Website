<?php
//Authorization or Access control
//Check whether the user login or not
if(!isset($_SESSION['user'])) //if user session is not set
{
    //user is not logged in
    //redirect to login page with a message
    $_SESSION['not-login-message'] = "<div class='error'>Please login to access admin panel</div>";
            header("location:" .SITEURL. 'backend/login.php');
}


?>