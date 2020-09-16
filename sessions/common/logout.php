<?php 
    session_start();

    include "../../services/main.php";
    include "../../services/database_connection.php";

    if (! isset($_SESSION["user"]) && ! isset($_SESSION["admin"])) {
        goToIndex();
    }

    if (isset($_SESSION["user"])) {

        // save the cart in the database, so the user may continue shopping when logged in again
        $sql = "delete from `cart` where `fk_user` = {$_SESSION['user']}";
        $connection->query($sql);

        if (! empty($_SESSION["products"])) {
            foreach ($_SESSION["products"] as $product) {
                $sql = "insert into `cart` 
                (`fk_user`, `fk_{$product['category']}`, `amount`) 
                values 
                ({$_SESSION['user']}, {$product['id']}, {$product['amount_requested']})";
                $connection->query($sql);
            }
        }
    }

    $connection->close();
    
    // unset session variables
    session_unset();
    
    // destroy session data
    session_destroy();
    header("Location: ../../index.php");
?>