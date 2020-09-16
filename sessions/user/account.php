<?php
    ob_start();
    session_start();

    include "../../services/main.php";
    include "../../services/database_connection.php";

    userCheck();

    // get the user
    $sql = "select `name` from `user` where `id` = {$_SESSION['user']}";
    $result = $connection->query($sql);
    $userName = $result->fetch_assoc()["name"];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <?php include "../../view/head.php"; ?>
</head>
<body class="d-flex flex-column justify-content-between min-vh-100">
    <div>
        <?php include "../../view/navbar.php"; ?>
        <main>
            <div class="container my-5">
                <h3 class="mb-5 mb-md-4 text-center myH3"><?php echo $userName; ?></h3>
                <h3 class="mb-5 mb-md-4 myH3">Account</h3>
                <a href="actions/change_password.php" class="btn btn-info mb-4 mb-md-3 myP">Change Password</a>
                <h5 class="mb-4 mb-md-3 myH5">Danger Zone:</h5>
                <a href="actions/delete_account.php" class="btn btn-secondary mb-4 mb-md-3 myP">Delete Account</a>
                <hr class="mb-5 mb-md-4">
                <h3 class="mb-5 mb-md-4 myH3">Billing Details</h3>
<?php  

    // show the billing details if they have already been set
    $sql = "select * from `billing_details` 
    where `fk_user` = {$_SESSION['user']}";
    $result = $connection->query($sql);
    $connection->close();

    if ($result->num_rows > 0) {
        while ($option = $result->fetch_assoc()) {
            $checked = "";
            
            if ($option["by_default"] == 1) {
                $checked = "checked";
            }
?>
                <div>
                    <div>
                        <input type="radio" name="default" value="<?php echo $option['id']; ?>" <?php echo $checked; ?>>
                        <h5 class="d-inline mb-5 mb-md-4 text-info myH5">Use by Default</h5>
                    </div>
                    <h5 class="mt-4 mt-md-3 myH5">First Name</h5>
                    <p class="myP"><?php echo $option["first_name"]; ?></p>
                    <h5 class="mt-4 mt-md-3 myH5">Last Name</h5>
                    <p class="myP"><?php echo $option["last_name"]; ?></p>
                    <h5 class="mt-4 mt-md-3 myH5">Address</h5>
                    <p class="myP"><?php echo $option["address"]; ?></p>
                    <h5 class="mt-4 mt-md-3 myH5">Phone Number</h5>
                    <p class="myP"><?php echo $option["phone_number"]; ?></p>
                    <a href="actions/update_billing_details.php?update&id=<?php echo $option['id']; ?>" class="btn btn-info mb-3 myP">Update Billing Details</a>
                </div>
<?php  
        }
?>
                <a href="actions/update_billing_details.php?add" class="mt-4 mt-md-3 btn btn-info myP">Add Option</a>
<?php  
    } else {
?>
                <h5 class="mb-4 mb-md-3 myH5">There are no billing details set yet.</h5>
                <a href="actions/update_billing_details.php?create" class="btn btn-info myP">Create entry</a>
<?php  
    }
?>
            </div>
        </main>
    </div>
    <?php include "../../view/footer.php"; ?>

    <?php echo $scripts; ?>
    <script src="../../ajax/account.js"></script>
    <script src="../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>