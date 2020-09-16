<?php
  ob_start();
  session_start();

  include "../../../../services/main.php";
  include "../../../../services/database_connection.php";

  adminCheck();
  
  if 
  (count($_GET) !== 3 
  || ! isset($_GET["id"]) 
  || ! isset($_GET["productCategory"]) 
  || ! isset($_GET["productId"])) 
  {
    goToIndex();
  }

  $sql = "delete from `review` where `id` = " . escape($_GET["id"]);
  
  if ($connection->query($sql)) {
    $message = "Deleted review successfully.";
    $messageColor = "success";
  } else {
    $message = "Something went wrong, try again later...";
    $messageColor = "danger";
  }
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
      <h5 class="text-<?php echo $messageColor; ?> mb-4 mb-md-3 myH5"><?php echo $message; ?></h5>
      <a href="../../../common/details.php?category=<?php echo escape($_GET['productCategory']); ?>&&id=<?php echo escape($_GET['productId']); ?>" class="btn btn-dark myP">Back</a>
    </main>
  </div>
  <?php include "../../../../view/footer.php"; ?>
  
    <?php echo $scripts; ?>
    <script src="../../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>