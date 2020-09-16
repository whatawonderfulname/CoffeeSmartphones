<?php 
	ob_start();
	session_start();

	include "../../services/main.php";
	include "../../services/database_connection.php";
	include "../../services/handle_products.php";

	userCheck();

	$scripts .= "
		<script>
			let products = " . json_encode($_SESSION["products"]) . ";
		</script>
	";
	$firstName = "";
	$lastName = "";
	$address = "";
	$phoneNumber = "";

	// get the billing details if they have been already set
	$sql = "select * from `billing_details` 
	where `fk_user` = {$_SESSION['user']}
	and `by_default` = 1";
	$result = $connection->query($sql);
    $connection->close();

	if ($result->num_rows === 1) {
		$billingDetails = $result->fetch_assoc();
		$firstName = $billingDetails["first_name"];
		$lastName = $billingDetails["last_name"];
		$address = $billingDetails["address"];
		$phoneNumber = $billingDetails["phone_number"];
		$_SESSION["billing_details_id"] = $billingDetails["id"];
	}
	
	$scripts .= "
		<script>
			let firstName = 'value = " . json_encode($firstName) . "';
			let lastName = 'value = " . json_encode($lastName) . "';
			let address = 'value = " . json_encode($address) . "';
			let phoneNumber = 'value = " . json_encode($phoneNumber) . "';
		</script>
	";
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
				<h3 class="mb-5 mb-md-4 text-center myH3">Cart</h3>
				<div id="cart" class="mb-5"></div>
				<div id="billingDetails"></div>
			</div>
		</main>
	</div>
	<?php include "../../view/footer.php"; ?>

	<?php echo $scripts; ?>
	<script src="../../js/main.js"></script>
	<script src="../../js/cart.js"></script>
	<script src="../../ajax/cart.js"></script>
	<script src="../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>