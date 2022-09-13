<?php include('../config/constants.php') ?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <script src="https://kit.fontawesome.com/e0836293cf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/login-form.css">
    <link rel="stylesheet" href="../css/backend.css">
</head>

<body>
    <div class="container">
        <h1>Log-In</h1>
        <?php
            if(isset($_SESSION['login'])){
                echo $_SESSION['login']; //display session message
                unset($_SESSION['login']); //removing session message
            }
            if(isset($_SESSION['not-login-message'])){
                echo $_SESSION['not-login-message']; //display session message
                unset($_SESSION['not-login-message']); //removing session message
            }
        ?>
        <form action="" method="POST">

            <div class="box">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="username" placeholder="Enter Your Username">
            </div>

            <div class="box">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="password" placeholder="Enter Your Password">
            </div>

            <input type="submit" name="submit" value="Sign-In" class="btn">
        </form>

    </div>


</body>

</html>

<?php
//Check whether the submit button is clicked or not

    if(isset($_POST['submit'])){
        //process for login
        //1. Get the data from form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = md5($_POST['password']);

        //2. sql to check whether the user with username annd password exist or not
        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";
        //3. Execute the query
        $res = mysqli_query($conn, $sql);
        //count rows to check the user exist or not
        $count = mysqli_num_rows($res);
        if($count==1){
            //user available and login success
            $_SESSION['login'] = "<div class='success'>Login Successfully!!</div>";
            //to check whether the user is login or not and logout will unset it
            $_SESSION['user'] = $username;
            //redirect to home page/dashboard
            header("location:" .SITEURL. 'backend/');
        }
        else{
            //user unavailable and login unsuccessful
            $_SESSION['login'] = "<div class='error'>Username or Password did not match</div>";
            header("location:" .SITEURL. 'backend/login.php');
        }
    }

?>