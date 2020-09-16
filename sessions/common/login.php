<?php
    ob_start();
    session_start();

    include "../../services/main.php";
    include "../../services/database_connection.php";
    include "../../services/handle_products.php";

    if (isset($_SESSION["user"]) || isset($_SESSION["admin"])) {
        goToIndex();
    }

    $error = false;

    // check the provided data and log in
    if ($_POST) {
        $email = sanitize($_POST["email"]);
        $password = sanitize($_POST["password"]);

        // check if the input is valid
        if (empty($email)) {
            $error = true;
            $emailError = "Please enter your email address.";
        } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = true;
            $emailError = "Please enter a valid email address.";
        }

        if (empty($password)) {
            $error = true;
            $passwordError = "Please enter your password.";
        }

        function scrollToForm() {
            $scripts .= "
                <script>
                    location.href = '#loginForm';
                </script>
            ";
        }

        // let the user correct the input if neccessary
        if ($error) {
            scrollToForm();
        } 

        // check the input for correspondense with the database
        else {
            $sql = "select * from `user` where `email` = '{$email}'";
            $result = $connection->query($sql);

            function check_credentials($result, $password) {
                global $errorMessage;

                // count accounts that match the given email adress
                switch ($result->num_rows) {
                    case 0:
                        $errorMessage = "Incorrect email adress.";
                        break;
                    case 1:
                        $account = $result->fetch_assoc();

                        // check the password
                        if (password_verify($password, $account["password"])) {
                            set_session($account);
                        } else {
                            $errorMessage = "Incorrect password.";
                        }

                        break;
                    case 2: // (admin and user)
                        $match = false;

                        while ($account = $result->fetch_assoc()) {

                            // check the password
                            if (password_verify($password, $account["password"])) {
                                $match = true;
                                set_session($account);
                            }
                        }

                        if (! $match) {
                            $errorMessage = "Incorrect password.";
                        }

                        break;
                }
            }

            // set the user session
            function set_session($array) {
                global $connection;
                global $products;
                global $errorMessage;

                // regenerate the session id for security
                // session_regenerate_id();
                if ($array["role"] == "user") {
                    if ($array["status"] == true) {
                        $_SESSION["user"] = $array["id"];
                        $_SESSION["products"] = [];
                        $_SESSION["total_items"] = 0;

                        // // check if the users cart was stored in the database
                        $sql = "select * from `cart` where `fk_user` = {$_SESSION['user']}";
                        $result = $connection->query($sql);
                        $cart = $result->fetch_all(MYSQLI_ASSOC);

                        if (! empty($cart)) {
                            foreach ($cart as $entry) {
                                foreach ($products as $product) {
                                    foreach (["smartphone", "cover", "header", "charger"] as $category) {
                                        if ($product["category"] == $category) {
                                            if ($product["id"] == $entry["fk_" . $category]) {
                                                $product["amount_requested"] = $entry["amount"];
                                                array_push($_SESSION["products"], $product);
                                                $_SESSION["total_items"] += $entry["amount"];
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        header("Location: ../../index.php");
                    } else {
                        $errorMessage = "You've been banned!";
                    }
                } else {
                    $_SESSION["admin"] = $array["id"];
                    header("Location: ../admin/dashboard.php");
                }
            }

            check_credentials($result, $password);

            if (isset($errorMessage)) {
                scrollToForm();
            }
        }
    }
    $connection->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <?php include "../../view/head.php"; ?>
</head>
<body>
    <?php include "../../view/navbar.php"; ?>
    <main>
        <div class="container mb-5">

            <!-- hero -->
            <div class="jumbotron my-5">
                <h1 class="mb-5 mb-md-4">Live to spend!</h1>
                <p class="lead mb-5 mb-md-4 myP"><i>Please sign up to take part in this exlusive shopping experience!</i></p>
                <a class="btn btn-lg btn-dark mb-4 mb-md-3 myP" href="sign_up.php">Sign Up!</a>
            </div>
            
            <!-- login -->
            <h3 class="myH3">Log In</h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="loginForm" autocomplete="off">
                <div class="row">
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <label for="email" class="my-3 my-md-2 myP">Email Adress</label>
<?php 
    if (isset($emailError)) {
        echo '
                        <div class="text-danger myP">' . $emailError . '</div>
        ';
    } 
?>
                        <input type="email" name="email" class="form-control mb-2 myP" id="email" 
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
                        <input type="password" name="password" id="password" class="form-control mb-2 myP">
                        <button type="submit" class="btn btn-md mt-4 mt-md-3 btn-dark myP">Log In</button>
                    </div>
                </div>
            </form>
<?php 
    if (isset($errorMessage)) {
        echo '
            <div class="mt-2 text-danger myP">' . $errorMessage . '</div>
        ';
    } 
?>
        </div>
    </main>
    <?php include "../../view/footer.php"; ?>

    <?php echo $scripts; ?>
    <script src="../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>