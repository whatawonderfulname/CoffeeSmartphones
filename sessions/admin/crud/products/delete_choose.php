<?php
    ob_start();
    session_start();

    include "../../../../services/main.php";
    include "../../../../services/database_connection.php";

    adminCheck();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <?php include "../../../../view/head.php"; ?>
</head>
<body class="d-flex flex-column justify-content-between min-vh-100">
    <div>
        <?php include "../../../../view/navbar.php"; ?>
        <main class="container my-5">
<?php
  $products = [];

  // get products of each category
  function getProducts($category) {
    global $connection;
    global $products;
    $sql = "select * from `{$category}`";
    $result = $connection->query($sql);
    $products[$category] = $result->fetch_all(MYSQLI_ASSOC);
  }

  getProducts("smartphone");
  getProducts("cover");
  getProducts("headphone");
  getProducts("charger");
  $connection->close();

  // render tables for each category
  function renderTable($category) {
    global $products;

    if (empty($products[$category])) {
      echo '
          <h5 class="myH5">There are no products of the type ' . $products[$category] . ' available.</h5>
      ';
    } else {
      echo '
          <h3 class="text-center mb-5 mb-md-4 myH3">' . ucwords($category) . 's</h3>
          <div class="row mb-5 mb-md-4">
            <div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 p-0 rounded border border-secondary">
      ';

      for ($i = 0; $i < count($products[$category]); $i++) {
        $class = "";

        if ($i == 0) {
          $class .= "firstCell";
        }

        if ($i == count($products[$category]) - 1) {
          $class .= "lastCell";
        }

        echo '
              <div class="d-flex justify-content-between p-3 border border-secondary ' . $class . '">
                <p class="myP">' . $products[$category][$i]["name"] . '</p>
                <a href="delete_confirm.php?category=' . $category . '&&id=' . $products[$category][$i]["id"] . '" class="btn btn-danger myP">Delete</a>
              </div>
        ';
      }

      echo '
            </div>
          </div>
      ';
    }
  }

  renderTable("smartphone");
  renderTable("cover");
  renderTable("headphone");
  renderTable("charger");
?>
        </main>
    </div>
    <?php include "../../../../view/footer.php"; ?>
  
    <?php echo $scripts; ?>
    <script src="../../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>