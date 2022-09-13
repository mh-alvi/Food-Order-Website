<?php
    //include constants page
    include('../config/constants.php');

    //check whether the value is passed or not

    if(isset($_GET['id']) AND isset($_GET['image_name'])){

        //process for delete
        //1. Get id and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2. Remove the image if available
        //check whether the image is available or not and delete if only available
        if($image_name != ""){
            //found the image and delete it
            //Get the image path
            $path = "../images/food-image/".$image_name;

            //remove image file from folder
            $remove = unlink($path);

            //check whether the image removed or not
            if($remove == false){
                //failed to remove image
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image!!</div>";
                //redirect to manage admin page
                header("location:" .SITEURL. 'backend/manage-food.php');
                die(); //stop the process
            }
        }
        
        //3. Delete the food from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //Check whether the query is executed or not set the session message respectively
        //4. redirect to manage food with message
        if($res == true){
            //food deleted
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
            header("location:" .SITEURL. 'backend/manage-food.php');
        }
        else{
            //failed to delete food
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Food</div>";
            header("location:" .SITEURL. 'backend/manage-food.php');

        }
    }

    else{

        //redirect to manage admin page
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Session!!</div>";
        header("location:" .SITEURL. 'backend/manage-food.php');
    }

?>