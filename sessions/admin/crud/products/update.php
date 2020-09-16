<?php
  ob_start();
  session_start();

  include "../../../../services/main.php";
  include "../../../../services/database_connection.php";

  adminCheck();

  if ($_GET) {
    if 
    (count($_GET) !== 2 
    || ! (isset($_GET["category"]) && isset($_GET["id"]))) 
    {
      goToIndex();
    }

    // get the product from the database
    $sql = "select * from `" . escape($_GET["category"]) . "` 
    where `id` = " . escape($_GET["id"]);
    $result = $connection->query($sql);
    $product = $result->fetch_assoc();
    $scripts .= "
      <script>
        let category = '" . escape($_GET['category']) . "';
        let product = " . json_encode($product) . ";
      </script>
    ";
  }

  // update the product in the database
  if ($_POST) {
    $category = sanitize($_POST["category"]);
    $sql = "update `{$category}` set 
      `name` = '" . sanitize($_POST["name"]) . "', 
      `img` = '" . sanitize($_POST["img"]) . "', 
      `brand` = '" . sanitize($_POST["brand"]) . "', ";

    if ($category == "smartphone") {
      $sql .= "
      `processor_frequency` = '" . sanitize($_POST["processor_frequency"]) . "', 
      `processor_type` = '" . sanitize($_POST["processor_type"]) . "', 
      `display_resolution` = '" . sanitize($_POST["display_resolution"]) . "', 
      `display_technology` = '" . sanitize($_POST["display_technology"]) . "', 
      `camera_main` = '" . sanitize($_POST["camera_main"]) . "', 
      `camera_front` = '" . sanitize($_POST["camera_front"]) . "', 
      `ram` = '" . sanitize($_POST["ram"]) . "', 
      `internal_memory` = '" . sanitize($_POST["internal_memory"]) . "', 
      `sim_card` = '" . sanitize($_POST["sim_card"]) . "', 
      `sim_slot` = '" . sanitize($_POST["sim_slot"]) . "', ";
    } elseif ($category == "cover") {
      $sql .= "
      `type` = '" . sanitize($_POST["type"]) . "', ";
    } elseif ($category == "headphone") {
      $sql .= "
      `type` = '" . sanitize($_POST["type"]) . "', 
      `wireless` = '" . sanitize($_POST["wireless"]) . "', 
      `electrical_impendance` = '" . sanitize($_POST["electrical_impendance"]) . "', 
      `microphone` = '" . sanitize($_POST["microphone"]) . "', ";
    } elseif ($category == "charger") {
      $sql .= "
      `output_power` = '" . sanitize($_POST["output_power"]) . "', ";
    }

    $sql .= "
    `price` = " . sanitize($_POST["price"]) . ", 
    `discount` = '" . sanitize($_POST["discount"]) . "', 
    `amount_available` = " . sanitize($_POST["amount_available"]) . ", 
    `visible` = '" . sanitize($_POST["visible"]) . "' 
    where `id` = " . $_POST["id"];

    if ($connection->query($sql)) {
      $message = "Updated product successfully.";
      $messageColor = "success";
    } else {
      $message = "Something went wrong, try again later...";
      $messageColor = "danger";
    }
  }

  $connection->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <?php include "../../../../view/head.php"; ?>
</head>
<body class="d-flex flex-column justify-content-between min-vh-100">
  <div>
    <?php include "../../../../view/navbar.php"; ?>
    <div class="container my-5">
      <main>
        <h3 class="text-center mb-5 mb-md-4 myH3">Update Product</h3>
<?php 
  if (isset($message)) {
    echo '
        <div class="alert alert-' . $messageColor . ' mb-4 myP">' . $message . '</div>
    ';
  }
  
  if ($_GET) {
?>
        <div class="row">
          <div class="col-md-8 col-lg-6 offset-md-2 offset-lg-3">
            <div id="createProductForm" class="px-4 px-md-3 bg-dark text-white text-center rounded-lg">
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div id="inputs" class="form-group"></div>
              </form>
            </div>
          </div>
        </div>
<?php  
  } else {
?>
        <a href="../../dashboard.php" class="btn btn-dark">Back</a>
<?php  
  }
?>
      </main>
    </div>
  </div>
  <?php include "../../../../view/footer.php"; ?>

  <?php echo $scripts; ?>
  <script src="../../../../js/update_product.js"></script>
  <script src="../../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>