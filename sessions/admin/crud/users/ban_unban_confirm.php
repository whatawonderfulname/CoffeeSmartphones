<?php
  ob_start();
  session_start();

  include "../../../../services/main.php";
  include "../../../../services/database_connection.php";

  adminCheck();

  if 
  (count($_GET) !== 2 
  || ! isset($_GET["id"]) 
  || ! (isset($_GET["ban"]) || isset($_GET["unban"]))) 
  {
    goToIndex();
  }

  if (isset($_GET["ban"])) {
    $action = "ban";
    $color = "danger";
    $newStatus = 0;
  } elseif (isset($_GET["unban"])) {
    $action = "unban";
    $color = "success";
    $newStatus = 1;
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
  // get the user to ban / unban
  $sql = "select * from `user` where `id` = " . escape($_GET["id"]);
  $result = $connection->query($sql);
  $connection->close();
  $user = $result->fetch_assoc();
?>
      <h5 class="mb-4 mb-md-3 myH5"><?php echo $user["name"]; ?></h5>
      <h5 class="mb-5 mb-md-4 myH5">Do you really want to <?php echo $action; ?> this user?</h5>
      <a href="ban_unban.php?newStatus=<?php echo $newStatus; ?>&&id=<?php echo escape($_GET['id']); ?>" class="mr-3 mr-md-2 btn btn-<?php echo $color; ?> myP">Yes</a>
      <a href="../../dashboard.php" class="btn btn-dark myP">No</a>
    </main>
  </div>
  <?php include "../../../../view/footer.php"; ?>
  
    <?php echo $scripts; ?>
    <script src="../../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>