<?php
//include constant file here
include('../config/constants.php');
//1. get the id of an admin to delete the data
$id = $_GET['id'];

// 2. create the sql to delete the data
$sql = "DELETE FROM tbl_admin WHERE id=$id";
//Execute the query
$res = mysqli_query($conn, $sql);

//check the query executed successfully or not
if($res==true){
    //Query executed successfully and admin deleted
    // echo "delete successfully";\
    //create session vaiable for display the message
    $_SESSION['delete'] = "<div class='success'>Admin deleted successfully!</div>";
    // redirect to our manage admin page
    header('location:' .SITEURL. 'backend/manage-admin.php');
}
else{
    //failed to delete
    // echo "failed to delete";
    $_SESSION['delete'] = "<div class='error'>Failed to delete Admin. Try again later</div>";
    header('location:' .SITEURL. 'backend/manage-admin.php');
}
//3. redirect to manage admin page with a notification (success or error)




?>