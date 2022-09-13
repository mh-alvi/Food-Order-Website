<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br /><br />

        <?php 
        //1. Get the id of selected admin
        $id = $_GET['id'];
        //2. Create sql query to get the details
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        //check whether the query is executed or not
        if($res==true){
            //check the data is available or not
            $count = mysqli_num_rows($res);
            //check whether we have admin data or not
            if($count==1){
                //get the details
                // echo "Admin available";
                $rows= mysqli_fetch_assoc($res);
                $full_name = $rows['full_name'];
                $username = $rows['username'];
            }
            else{
                //redirect to manage admin page
                header('location:' .SITEURL. 'backend/manage-admin.php');
            }
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Your username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                
            </table>
        </form>
    </div>
</div>

<?php 

//check whether the submit button is clicked or not
if(isset($_POST['submit'])){
    // echo "button clicked";
    //Get all the from the form
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    //Create a sql query to update admin
    $sql = "UPDATE tbl_admin SET
    full_name = '$full_name',
    username = '$username'
    WHERE id = $id";

    //executing the query
    $res = mysqli_query($conn, $sql);

    //check the query executed successfully or not
    if($res==true){
        //Query executed successfully
        $_SESSION['update'] = "<div class='success'>Admin Updated Successfully!</div>";
        header("location:" .SITEURL. 'backend/manage-admin.php'); //redirect to manage-admin page
    }
    else{
        //failed to execute the query
        $_SESSION['update'] = "<div class='error'>Failed to Update Admin!</div>";
        header("loaction:" .SITEURL. 'backend/manage-admin.php'); //redirect to manage-admin page
    }
}

?>

<?php include('partials/footer.php') ?>