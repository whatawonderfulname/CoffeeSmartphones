<?php
    ob_start();
    session_start();

    include "../../../services/main.php";
    include "../../../services/database_connection.php";

    userCheck();

    $error = false;

    $sql = "select `password` from `user` where `id` = {$_SESSION['user']}";
    $result = $connection->query($sql);
    $oldPassword = $result->fetch_assoc()["password"];

    // update the database
    if ($_POST) {

        // sanitize the input to prevent sql injection
        $password = sanitize($_POST["password"]);

        // check if the input is valid
        if (empty($password)) {
            $error = true;
            $passwordError = "Please enter a password.";
        } elseif (strlen($password) < 6) {
            $error = true;
            $passwordError = "The password must be at least 6 characters long.";
        } elseif (password_verify($password, $oldPassword)) {
            $error = true;
            $passwordError = "This password is already in use. Please enter a new password.";
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        // create a database entry
        if (! $error) {
            $sql = "update `user` set `password` = '{$password}' 
            where `id` = {$_SESSION['user']}";

            if ($connection->query($sql)) {
                $message = "Changed password successfully.";
                $messageColor = "success";
                unset($password);
            } else {
                $message = "Something went wrong, try again later...";
                $messageColor = "danger";
            }
        }
    }
    
    $connection->close();
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
                <h3 class="mb-5 mb-md-4 text-center myH3">Change Password</h3>
<?php 
    if (isset($message)) {
        echo '
                <div class="alert alert-' . $messageColor . ' myP">' . $message . '</div>
        ';
    }
?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="row">
                        <div class="col-sm-8 col-md-6 col-lg-4">
                            <label for="password" class="mb-3 mb-md-2 myP">New Password</label>
<?php 
    if (isset($passwordError)) {
        echo '
                            <div class="text-danger myP">' . $passwordError . '</div>
        ';
    }
?>
                            <input type="password" name="password" id="password" class="form-control mb-2 myP" placeholder="At least 6 characters"  maxlength="20">
                            <button type="submit" class="btn btn-md mt-4 mt-md-3 btn-success myP">Submit</button>
                        </div>
                    </div>
                    <a href="../account.php" class="btn btn-md mt-4 mt-md-3 btn-dark myP">Back</a>
                </form>
            </div>
        </main>
    </div>
    <?php include "../../../view/footer.php"; ?>

    <?php echo $scripts; ?>
    <script src="../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>