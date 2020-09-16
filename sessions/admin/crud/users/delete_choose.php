<?php
    ob_start();
    session_start();

    include "../../../../services/main.php";
    include "../../../../services/database_connection.php";

    adminCheck();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <?php include "../../../../view/head.php"; ?>
</head>
<body class="d-flex flex-column justify-content-between min-vh-100">
    <div>
        <?php include "../../../../view/navbar.php"; ?>
        <main class="container my-5">
<?php
    // get the user to delete
    $sql = "select * from `user`";
    $result = $connection->query($sql);
    $connection->close();
    $users = $result->fetch_all(MYSQLI_ASSOC);

    if (empty($users)) {
?>
            <h5 class="myH5">There are no users.</h5>
<?php
    } else {
?>
            <h3 class="text-center mb-5 mb-md-4 myH3">User List</h3>
            <div class="row">
                <div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 p-0 rounded border border-secondary">
<?php
    for ($i = 0; $i < count($users); $i++) {
        $class = "";

        if ($i == 0) {
            $class .= "firstCell ";
        }

        if ($i == count($users) - 1) {
            $class .= "lastCell";
        }
        
        echo '
                    <div class="d-flex justify-content-between p-3 border border-secondary ' . $class . '">
                        <p class="myP">' . $users[$i]["name"] . '</p>
                        <a href="delete_confirm.php?id=' . $users[$i]["id"] . '" class="btn btn-danger myP">Delete</a>
                    </div>
        ';
    }
?>
                </div>
            </div>
<?php  
    }
?>
        </main>
    </div>
    <?php include "../../../../view/footer.php"; ?>
  
    <?php echo $scripts; ?>
    <script src="../../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>