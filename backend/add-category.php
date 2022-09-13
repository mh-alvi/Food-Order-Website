<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; // display session message
            unset($_SESSION['add']); // removing session message
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload']; // display session message
            unset($_SESSION['upload']); // removing session message
        }
        ?>

        <br><br>

        <!-- add category form starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title: </td>

                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>

                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>

                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- add category form ends -->

        <?php
        
            //check whether the submit button is clicked or not
            if(isset($_POST['submit'])){
                //1. Get the value from category form
                $title = $_POST['title'];

                //for radio input we need to check whether the button is clicked or not
                if(isset($_POST['featured'])){
                    //Get the value from form
                    $featured = $_POST['featured'];
                }
                else{
                    $featured = "No";
                }
                if(isset($_POST['active'])){
                    //Get the value from form
                    $active = $_POST['active'];
                }
                else{
                    $active = "No";
                }

                //check whether the image is selected or not and set the value for image name accordingly
                if(isset($_FILES['image']['name'])){
                    //upload the image
                    $image_name = $_FILES['image']['name'];

                    //upload the image only if image is selected
                    if($image_name != ""){
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
                            header("location:" .SITEURL. 'backend/add-category.php');
                            //stop the process
                            die();
                        }
                    }
                    
                }
                else{
                    //don't upload image and set the image_name value as black
                    $image_name = "";
                }

                //2. Create sql query to insert category into database
                $sql = "INSERT INTO tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                ";

                //execute the query and save it in database
                $res = mysqli_query($conn, $sql);

                //4. check whether the qeury execute or not and data added or not
                if($res == true){
                    //query executed and category added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully!!</div>";
                    //redirect  to manage category
                    header("location:" .SITEURL. 'backend/manage-category.php');
                }
                else{
                    //failed to add category
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category!!</div>";
                    //redirect  to manage category
                    header("location:" .SITEURL. 'backend/manage-category.php');
                }
            }
            else{

            }
        
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>