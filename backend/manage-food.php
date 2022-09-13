<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br /><br /><br>

        <!-- add button -->
        <a href="<?php echo SITEURL; ?>backend/add-food.php" class="btn-primary">Add Food</a>
        <br /><br /><br />

        <?php 
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add']; // display session message
                unset($_SESSION['add']); // removing session message
            }
            if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete']; // display session message
                unset($_SESSION['delete']); // removing session message
            }
            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload']; // display session message
                unset($_SESSION['upload']); // removing session message
            }
            if (isset($_SESSION['unauthorized'])) {
                echo $_SESSION['unauthorized']; // display session message
                unset($_SESSION['unauthorized']); // removing session message
            }
            if (isset($_SESSION['update'])) {
                echo $_SESSION['update']; // display session message
                unset($_SESSION['update']); // removing session message
            }
        ?>

        <table class="tbl-full">
            <tr>
                <th>S.No.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>

            <?php
                //create sql query to get all the food
                $sql = "SELECT * FROM tbl_food";

                //execute the query
                $res = mysqli_query($conn, $sql);

                //count the rows
                $count = mysqli_num_rows($res);

                //create number variables set the default value as 1
                $sn = 1;

                if($count>0){
                    //we have food in database
                    //get the from database and display
                    while($rows= mysqli_fetch_assoc($res)){
                        //get value for individual column
                        $id = $rows['id'];
                        $title = $rows['title'];
                        $image_name = $rows['image_name'];
                        $featured = $rows['featured'];
                        $active = $rows['active'];
                        $price = $rows['price'];

                        ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $title; ?></td>
                                <td>
                                    <?php 
                                        //Check whether we have image or not
                                        if($image_name == ""){
                                            //we do not have image, display the error message
                                            echo "<div class='error'>Image Not Found</div>";
                                        }
                                        else{
                                            //we have image, display image
                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/food-image/<?php echo $image_name; ?>" width="100px">
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>
                                <td><?php echo $price; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>backend/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                                    <a href="<?php echo SITEURL; ?>backend/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                                </td>
                            </tr>
                        <?php
                    }
                }
                else{
                    //Food not added in database
                    echo "<tr> <td colspan=7 class='error'>Food Not Added Yet!!</td> </tr>";
                }
            ?>

        </table>
    </div>
</div>

<?php include('partials/footer.php') ?>