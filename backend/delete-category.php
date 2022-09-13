<?php
//include constants file
include('../config/constants.php');

//1. check whether id and image_name is set or not
if(isset($_GET['id']) AND isset($_GET['image_name'])){
    //Get the value and delete
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //2. remove physical image file if available
    if($image_name != ""){
        //found the image and delete it
        //Get the image path
        $path = "../images/category-image/".$image_name;

        //remove image file from folder
        $remove = unlink($path);

        //check whether the image removed or not
        if($remove == false){
            //failed to remove image
            $_SESSION['remove'] = "<div class='error'>Failed to Remove Image!!</div>";
            //redirect to manage admin page
            header("location:" .SITEURL. 'backend/manage-category.php');
            die(); //stop the process
        }

    }
     //3. Delete the food from database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //Check whether the query is executed or not set the session message respectively
        //4. redirect to manage food with message
        if($res == true){
            //food deleted
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
            header("location:" .SITEURL. 'backend/manage-category.php');
        }
        else{
            //failed to delete food
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category</div>";
            header("location:" .SITEURL. 'backend/manage-category.php');

        }
    //redirect to manage category page
}
else{
    //redirect to manage-category page
    header("location:" .SITEURL. 'backend/manage-category.php');
}

?>