<?php include('partials/menu.php') ?>

<!-- Main content section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>
        <br /><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; // display session message
            unset($_SESSION['add']); // removing session message
        }
        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove']; // display session message
            unset($_SESSION['remove']); // removing session message
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete']; // display session message
            unset($_SESSION['delete']); // removing session message
        }
        if (isset($_SESSION['no-category-found'])) {
            echo $_SESSION['no-category-found']; // display session message
            unset($_SESSION['no-category-found']); // removing session message
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update']; // display session message
            unset($_SESSION['update']); // removing session message
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload']; // display session message
            unset($_SESSION['upload']); // removing session message
        }
        if (isset($_SESSION['failed-remove'])) {
            echo $_SESSION['failed-remove']; // display session message
            unset($_SESSION['failed-remove']); // removing session message
        }
        ?>
        <br><br>

        <!-- button for add admin -->
        <a href="<?php echo SITEURL; ?>backend/add-category.php"class="btn-primary">Add Category</a>

        <br> <br> <br>


        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
            <?php
            //create sql query to get all the data from database
            $sql = "SELECT * FROM tbl_category";
            
            //esecute the query
            $res = mysqli_query($conn, $sql);

            //count rows
            $count = mysqli_num_rows($res);

            //create serial number value
            $sn = 1;

            //check whether we have data in our database or not
            if($count > 0){
                //we have data in our databae
                //Get the data and display it
                while($row=mysqli_fetch_assoc($res)){
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

                    ?>

                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>

                        <td>

                            <?php
                                //check whether the image is available or not
                                if($image_name !=""){
                                    //display the image
                                    ?>
                                        <img src="<?php echo SITEURL; ?>images/category-image/<?php echo $image_name; ?>" width="100px">
                                    <?php
                                }
                                else{
                                    //display the message
                                    echo "<div class='error'>Image Not Added</div>";
                                }
                            ?>
                        </td>

                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td> 
                        <td>
                            <a href="<?php echo SITEURL; ?>backend/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                            <a href="<?php echo SITEURL; ?>backend/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                        </td>
                    </tr>

                    <?php
                }
            }
            else{
                //we don't have any data
                //we'll display the message inside the table
                ?>
                <tr>
                    <td colspan="6">
                        <div class="error">No Category Added</div>
                    </td>
                </tr>
                <?php
            }
            ?>

        </table>

    </div>
</div>
<!-- Main content section end -->


<?php include('partials/footer.php') ?>