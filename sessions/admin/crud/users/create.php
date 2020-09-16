<?php
    ob_start();
    session_start();

    include "../../../../services/main.php";
    include "../../../../services/database_connection.php";

    adminCheck();

    $error = false;

    // add a user to the database
    if ($_POST) {
        $name = sanitize($_POST["name"]);
        $email = sanitize($_POST["email"]);
        $password = sanitize($_POST["password"]);

        // check if the input is valid
        if (empty($name)) {
            $error = true;
            $nameError = "Please enter your full name.";
        } elseif (strlen($name) < 3) {
            $error = true;
            $nameError = "Name must have at least 3 characters.";
        }

        if (empty($email)) {
            $error = true;
            $emailError = "Please enter your email adress.";
        } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = true;
            $emailError = "Please enter a valid email address.";
        } else {
            $sql = "select `email` from `user` where `email` = '$email'";
            $result = $connection->query($sql);

            if ($result->num_rows != 0) {
                $error = true;
                $emailError = "Provided email is already in use.";
            }
        }

        if (empty($password)) {
            $error = true;
            $passwordError = "Please enter a password.";
        } elseif (strlen($password) < 6) {
            $error = true;
            $passwordError = "Password must be at least 6 characters long";
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        // create a database entry
        if (! $error) {
            $sql = "insert into `user` (`name`, `email`, `password`) values ('{$name}', '{$email}', '{$password}')";
            
            if ($connection->query($sql)) {
                $message = "Created user successfully.";
                $messageColor = "success";
                unset($name);
                unset($email);
                unset($password);
            } else {
                $message = "Something went wrong, try again later...";
                $messageColor = "danger";
            }
        }
            
        $connection->close();
    }
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <?php include "../../../../view/head.php"; ?>
</head>
<body class="d-flex flex-column justify-content-between min-vh-100">
    <?php include "../../../../view/navbar.php"; ?>
    <main>
        <div class="container my-5">
            <h3 class="mb-5 mb-md-4 myH3">Create User</h3>
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
                        <label for="name" class="my-3 my-md-2 myP">Name</label>
<?php 
    if (isset($nameError)) {
        echo '
                        <div class="text-danger myP">' . $nameError . '</div>
        ';
    }
?>
                        <input type="text" name="name" id="name" class="form-control mb-2 myP" maxlength="50" 
<?php 
    if (isset($name)) {
        echo '
                        value="' . $name . '"
        ';
    }
?>
                        >
                        <label for="email" class="my-3 my-md-2 myP">Email</label>
<?php 
    if (isset($emailError)) {
        echo '
                        <div class="text-danger myP">' . $emailError . '</div>
        ';
    }
?>
                        <input type="email" name="email" id="email" class="form-control mb-2 myP" maxlength="60" 
<?php 
    if (isset($email)) {
        echo '
                        value="' . $email . '"
        ';
    }
?>
                        >
                        <label for="password" class="my-3 my-md-2 myP">Password</label>
<?php 
    if (isset($passwordError)) {
        echo '
                        <div class="text-danger myP">' . $passwordError . '</div>
        ';
    }
?>
                        <input type="password" name="password" id="password" class="form-control mb-2 myP" placeholder="At least 6 characters"  maxlength="20">
                        <button type="submit" class="btn btn-md mt-4 mt-md-3 btn-success myP">Create</button>
                    </div>
                </div>
                <a href="../../dashboard.php" class="btn btn-md mt-4 mt-md-3 btn-dark myP">Back</a>
            </form>
        </div>
    </main>
    <?php include "../../../../view/footer.php"; ?>
  
    <?php echo $scripts; ?>
    <script src="../../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>