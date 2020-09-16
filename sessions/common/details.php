<?php
	ob_start();
	session_start();

	include "../../services/main.php";
	include "../../services/database_connection.php";
	include "../../services/handle_products.php";
	include "../../services/handle_buttons.php";

	if 
	(count($_GET) !== 2 
	|| ! (isset($_GET["category"]) && isset($_GET["id"]))) 
	{
		goToIndex();
	}

	// get the current product
	$category = escape($_GET["category"]);
	$id = escape($_GET["id"]);
	for ($i = 0; $i < count($products); $i++) {
		if 
		($products[$i]["category"] == $category 
		&& $products[$i]["id"] == $id) 
		{
			$product = $products[$i];
			$scripts .= "
				<script>
					let product = " . json_encode($product) . ";
				</script>
			";
			break;
		}
	}
?>

<!DOCTYPE html>
<html lang="de">
<head>
	<?php include "../../view/head.php"; ?>
</head>
<body class="d-flex flex-column justify-content-between min-vh-100">
	<div>
		<?php include "../../view/navbar.php"; ?>
<?php  
	if (isset($product)) {
?>
		<main>
			<div class="container mb-5">

				<!-- product -->
				<section>
					<div class="row mx-0 my-5">

						<!-- image -->
						<div class="detailsImage col-md-5 col-lg-4 mx-auto">
							<img src="<?php echo $product['img']; ?>" alt="smartphone" class="fittingImage">
						</div>

						<!-- technical information -->
						<div class="col-md-7 col-lg-8 px-3">
							<h3 class="text-center text-md-left ml-3 myH3"><?php echo $product["name"]; ?></h3>
							<hr class="my-4 my-md-3">
<?php
	if ($category == "smartphone") {
?>
							<div class="px-3 pb-2">
								<h5 class="mb-3 mb-md-2 myH5">Brand</h5>
								<p class="mb-0 myP"><?php echo $product["brand"]; ?></p>
							</div>
							<hr class="mt-3 mb-4 mt-md-2 mb-md-3">
							<div class="px-3">
								<h5 class="mb-3 mb-md-2 myH5"><u>Processor</u>:</h5>
								<div class="row">
									<div class="col-6">
										<h5 class="mb-3 mb-md-2 myH5">Frequency</h5>
										<p class="mb-2 myP"><?php echo $product["processor_frequency"]; ?></p>
									</div>
									<div class="col-6">
										<h5 class="mb-3 mb-md-2 myH5">Type</h5>
										<p class="mb-2 myP"><?php echo $product["processor_type"]; ?></p>
									</div>
								</div>
							</div>
							<hr class="mt-3 mb-4 mt-md-2 mb-md-3">
							<div class="px-3">
								<h5 class="mb-3 mb-md-2 myH5"><u>Display</u>:</h5>
								<div class="row">
									<div class="col-6">
										<h5 class="mb-3 mb-md-2 myH5">Resolution</h5>
										<p class="mb-2 myP"><?php echo $product["display_resolution"]; ?></p>
									</div>
									<div class="col-6">
										<h5 class="mb-3 mb-md-2 myH5">Technology</h5>
										<p class="mb-2 myP"><?php echo $product["display_technology"]; ?></p>
									</div>
								</div>
							</div>
							<hr class="mt-3 mb-4 mt-md-2 mb-md-3">
							<div class="px-3">
								<h5 class="mb-3 mb-md-2 myH5"><u>Camera</u>:</h5>
								<div class="row">
									<div class="col-6">
										<h5 class="mb-3 mb-md-2 myH5">Main</h5>
										<p class="mb-2 myP"><?php echo $product["camera_main"]; ?></p>
									</div>
									<div class="col-6">
										<h5 class="mb-3 mb-md-2 myH5">Front</h5>
										<p class="mb-2 myP"><?php echo $product["camera_front"]; ?></p>
									</div>
								</div>
							</div>
							<hr class="mt-3 mb-4 mt-md-2 mb-md-3">
							<div class="px-3">
								<h5 class="mb-3 mb-md-2 myH5"><u>Memory</u>:</h5>
								<div class="row">
									<div class="col-6">
										<h5 class="mb-3 mb-md-2 myH5">Ram</h5>
										<p class="mb-2 myP"><?php echo $product["ram"]; ?></p>
									</div>
									<div class="col-6">
										<h5 class="mb-3 mb-md-2 myH5">Internal</h5>
										<p class="mb-2 myP"><?php echo $product["internal_memory"]; ?></p>
									</div>
								</div>
							</div>
							<hr class="mt-3 mb-4 mt-md-2 mb-md-3">
							<div class="px-3">
								<h5 class="mb-3 mb-md-2 myH5"><u>Network</u>:</h5>
								<div class="row">
									<div class="col-6">
										<h5 class="mb-3 mb-md-2 myH5">SIM-Card</h5>
										<p class="mb-2 myP"><?php echo $product["sim_card"]; ?></p>
									</div>
									<div class="col-6">
										<h5 class="mb-3 mb-md-2 myH5">SIM-Slot</h5>
										<p class="mb-2 myP"><?php echo $product["sim_slot"]; ?></p>
									</div>
								</div>
							</div>
<?php  
	} else if ($category == "cover") {
?>
							<div class="row px-3">
								<div class="col-6">
									<h5 class="mb-3 mb-md-2 myH5">Brand</h5>
									<p class="mb-2 myP"><?php echo $product["brand"]; ?></p>
								</div>
								<div class="col-6">
									<h5 class="mb-3 mb-md-2 myH5">Type</h5>
									<p class="mb-2 myP"><?php echo $product["type"]; ?></p>
								</div>
							</div>
<?php  
	} else if ($category == "headphone") {
?>
							<div class="row px-3">
								<div class="col-6">
									<h5 class="mb-3 mb-md-2 myH5">Brand</h5>
									<p class="mb-2 myP"><?php echo $product["brand"]; ?></p>
								</div>
								<div class="col-6">
									<h5 class="mb-3 mb-md-2 myH5">Type</h5>
									<p class="mb-2 myP"><?php echo $product["type"]; ?></p>
								</div>
							</div>
							<hr class="mt-3 mb-4 mt-md-2 mb-md-3">
							<div class="row px-3">
								<div class="col-6">
									<h5 class="mb-3 mb-md-2 myH5">Wireless</h5>
									<p class="mb-2 myP"><?php echo $product["wireless"]; ?></p>
								</div>
								<div class="col-6">
									<h5 class="mb-3 mb-md-2 myH5">Electrical Impendance</h5>
									<p class="mb-2 myP"><?php echo $product["electrical_impendance"]; ?></p>
								</div>
							</div>
							<hr class="mt-3 mb-4 mt-md-2 mb-md-3">
							<div class="px-3">
								<h5 class="mb-3 mb-md-2 myH5">Microphone</h5>
								<p class="mb-2 myP"><?php echo $product["microphone"]; ?></p>
							</div>
<?php  
	} else if ($category == "charger") {
?>
							<div class="row px-3">
								<div class="col-6">
									<h5 class="mb-3 mb-md-2 myH5">Brand</h5>
									<p class="mb-2 myP"><?php echo $product["brand"]; ?></p>
								</div>
								<div class="col-6">
									<h5 class="mb-3 mb-md-2 myH5">Output Power</h5>
									<p class="mb-2 myP"><?php echo $product["output_power"]; ?></p>
								</div>
							</div>
<?php  
	}
?>
							<hr class="mt-3 mb-4 mt-md-2 mb-md-3">
							<div class="px-3 flex-wrap d-sm-flex justify-content-between">
								<div class="mb-4 mb-md-3">
									<h5 id="newPrice" class="d-inline mr-2 mb-3 mb-md-2 myH5"><?php echo createCurrencyFormat($product["new_price"]); ?></h5>
									<s><p id="oldPrice" class="d-inline myP"><?php echo createCurrencyFormat($product["old_price"]); ?></p></s>
								</div>
								<button type="button" value="<?php echo $product["id"]; ?>" class="btn btn-info myButton ml-auto mb-4 mb-md-3 myP" <?php echo $userButton; ?>>Add to Cart</button>
							</div>
<?php  
	if (! isset($_SESSION["user"]) 
	&& ! isset($_SESSION["admin"])) {
		echo '
									<h5 class="ml-3 myH5">Please 
										<a href="login.php">log in</a>
										 to purchase a product.
									</h5>
		';
	}
?>
						<div id="myMessage"></div>
						</div>
					</div>
					<a href="../user/actions/write_update_review.php?write&&category=<?php echo $product['category']; ?>&&id=<?php echo $product['id']; ?>" class="btn btn-dark myP" <?php echo $userButton; ?>>Write Review</a>
				</section>
<?php
	$sql = "select `review`.`id`, `review`.`title`, `review`.`text_area`, `review`.`stars`, `review`.`creation_date`, `review`.`fk_user`, `user`.`name`, `user`.`email` from `review`
	join `user` on `review`.`fk_user` = `user`.`id`
	where `fk_{$category}` = {$id} 
	and `user`.`status` = 1";
	$result = $connection->query($sql);
	$connection->close();

	if ($result->num_rows > 0) {
?>
				<!-- reviews -->
				<section>
					<div class="mb-5">
						<h3 class="my-5 my-md-4 text-center myH3">Reviews</h3>
<?php
	$reviews = $result->fetch_all(MYSQLI_ASSOC);
	
	foreach ($reviews as $review) { 
?>
						<div class="review mt-4 mt-md-3 p-4 rounded bg-light">
							<div class="row">

								<!-- avatar -->
								<div class="col-md-2 p-md-3 text-center">
									<img src="<?php echo getGravatar($review['email']); ?>" class="detailsAvatar">
									<p class="mt-2 myP"><?php echo $review["name"] . " on " . date("F jS Y", $review["creation_date"] = time()); ?></p>
								</div>

								<!-- text -->
								<div class="col-md-10 px-5 py-md-3 d-flex flex-column">
									<div>
										<span class="d-block d-md-inline mr-3 mb-3 mb.md-0 text-center text-md-left biggerRating"><?php echo createStars($review["stars"]); ?></span>
										<h5 class="d-inline myH5"><?php echo $review["title"]; ?></h5>
									</div>
									<p class="mt-2 myP"><?php echo $review["text_area"]; ?></p>
<?php  
		if (isset($_SESSION["user"])) {
			if ($review["fk_user"] == $_SESSION["user"]) {
				echo '
									<a href="../user/actions/write_update_review.php?update&&reviewId=' . $review["id"] . '&&category=' . $product["category"] . '&&id=' . $product["id"] . '" class="btn btn-dark align-self-end mt-auto myP">Update Review</a>
				';
			}
		}
?>
									<a href="../admin/crud/reviews/delete_confirm.php?id=<?php echo $review['id']; ?>&&productCategory=<?php echo $product['category']; ?>&&productId=<?php echo $product['id']; ?>" class="btn btn-danger align-self-end mt-auto myP" <?php echo $adminButton; ?>>Delete Review</a>
								</div>
							</div>
						</div>
<?php   
	}
?>
					</div>
				</section>
<?php   
	}
?>
			</div>
		</main>
	</div>
<?php  
	}
?>
	<?php include "../../view/footer.php"; ?>

    <?php echo $scripts; ?>
	<script src="../../js/details.js"></script>
	<script src="../../ajax/details.js"></script>
    <script src="../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>