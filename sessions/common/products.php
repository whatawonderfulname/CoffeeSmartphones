<?php
	ob_start();
	session_start();

	include "../../services/main.php";
	include "../../services/database_connection.php";
	include "../../services/handle_products.php";

	$connection->close();
	$scripts .= "
		<script>
			let products = " . json_encode($products) . ";
		</script>
	";
?>

<!DOCTYPE html>
<html lang="de">
<head>
	<?php include "../../view/head.php"; ?>
</head>
<body>
	<?php include "../../view/navbar.php"; ?>

	<!-- hero -->
	<div id="productHero">
		<img src="https://cdn.pixabay.com/photo/2016/05/27/08/51/mobile-phone-1419275__480.jpg" alt="smartphone" id="productsfittingImage" class="fittingImage">
	</div>
	<main>

		<!-- horizontal filtering and sorting bar -->
		<div id="horizontalBar" class="bg-white border-top border-bottom">
			<div class="clearfix">
				<div id="filterBar" class="pr-md-3">
					<span>Filter</span>
					<span>|</span>
					<span id="filteredItems"></span>
					<span>&#10005;</span>
					<hr>
				</div>
				<div id="criteriaBar"></div>
				<div id="criteriaButton">
					<span class="more border rounded-lg px-1">More +</span>
					<span class="less border rounded-lg px-1">Less -</span>
				</div>
				<div id="sortBar" class="pl-md-3">
					<label for="sort" class="mb-0 mr-2">Sort</label>
					<select id="sort">
						<option value="new_price ascending" selected>Price Ascending</option>
						<option value="new_price descending">Price Descending</option>
						<option value="adding_date descending">Date</option>
						<option value="stars descending">Rating</option>
					</select>
				</div>
			</div>
		</div>
		<div class="d-flex">

			<!-- vertical filtering bar -->
			<div id="verticalBar" class="h-100 p-3 px-md-2 py-md-3">
				<div class="barSection px-3 px-md-2">
					<div data-toggle="collapse" data-target="#accessoireCheckboxes" class="sectionHeading d-flex justify-content-between mt-2 mb-4 mt-md-0 mb-md-3">
				    	<div class="myH5">Category</div>
				    	<div>
				    		<span class="plus ml-1 myH5">+</span>
				    		<span class="minus ml-1 myH5">-</span>
				    	</div>
				    </div>
				    <div id="accessoireCheckboxes" class="collapse mt-4 mb-5 mt-md-3 mb-md-4">
				    	<div class="wrapper">
				    		<span class="myP">Smartphone</span>
				    		<input type="checkbox" name="category" value="smartphone">
							<span class="checkmark"></span>
				    	</div>
				    	<div class="wrapper myP">
				    		<span class="myP">Cover</span>
				    		<input type="checkbox" name="category" value="cover">
							<span class="checkmark"></span>
				    	</div>
						<div class="wrapper myP">
				    		<span class="myP">Headphone</span>
				    		<input type="checkbox" name="category" value="headphone">
							<span class="checkmark"></span>
				    	</div>
						<div class="wrapper myP">
				    		<span class="myP">Charger</span>
				    		<input type="checkbox" name="category" value="charger">
							<span class="checkmark"></span>
				    	</div>
				    </div>
				</div>
			    <hr class="my-3">
			    <div class="barSection px-3 px-md-2">
					<div data-toggle="collapse" data-target="#brandCheckboxes" class="sectionHeading d-flex justify-content-between mt-2 mb-4 mt-md-0 mb-md-3">
				    	<div class="myH5">Brand</div>
				    	<div>
				    		<span class="plus ml-1 myH5">+</span>
				    		<span class="minus ml-1 myH5">-</span>
				    	</div>
				    </div>
				    <div id="brandCheckboxes" class="collapse mt-4 mb-5 mt-md-3 mb-md-4">
				    	<div class="wrapper myP">
				    		<span class="myP">Apple</span>
				    		<input type="checkbox" name="brand" value="Apple">
							<span class="checkmark"></span>
				    	</div>
				    	<div class="wrapper myP">
				    		<span class="myP">Samsung</span>
				    		<input type="checkbox" name="brand" value="Samsung">
							<span class="checkmark"></span>
				    	</div>
						<div class="wrapper myP">
				    		<span class="myP">HTC</span>
				    		<input type="checkbox" name="brand" value="HTC">
							<span class="checkmark"></span>
				    	</div>
				    </div>
				</div>
			    <hr>
			    <div class="px-3 py-4">
			    	<button type="button" class="btn btn-info w-100 rounded-lg myP">Close</button>
			    </div>
			</div>

			<!-- cards -->
			<div id="cards" class="cards row min-h-100 mx-0 pb-5 bg-light"></div>
		</div>
	</main>
	<?php include "../../view/footer.php"; ?>

    <?php echo $scripts; ?>
	<script src="../../js/main.js"></script>
	<script src="../../js/products.js"></script>
    <script src="../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>