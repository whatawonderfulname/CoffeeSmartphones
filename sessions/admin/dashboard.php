<?php
    ob_start();
    session_start();

    include "../../services/main.php";

    adminCheck();
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
            <div class="container my-5 text-center">
                <h3 class="mb-5 mb-md-4 myH3">User Configuration</h3>
                <div class="row mb-5 table4general table4">
                    <div class="col-md-6 col-lg-3 p-3 table4general table4cell1">
                        <a href="crud/users/create.php" class="btn btn-dark myP">Create</a>
                    </div>
                    <div class="col-md-6 col-lg-3 p-3 table4general table4cell2">
                        <a href="crud/users/delete_choose.php" class="btn btn-dark myP">Delete</a>
                    </div>
                    <div class="col-md-6 col-lg-3 p-3 table4general table4cell3">
                        <a href="crud/users/ban_unban_choose.php?ban" class="btn btn-dark myP">Ban</a>
                    </div>
                    <div class="col-md-6 col-lg-3 p-3 table4general table4cell4">
                        <a href="crud/users/ban_unban_choose.php?unban" class="btn btn-dark myP">Unban</a>
                    </div>
                </div>
                <h3 class="mb-5 mb-md-4 myH3">Product Configuration</h3>
                <div class="row mb-5">
                    <div class="col-lg-8 row m-0 p-0 table3cell1">
                        <div class="col-md-6 p-3 table3subcell1">
                            <a href="crud/products/create.php" class="btn btn-dark myP">Create</a>
                        </div>
                        <div class="col-md-6 p-3 table3subcell2">
                            <a href="crud/products/delete_choose.php" class="btn btn-dark myP">Delete</a>
                        </div>
                    </div>
                    <div class="col-md-6 offset-md-3 col-lg-4 offset-lg-0 p-0 table3cell2">
                        <div class="p-3 table3subcell3">
                            <a href="crud/products/update_choose.php" class="btn btn-dark myP">Update</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php include "../../view/footer.php"; ?>

    <?php echo $scripts; ?>
    <script src="../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>