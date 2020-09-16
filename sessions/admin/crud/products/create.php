<?php
  ob_start();
  session_start();

  include "../../../../services/main.php";
  include "../../../../services/database_connection.php";

  adminCheck();

  // create a new database entry
  if ($_POST) {
    $category = sanitize($_POST["category"]);
    $sql = "insert into `{$category}` 
    (`name`, `img`, `brand`, ";

    if ($category == "smartphone") {
      $sql .= "`processor_frequency`, `processor_type`, `display_resolution`, `display_technology`, `camera_main`, `camera_front`, `ram`, `internal_memory`, `sim_card`, `sim_slot`, ";
    } elseif ($category == "cover") {
      $sql .= "`type`, ";
    } elseif ($category == "headphone") {
      $sql .= "`type`, `wireless`, `electrical_impendance`, `microphone`, ";
    } elseif ($category == "charger") {
      $sql .= "`output_power`, ";
    }

    $sql .= "`price`, `discount`, `amount_available`)
    values 
      ('" . sanitize($_POST["name"]) . "', 
      '" . sanitize($_POST["img"]) . "', 
      '" . sanitize($_POST["brand"]) . "', ";

    if ($category == "smartphone") {
      $sql .= "
      '" . sanitize($_POST["processor_frequency"]) . "', 
      '" . sanitize($_POST["processor_type"]) . "', 
      '" . sanitize($_POST["display_resolution"]) . "', 
      '" . sanitize($_POST["display_technology"]) . "', 
      '" . sanitize($_POST["camera_main"]) . "', 
      '" . sanitize($_POST["camera_front"]) . "', 
      '" . sanitize($_POST["internal_memory"]) . "', 
      '" . sanitize($_POST["ram"]) . "', 
      '" . sanitize($_POST["sim_card"]) . "', 
      '" . sanitize($_POST["sim_slot"]) . "', ";
    } elseif ($category == "cover") {
      $sql .= "
      '" . sanitize($_POST["type"]) . "', ";
    } elseif ($category == "headphone") {
      $sql .= "
      '" . sanitize($_POST["type"]) . "', 
      '" . sanitize($_POST["wireless"]) . "', 
      '" . sanitize($_POST["electrical_impendance"]) . "', 
      '" . sanitize($_POST["microphone"]) . "', ";
    } elseif ($category == "charger") {
      $sql .= "
      '" . sanitize($_POST["ouput_power"]) . "', ";
    }

    $sql .= sanitize($_POST["price"]) . ", 
      " . sanitize($_POST["discount"]) . ", 
      " . sanitize($_POST["amount_available"]) . ")";

    if ($connection->query($sql)) {
      $message = "Created product successfully.";
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
    <div class="container my-5 text-center">
      <main>
        <h3 class="mb-5 mb-md-4 myH3">Create Product</h3>
        <div>
          <button type="button" class="chooseCategory mr-4 mr-md-3 mb-4 btn btn-dark myP" value="smartphone">Smartphone</button>
          <button type="button" class="chooseCategory mr-4 mr-md-3 mb-4 btn btn-dark myP" value="charger">Charger</button>
          <button type="button" class="chooseCategory mr-4 mr-md-3 mb-4 btn btn-dark myP" value="headphone">Headphone</button>
          <button type="button" class="chooseCategory mr-4 mr-md-3 mb-4 btn btn-dark myP" value="cover">Cover</button>
        </div>
<?php 
  if (isset($message)) {
    echo '
        <div class="alert alert-' . $messageColor . ' mb-4 myP">' . $message . '</div>
    ';
  }
?>
        <div class="row">
          <div class="col-md-8 col-lg-6 offset-md-2 offset-lg-3">
            <div id="createProductForm" class="d-none px-4 px-md-3 bg-dark text-white text-center rounded-lg">
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div id="inputs" class="form-group"></div>
              </form>
            </div>
          </div>
        </div>
        <a href="../../dashboard.php" class="mt-2 mt-md-0 btn btn-dark myP">Back</a>
      </main>
    </div>
  </div>
  <?php include "../../../../view/footer.php"; ?>
  
  <?php echo $scripts; ?>
  <script src="../../../../js/create_product.js"></script>
  <script src="../../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>