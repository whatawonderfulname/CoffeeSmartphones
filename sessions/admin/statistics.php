<?php
    ob_start();
    session_start();

    include "../../services/main.php";
    include "../../services/database_connection.php";

    adminCheck();

    $sql = "select * from `statistics`";
    $result = $connection->query($sql);
    $connection->close();
    $statistics = $result->fetch_all(MYSQLI_ASSOC);
    $scripts .= "
		<script>
			let statistics = " . json_encode($statistics) . ";
		</script>
    ";
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
            <div class="container my-5">
                <h3 class="mb-5 mb-md-4 text-center myH3">Statistics</h3>
                <div id="statistics"></div>
            </div>
        </main>
    </div>
    <?php include "../../view/footer.php"; ?>

    <?php echo $scripts; ?>
    <script src="../../js/main.js"></script>
    <script src="../../js/statistics.js"></script>
    <script src="../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>