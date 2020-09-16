<?php
	ob_start();
	session_start();
	
	include "services/main.php";
	include "services/database_connection.php";
	include "services/handle_products.php";

	$connection->close();

	// get the newest products
	usort($products, function($a, $b) {
	    return $b["adding_date"] <=> $a["adding_date"];
	});

	$newProducts = array_slice($products, 0, 5);

	// get products with discount
	$productsWithDiscount = [];

	foreach ($products as $product) {
		if ($product["discount"] != 0) {
			array_push($productsWithDiscount, $product);
		}
	}

	usort($productsWithDiscount, function($a, $b) {
	    return $b["discount"] <=> $a["discount"];
	});

	$scripts .= "
		<script>
			let newProducts = " . json_encode($newProducts) . ";
			let productsWithDiscount = " . json_encode($productsWithDiscount) . ";
		</script>
	";
?>

<!DOCTYPE html>
<html lang="de">
<head>
	<?php include "view/head.php"; ?>
</head>
<body>
	<?php include "view/navbar.php"; ?>

	<!-- slider -->
	<div id="homeHero" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<div class="carousel-item active heroItem">
				<img src="https://cdn.pixabay.com/photo/2015/03/26/09/44/cell-phone-690192__480.jpg" class="fittingImage d-block" alt="smartphone">
			</div>
			<div class="carousel-item heroItem">
				<img src="https://cdn.pixabay.com/photo/2015/06/08/15/09/photography-801891__480.jpg" class="fittingImage d-block" alt="smartphone">
			</div>
			<div class="carousel-item heroItem">
				<img src="https://cdn.pixabay.com/photo/2015/01/08/18/24/smartphone-593318__480.jpg" class="fittingImage d-block" alt="smartphone">
			</div>
		</div>
		<a class="carousel-control-prev" href="#homeHero" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#homeHero" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

	<!-- content -->
	<main class="py-5 bg-light">
		<div class="container text-center">
			<h3 class="mt-5 mb-4 mt-md-4 mb-md-3 myH3">New Articles</h3>
			<div id="newProducts" class="cards row mx-0"></div>
			<h3 class="mt-5 mb-4 mt-md-4 mb-md-3 myH3">Articles with Discount</h3>
			<div id="productsWithDiscount" class="cards row mx-0"></div>
			<h3 class="my-5 mt-md-4 mb-md-3 myH3">We Offer</h3>
			<ul class="text-left">
				<li><h5 class="myH5">Modern technologies</h5></li>
				<li><h5 class="myH5">Technical support</h5></li>
				<li><h5 class="myH5">2 years warranty</h5></li>
			</ul>
		</div>
	</main>
	<?php include "view/footer.php"; ?>
	
	<?php echo $scripts; ?>
	<script src="js/main.js"></script>
	<script src="js/index.js"></script>
	<script src="ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>