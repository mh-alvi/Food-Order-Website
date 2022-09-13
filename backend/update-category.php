<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php
        
        //Check whether the id is set or not
        if(isset($_GET['id'])){
            //Get the id and all other details
            $id = $_GET['id'];
            //sql query to get the selected food
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            //execute the query
            $res = mysqli_query($conn, $sql);

            //get the value based on query executed
            $row = mysqli_fetch_assoc($res);

            //get the individual values from selected food
            $title = $row['title'];
            $current_image = $row['image_name'];
            $featured = $row['featured'];
            $active = $row['active'];
        }
        else{
            //redirect to manage-category page
            $_SESSION['no-category-found']= "<div class='error'>Category Not Found</div>";
            header("location:" .SITEURL. 'backend/manage-category.php');
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image != ""){
                                //display the image
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/category-image/<?php echo $current_image; ?>" width="100px">
                                <?php
                            }
                            else{
                                //display message
                                echo "<div class='error'>Image Not Added</div>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
            
        </form>

        <?php
        
            if(isset($_POST['submit'])){
                //1. Get all the value from our form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. Updating new image if selected
                if(isset($_FILES['image']['name'])){
                    //upload button clicked
                    $image_name = $_FILES['image']['name']; //new image name

                    //check whether the file is available or not
                    if($image_name != ""){
                        //image is available
                        //A. upload the new image

                        //Auto rename our image
                        //Get the extension of our image (jpg, png, gif)etc. ex. food.jpg
                        $ext = end(explode('.', $image_name));

                        //create new name for image
                        $image_name = "Food_Category_". rand(0000,9999).".".$ext; //ex. Food_Category_677.jpg

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category-image/".$image_name;

                        //upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check whether the image is uploaded or not
                        //And if the image is not uploaded then we will stop the process and redireect with an error message
                        if($upload == false){
                            //set message
                            $_SESSION['upload']= "<div class='error'>Failed to Upload Image</div>";
                            header("location:" .SITEURL. 'backend/manage-category.php');
                            //stop the process
                            die();
                        }

                        //B. remove the current image
                        if($current_image != ""){
                            $remove_path = "../images/category-image/".$current_image;

                            $remove = unlink($remove_path);

                            if($remove == false){
                                //failed to remove image
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image</div>";
                                header("location:" .SITEURL. 'backend/manage-catagory.php');
                                die();
                            }
                        }
                    }
                    else{
                        $image_name = $current_image;
                    }
                }
                else{
                    $image_name = $current_image;
                }

                //3. Update the database
                $sql2 = "UPDATE tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                WHERE id=$id";

                //execute the sql query
                $res2 = mysqli_query($conn, $sql2);
                
                //4. Redirect to manage-category page with message
                //check whether the query is executed or not
                if($res2 == true){
                    //query executed and food updated
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully!</div>";
                    header("location:" .SITEURL. 'backend/manage-category.php');
                }
                else{
                    //failed to update
                    $_SESSION['update'] = "<div class='error'>Failed to Update Category!</div>";
                    header("loaction:" .SITEURL. 'backend/manage-category.php');
                }


            }
        
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>