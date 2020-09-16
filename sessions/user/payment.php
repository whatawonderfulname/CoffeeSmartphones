<?php 
	ob_start();
	session_start();

	include "../../services/main.php";
	include "../../services/database_connection.php";

	userCheck();

	// update the billing details after the form data is sent
	if ($_POST) {
		$firstName = sanitize($_POST["firstName"]);
		$lastName = sanitize($_POST["lastName"]);
		$address = sanitize($_POST["address"]);
		$phoneNumber = sanitize($_POST["phoneNumber"]);

		// store the billing details in the session variable
		if (isset($_SESSION["billing_details_id"])) {
			$sql = "update `billing_details` set 
			`first_name` = '{$firstName}', 
			`last_name` = '{$lastName}', 
			`address` = '{$address}', 
			`phone_number` = '{$phoneNumber}' 
			where `id` = {$_SESSION['billing_details_id']}";
			unset($_SESSION["billing_details_id"]);
		} else {
			$sql = "insert into `billing_details` 
			(`first_name`, `last_name`, `address`, `phone_number`, `fk_user`, `by_default`) 
			values 
			('{$firstName}', '{$lastName}', '{$address}', '{$phoneNumber}', {$_SESSION['user']}, 1) 
			";
		}
		
		$connection->query($sql);
		$connection->close();
	    $_SESSION["billing_details"] = [
			"first_name" => $firstName,
			"last_name" => $lastName,
			"address" => $address, 
			"phone_number" => $phoneNumber
		];
		$scripts .= "
			<script>
				let sum = " . json_encode($_POST["sum"]) . ";
			</script>
		";
	} else {
		goToIndex();
	}
?>

<!DOCTYPE html>
<html lang="de">
<head>
	<?php include "../../view/head.php"; ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>
<body class="d-flex flex-column justify-content-between min-vh-100">
	<div>
		<?php include "../../view/navbar.php"; ?>
		<main>
			<div class="container my-5">
				<h3 class="mb-5 mb-md-4 text-center myH3">Payment</h3>
				<h5 class="mb-5 mb-md-4 myH5">After the payment procedure, an 
					<a href="order_confirmation.php">order confirmation</a>
				 will follow.</h5>
				<div class="row mb-5">
					<div class="col-lg-6 offset-lg-3">
						<div id="paypalButtons"></div>
					</div>
				</div>
			</div>
		</main>
	</div>
	<?php include "../../view/footer.php"; ?>

	<?php echo $scripts; ?>
	<script src="https://www.paypal.com/sdk/js?client-id=ARNaj06TPkxbVG3Dnt4OYn45i2ruhVkFzc1X5L1drPDfr8CsJqGcyT6ItKpWKyCkD8loGYY4PnuFJtvC&currency=EUR"></script>
	<script src="../../js/payment.js"></script>
	<script src="../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>