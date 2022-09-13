<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br /><br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; // display session message
            unset($_SESSION['add']); // removing session message
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your name">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Your username">
                    </td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter your password">
                    </td>
                </tr>
                <tr colspan="2">
                    <td>
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php') ?>

<?php
// process the value from form and save it into the database
// check whether the button is clicked or not

if (isset($_POST['submit'])) {
    // Button is clicked
    // echo "Button Clicked";
    // 1. taking value from form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //password encrition with md5

    // 2. sql query to save the data into database
    $sql = "INSERT INTO tbl_admin SET
        full_name = '$full_name',
        username = '$username',
        password = '$password'
    ";

    // Execute query to save data in database
    $conn = mysqli_connect('localhost', 'root', '') or die(mysqli_error($conn)); // Database connection
    $db_select = mysqli_select_db($conn, 'food-item') or die(mysqli_error($conn)); // Selecting database

    // 3. Executing sql and saving data in database
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    // 4. check whether the (Query is executed) data is inserted or not and display appropriate message
    if ($res == true) {
        // data is inserted
        // echo "Data inserted";
        // create a session variable to Display message
        $_SESSION['add'] = "<div class='success'>Admin Added Successfully!</div>";
        // redirecting page to manage admin
        header("location:" . SITEURL . 'backend/manage-admin.php');
    }
    else {
        // failed to insert
        // echo "failed to insert";
        // create a session variable to Display message
        $_SESSION['add'] = "<div class='error'>Failed to Add Admin!!</div>";
        // redirecting Add admin page
        header("location:" . SITEURL . 'backend/add-admin.php');
    }
}


?>