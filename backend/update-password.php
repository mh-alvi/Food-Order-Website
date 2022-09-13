<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br /><br />

        <?php
        //1. Get the id of selected admin
        $id = $_GET['id'];
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Old Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current password">
                    </td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
//check whether submit is clicked or not
if (isset($_POST['submit'])) {
    // echo "Clicked";

    //1. Get the data from form
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    //2. Check whether the current id and the current password exist or not
    $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password = '$current_password'";
    //execute the query
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        //Check whether data is available or not
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            //User exist and password can be changed
            // echo "User found";
            //Check whether the new password and confirm password match
            if ($new_password == $confirm_password) {
                //Update the password
                $sql2 = "UPDATE tbl_admin SET
                password='new_password' 
                WHERE id=$id";
                //execute the query
                $res2 = mysqli_query($conn, $sql2);
                //check the query executed or not
                if($res2==true){
                    //change the password
                    $_SESSION['change-pass'] = "<div class='success'>Password Changed Successfully</div>";
                //redirecting to the manage-admin
                header("location:" . SITEURL . 'backend/manage-admin.php');
                }
                else{
                    //Failed to change the password
                    $_SESSION['change-pass'] = "<div class='error'>Failed to change the password!!</div>";
                //redirecting to the manage-admin
                header("location:" . SITEURL . 'backend/manage-admin.php');
                }

            }
            else {
                //if password is not changed then redirect to manage-admin page
                //User doesn't exist and password can't be changed
                $_SESSION['pass-not-matched'] = "<div class='error'>Password did not match!!</div>";
                //redirecting to the manage-admin
                header("location:" . SITEURL . 'backend/manage-admin.php');
            }
        }
        else {
            //User doesn't exist and password can't be changed
            $_SESSION['user-not-found'] = "<div class='error'>User Not Found!!</div>";
            //redirecting to the manage-admin
            header("location:" . SITEURL . 'backend/manage-admin.php');
        }
    }
    //3. Check whether the new password or current password match or not
    //4. Change password if all terms are true
}

?>


<?php include('partials/footer.php') ?>