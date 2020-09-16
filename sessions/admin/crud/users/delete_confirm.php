<?php
  ob_start();
  session_start();

  include "../../../../services/main.php";
  include "../../../../services/database_connection.php";

  adminCheck();

  if 
  (count($_GET) !== 1 
  || ! isset($_GET["id"])) 
  {
    goToIndex();
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
<?php  
  // get the user to delete
  $sql = "select * from `user` where `id` = " . escape($_GET["id"]);
  $result = $connection->query($sql);
  $connection->close();
  $user = $result->fetch_assoc();
?>
      <h5 class="mb-4 mb-md-3 myH5"><?php echo $user["name"]; ?></h5>
      <h5 class="mb-4 mb-md-3 myH5">Do you really want to delete this user?</h5>
      <a href="delete.php?id=<?php echo escape($_GET['id']); ?>" class="mr-3 mr-md-2 btn btn-danger myP">Yes</a>
      <a href="../../dashboard.php" class="btn btn-dark myP">No</a>
    </main>
  </div>
  <?php include "../../../../view/footer.php"; ?>
  
    <?php echo $scripts; ?>
    <script src="../../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>