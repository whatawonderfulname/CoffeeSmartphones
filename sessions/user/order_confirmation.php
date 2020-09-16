<?php 
    ob_start();
    session_start();
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    include "../../composer/vendor/autoload.php";
    include "../../services/main.php";
    include "../../services/database_connection.php";

    userCheck();

    // send a confirmation email to the customer and an order email to the deliverer
    $sql = "select `name`, `email` from `user` where `id` = {$_SESSION['user']}";
    $result = $connection->query($sql);
    $user = $result->fetch_assoc();
    $customerHtmlText = "
        <html>
            Hello {$user['name']},<br>
            <br>
            your order has been received.
            <h3>Order details:</h3>
    ";
    $customerPlainText = "Hello {$user["name"]}, your order has been received. ORDER DETAILS. ";    
    $delivererHtmlText = "
        <html>
            Hello deliverer John Doe,<br>
            <br>
            there is a package to deliver.
            <h3>Products:</h3>
    ";
    $delivererPlainText = "Hello deliverer John Doe, there is a package to deliver. PRODUCTS: ";
    $sum = 0;

    foreach ($_SESSION["products"] as $product) {
        $allOfType = $product["new_price"] * $product["amount_requested"];
        $sum += $allOfType;

        if ($product["amount_requested"] === 1) {
            $wordForm = "item";
        } else {
            $wordForm = "items";
        }

        $customerHtmlText .= "
            {$product['amount_requested']} {$wordForm} of {$product['name']}: 
            " . createCurrencyFormat($allOfType) . "<br>
        ";
        $customerPlainText .= "
            {$product['amount_requested']} {$wordForm} of {$product['name']}: 
            " . createCurrencyFormat($allOfType) . ". 
        ";
        $delivererHtmlText .= "
            {$product['amount_requested']} {$wordForm} of {$product['name']}<br>
        ";
        $delivererPlainText .= "{$product['amount_requested']} {$wordForm} of {$product['name']}. ";
    }

    $customerHtmlText .= "
            <br>
            The package will be sent to 
            {$_SESSION['billing_details']['first_name']} 
            {$_SESSION['billing_details']['last_name']}, 
            {$_SESSION['billing_details']['address']}. 
            Phone number 
            {$_SESSION['billing_details']['phone_number']}. 
            <h3>Sum: " . createCurrencyFormat($sum) . "</h3>
            Have a nice day!<br>
            <br>
            Kind regards,<br>
            Your Coffee Team
        </html>            
    ";
    $customerPlainText .= "The package will be sent to 
            {$_SESSION['billing_details']['first_name']} 
            {$_SESSION['billing_details']['last_name']}, 
            {$_SESSION['billing_details']['address']}. 
            Phone number 
            {$_SESSION['billing_details']['phone_number']}. 
            SUM: " . createCurrencyFormat($sum) . ". Have a nice day! Kind regards, your Coffee Team";
    $delivererHtmlText .= "
            <h3>Recipient:</h3>
            {$_SESSION['billing_details']['first_name']} 
            {$_SESSION['billing_details']['last_name']}, 
            {$_SESSION['billing_details']['address']}, 
            {$_SESSION['billing_details']['phone_number']}<br> 
            <br>
            Thank you. Have a nice day!<br>
            <br>
            Kind regards,<br>
            Your Coffee Team
        </html>
    ";
    $delivererPlainText .= "RECIPIENT: 
            {$_SESSION['billing_details']['first_name']} 
            {$_SESSION['billing_details']['last_name']}, 
            {$_SESSION['billing_details']['address']}, 
            {$_SESSION['billing_details']['phone_number']}. 
        Thank you. Have a nice day! Kind regards, your Coffee Team";
    sendEmail($user["email"], $user["name"], "Order confirmation", $customerHtmlText, $customerPlainText);
    sendEmail("alexander.schaedlich@gmail.com", "Alexander Schädlich", "Package Delivery", $delivererHtmlText, $delivererPlainText);
    unset($_SESSION["billing_details"]);

    // for each product bought, decrease the amount available by the amount requested; create a statistics entry
    foreach ($_SESSION["products"] as $product) {
        $newAmount = $product["amount_available"] - $product["amount_requested"];
        $sql = "update `{$product['category']}` 
        set `amount_available` = {$newAmount} 
        where `id` = {$product['id']}; 
        insert into `statistics` (`category`, `name`, `amount`, `price`) 
        values ('" . $product["category"] . "', 
        '" . $product["name"] . "', 
        " . $product["amount_requested"] . ", 
        " . $product["new_price"] . ")";
        $connection->multi_query($sql);
    }
    
    $connection->close();
    $_SESSION["products"] = [];
    $_SESSION["total_items"] = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <?php include "../../view/head.php"; ?>
</head>
<body class="d-flex flex-column justify-content-between min-vh-100">
    <div>
        <?php include "../../view/navbar.php"; ?>
        <main>
            <div class="container my-5">
                <h5 class="mb-5 mb-md-4 myH5">Thank you for your purchase. We'll send you an email with the details of your order.</h5>
                <a href="../../index.php" class="btn btn-dark myP">Back</a>
            </div>
        </main>
    </div>
    <?php include "../../view/footer.php"; ?>
        
    <?php echo $scripts; ?>
    <script src="../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>