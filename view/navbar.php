<?php  
	ob_start();

	include_once __DIR__ . "/../services/session_cart.php";

	if (isset($_SESSION["user"])) {
		$style = '';
	} else {
		$style = 'style="visibility: hidden;"';
	}
?>

<!-- live search -->
<div id="searchingForm">
	<div class="d-flex justify-content-center">
		<div class="d-flex pt-2">
			<i class="searchingSymbol fas fa-search mt-2 mr-3 mr-md-2"></i>
			<div>
				<form class="mb-0">
					<input id="searchInput" type="text" size="30" class="mt-1 myP">
				</form>
				<div id="searchingResult"></div>
			</div>
			<span id="searchingCross" class="mt-1 ml-3 ml-md-2">&#10005;</span>
		</div>
	</div>
</div>

<!-- navbar -->
<nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-dark p-3 py-md-2 py-lg-1">
	<button class="navbar-toggler ml-3 ml-md-0" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand p-0 text-light" href="<?php echo $myPath; ?>index.php">
		<img src="<?php echo $myPath; ?>img/logo_white.png" alt="logo">
		<span class="myP p-1">Coffee</span>
	</a>
	<a class="shoppingCart nav-link text-info" href="<?php echo $myPath; ?>sessions/user/cart.php" <?php echo $style; ?>>
		<span>
			<i class="fas fa-shopping-cart"></i>
			<p class="totalItems d-inline"><?php echo $_SESSION["total_items"]; ?></p>
		</span>
	</a>
	<div id="navbarNav" class="collapse navbar-collapse">
		<div class="navbar-nav ml-auto py-2 py-lg-0">
			<a class="nav-link text-light ml-3 ml-md-0 pt-4 pb-3 py-md-1 myP" href="<?php echo $myPath; ?>index.php">Home</a>
			<a class="nav-link text-light ml-3 ml-md-0 py-3 py-md-1 myP" href="<?php echo $myPath; ?>sessions/common/products.php">Products</a>
<?php
	if (isset($_SESSION["admin"])) {
?>
			<a class="nav-link text-light ml-3 ml-md-0 py-3 py-md-1 myP" href="<?php echo $myPath; ?>sessions/admin/dashboard.php">Dashboard</a>
			<a class="nav-link text-light ml-3 ml-md-0 py-3 py-md-1 myP" href="<?php echo $myPath; ?>sessions/admin/statistics.php">Statistics</a>
			<a class="nav-link text-light ml-3 ml-md-0 py-3 py-md-1 myP" href="<?php echo $myPath; ?>sessions/common/logout.php?logout">Log Out</a>
			<i id="searchingSymbol" class="searchingSymbol fas fa-search nav-link ml-3 ml-md-0 py-3 py-md-1"></i>
<?php
	} elseif (isset($_SESSION["user"])) { 
?>
			<a class="nav-link text-light ml-3 ml-md-0 py-3 py-md-1 myP" href="<?php echo $myPath; ?>sessions/user/faq.php">FAQ</a>
			<a class="nav-link text-light ml-3 ml-md-0 py-3 py-md-1 myP" href="<?php echo $myPath; ?>sessions/user/contact.php">Contact</a>
			<a class="nav-link text-light ml-3 ml-md-0 py-3 py-md-1 myP" href="<?php echo $myPath; ?>sessions/user/account.php">Account</a>
			<a class="nav-link text-light ml-3 ml-md-0 py-3 py-md-1 myP" href="<?php echo $myPath; ?>sessions/common/logout.php">Log Out</a>
			<i id="searchingSymbol" class="searchingSymbol fas fa-search nav-link ml-3 ml-md-0 py-3 py-md-1"></i>
			<a class="shoppingCart nav-link text-info ml-3 ml-md-0 py-3 py-md-1" href="<?php echo $myPath; ?>sessions/user/cart.php">
				<span>
					<i class="fas fa-shopping-cart"></i>
					<p class="totalItems d-inline"><?php echo $_SESSION["total_items"]; ?></p>
				</span>
			</a>
<?php
	} else {
?>
			<a class="nav-link text-light ml-3 ml-md-0 py-3 py-md-1 myP" href="<?php echo $myPath; ?>sessions/user/faq.php">FAQ</a>
			<a class="nav-link text-white ml-3 ml-md-0 py-3 py-md-1 myP" href="<?php echo $myPath; ?>sessions/common/login.php">Log In</a>
			<i id="searchingSymbol" class="searchingSymbol fas fa-search nav-link ml-3 ml-md-0 py-3 py-md-1"></i>
<?php 
	}
?>
		</div>
	</div>
</nav>

<?php ob_end_flush() ?>