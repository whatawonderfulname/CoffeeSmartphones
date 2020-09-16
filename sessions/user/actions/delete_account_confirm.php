<?php
    ob_start();
    session_start();

    include "../../../services/main.php";
    include "../../../services/database_connection.php";

    userCheck();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <?php include "../../../view/head.php"; ?>
</head>
<body class="d-flex flex-column justify-content-between min-vh-100">
    <div>
        <?php include "../../../view/navbar.php"; ?>
        <main>
            <div class="container my-5">
<?php  
    // delete a database entry
    $sql = "delete from `user` where `id` = {$_SESSION['user']}";
    if ($connection->query($sql)) {

        // unset session variables
        session_unset();

        // destroy session data
        session_destroy();
?>
                <h5 class="mb-4 mb-md-3 myH5">You've deleted your account successfully!</h5>
                <a href="../../../index.php" class="btn btn-dark myP">Okay</a>
<?php
    } else {
?>
                <h5 class="mb-4 mb-md-3 myH5">Something went wrong, try again later...</h5>
                <a href="../account.php" class="btn btn-dark myP">Back</a>
<?php  
    }
    
    $connection->close();
?>
            </div>
        </main>
    </div>
    <?php include "../../../view/footer.php"; ?>

    <?php echo $scripts; ?>
    <script src="../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>
