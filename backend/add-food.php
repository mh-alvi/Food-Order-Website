<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php
            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload']; // display session message
                unset($_SESSION['upload']); // removing session message
            }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php 
                                //Create php code to display categories from database
                                //1. Create sql for displaying active categories
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                //executing query
                                $res = mysqli_query($conn, $sql);
                                //count rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);
                                if($count>0){
                                    //we have categories
                                    while($rows = mysqli_fetch_assoc($res)){
                                        //get the details of category
                                        $id = $rows['id'];
                                        $title = $rows['title'];
                                        ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php
                                    }
                                }
                                else{
                                    //display no category
                                    ?> <option value="0">No Category Found!!</option> <?php
                                }
                                //2. display on dropdown

                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

        <?php

            //check whether the button is clicked or not
            if(isset($_POST['submit'])){
                //1. Get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price =  $_POST['price'];
                $category = $_POST['category'];

                //check whether radio button of featured and active are checked or not
                if(isset($_POST['featured'])){
                    $featured = $_POST['featured'];
                }
                else{
                    $featured = "No"; //setting the default value
                }
                if(isset($_POST['active'])){
                    $active = $_POST['active']; //setting the default value
                }
                else{
                    $featured = "No";
                }

                //2. Upload the image if selected
                //check whether the select image is clicked or not and upload the image only if the image is selected
                if(isset($_FILES['image']['name'])){
                    //Get details of selected image
                    $image_name = $_FILES['image']['name'];
                    //check whether the image is selected or not if selected then upload the image
                    if($image_name != ""){
                        //image is selected
                        //A. remane the image
                        //get extension for selected image(jpg, png etc)
                        $ext = end(explode('.', $image_name));

                        //create new name for image
                        $image_name = "Food-Name-". rand(0000,9999).".".$ext;

                        //B. be upload the image
                        //get the source path and destination path
                        $src = $_FILES['image']['tmp_name'];

                        //destination path
                        $dst = "../images/food-image/". $image_name;

                        //finally upload the full image
                        $upload = move_uploaded_file($src, $dst);

                        //check whether the image uploaded or not
                        if($upload == false){
                            //failed to upload the image

                            //redirect to add food page with a error message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image<?div>";
                            header("location:" .SITEURL. 'backend/add-food.php');
                            //stop the process
                            die();

                        }
                    }
                    else{

                    }
                }
                else{
                    $image_name = ""; //setting the default as blank
                }

                //3. Insert into database
                //create a sql query
                //for numerical value to pass we do not need to add qoutes
                $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
                ";

                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //check whether the data inserted or not

                //4.redirect with message to manage food page
                if($res2 == true){
                    //data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
                    header("location:" .SITEURL. 'backend/manage-food.php');
                }
                else{
                    //Failed to insert the data
                    $_SESSION['add'] = "<div class='error'>Failed to Add Food!!</div>";
                    header("location:" .SITEURL. 'backend/manage-food.php');
                }
                 
            }

        ?>

    </div>
</div>

<?php include('partials/footer.php') ?>