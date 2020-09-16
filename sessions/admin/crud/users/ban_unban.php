<?php
  ob_start();
  session_start();

  include "../../../../services/main.php";
  include "../../../../services/database_connection.php";

  adminCheck();

  if 
  (count($_GET) !== 2 
  || ! (isset($_GET["newStatus"]) && isset($_GET["id"]))) 
  {
    goToIndex();
  }

  // set the status of a user in the database
  $sql = "update `user` set `status` = " . escape($_GET["newStatus"]) . " 
  where `id` = " . escape($_GET["id"]);

  if ($connection->query($sql)) {
    if ($_GET["newStatus"] == 0) {
      $message = "Banned user successfully.";
    } elseif ($_GET["newStatus"] == 1) {
      $message = "Unbanned user successfully.";
    }

    $messageColor = "success";
  } else {
    $message = "Something went wrong, try again later...";
    $messageColor = "danger";
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
    <main class="container my-5">
      <h5 class="text-<?php echo $messageColor; ?> mb-4 mb-md-3 myH5"><?php echo $message; ?></h5>
      <a href="../../dashboard.php" class="btn btn-dark myP">Back</a>
    </main>
  </div>
  <?php include "../../../../view/footer.php"; ?>
  
    <?php echo $scripts; ?>
    <script src="../../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>