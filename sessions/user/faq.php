<?php
	ob_start();
	session_start();

	include "../../services/main.php";
	include "../../services/database_connection.php";
?>

<!DOCTYPE html>
<html lang="de">
<head>
	<?php include "../../view/head.php"; ?>
</head>
<body class="d-flex flex-column justify-content-between min-vh-100">
	<div>
		<?php include "../../view/navbar.php"; ?>
		<main>
			<div class="container">
				<h3 class="text-center pt-5 mb-5 mb-md-4 myH3">Frequently Asked Questions</h3>
				<hr>
<?php 
	// get the database entries 
	$sql = "select * from `faq`";
	$result = $connection->query($sql);
	$connection->close();
	
	while ($faq = $result->fetch_assoc()) {
?>
				<h5 class="d-inline myH5"><?php echo $faq["topic"]; ?> </h5>
			    <i data-toggle="collapse" data-target="#text<?php echo $faq["id"]; ?>" class="fas fa-chevron-down myP"></i>
			    <div id="text<?php echo $faq["id"]; ?>" class="collapse">
			    	<br>
			    	<p class="myP"><?php echo $faq["text"]; ?></p>
			    </div>
			    <hr>
<?php
	}
?>
			</div>
		</main>
	</div>
	<?php include "../../view/footer.php"; ?>
	

    <?php echo $scripts; ?>
	<script src="../../js/faq.js"></script>
    <script src="../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>