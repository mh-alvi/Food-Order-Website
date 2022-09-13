<?php include('partials/menu.php') ?>

<!-- Main content section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Admin management</h1>
        <br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; // display session message
            unset($_SESSION['add']); // removing session message
        }
        if (isset($_SESSION['delete'])){
            echo $_SESSION['delete']; //display session message
            unset($_SESSION['delete']); //removing session message
        }
        if(isset($_SESSION['update'])){
            echo $_SESSION['update']; //display session message
            unset($_SESSION['update']); //removing session message
        }
        if(isset($_SESSION['user-not-found'])){
            echo $_SESSION['user-not-found']; //display session message
            unset($_SESSION['user-not-found']); //removing session message
        }
        if(isset($_SESSION['pass-not-matched'])){
            echo $_SESSION['pass-not-matched']; //display session message
            unset($_SESSION['pass-not-matched']); //removing session message
        }
        if(isset($_SESSION['change-pass'])){
            echo $_SESSION['change-pass']; //display session message
            unset($_SESSION['change-pass']); //removing session message
        }
        ?>
        <br><br><br>

        <!-- add button -->

        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br /><br /><br />

        <table class="tbl-full">
            <tr>
                <th>S.No.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
            // Query to get all admin
            $sql = 'SELECT * FROM tbl_admin';
            // Execute the query
            $res = mysqli_query($conn, $sql);
            // check the query whether it is executed or not
            if ($res == true) {
                $count = mysqli_num_rows($res); // function to get all the rows in database

                $sn = 1; //create a variable for maintain the serial of id

                if ($count > 0) {
                    // we have the data in database
                    while ($rows = mysqli_fetch_assoc($res)) {
                        // using while loop to get all data from database
                        // and while loop will run as long as we have data in database
                        // Get individual data
                        $id = $rows['id'];
                        $full_name = $rows['full_name'];
                        $username = $rows['username'];

                        // display the value in table
            ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>backend/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo SITEURL; ?>backend/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo SITEURL; ?>backend/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>

            <?php
                    }
                } else {
                    // we do not have data in database
                }
            }

            ?>
        </table>

    </div>
</div>
<!-- Main content section end -->


<?php include('partials/footer.php') ?>