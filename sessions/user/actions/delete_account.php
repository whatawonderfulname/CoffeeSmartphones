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
                <h5 class="mb-4 mb-md-3 myH5">Do you really want to delete your account permanently?</h5>
                <a href="delete_account_confirm.php" class="btn btn-danger mr-3 mr-md-2 myP">Yes, Delete It!</a>
                <a href="../account.php" class="btn btn-secondary myP">No, Go Back!</a>
            </div>
        </main>
    </div>
    <?php include "../../../view/footer.php"; ?>

    <?php echo $scripts; ?>
    <script src="../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>