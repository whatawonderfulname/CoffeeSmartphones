<?php
  ob_start();
  session_start();

  include "../../../services/main.php";
  include "../../../services/database_connection.php";

  userCheck();

  if (isset($_GET["create"])) {
    if (count($_GET) !== 1) {
      goToIndex();
    }
  } elseif (isset($_GET["update"])) {
    if 
    (count($_GET) !== 2 
    || ! isset($_GET["id"])) 
    {
      goToIndex();
    }
  }
  
  $firstName = "";
  $lastName = "";
  $address = "";
  $phoneNumber = "";

  // get the current billing details
  if (isset($_GET["update"])) {
    $_SESSION["billing_details_id"] = escape($_GET["id"]);
    $sql = "select * from `billing_details` 
    where `id` = {$_SESSION['billing_details_id']}";
    $result = $connection->query($sql);
    $billingDetails = $result->fetch_assoc();
    $firstName = $billingDetails["first_name"];
    $lastName = $billingDetails["last_name"];
    $address = $billingDetails["address"];
    $phoneNumber = $billingDetails["phone_number"];
  }

  if (isset($_GET["create"])) {
    $_SESSION["create_billing_details"] = true;
  }

  // check the form
  if ($_POST) {

    // sanitize the input to prevent sql injection
    $firstName = sanitize($_POST["firstName"]);
    $lastName = sanitize($_POST["lastName"]);
    $address = sanitize($_POST["address"]);
    $phoneNumber = sanitize($_POST["phoneNumber"]);

    // check if the input is valid
    $error = false;

    if (empty($firstName)) {
        $error = true;
        $firstNameError = "Please enter your first name.";
    }

    if (empty($lastName)) {
        $error = true;
        $lastNameError = "Please enter your last name.";
    }

    if (empty($address)) {
        $error = true;
        $addressError = "Please enter your billing address.";
    }

    if (empty($phoneNumber)) {
        $error = true;
        $phoneError = "Please enter your phone number.";
    }

    // update the database
    if (! $error) {
      // if billing details where set before and need to be updated only
      if (isset($_SESSION["billing_details_id"])) {
        $sql = "update `billing_details` 
        set 
        `first_name` = '{$firstName}', 
        `last_name` = '{$lastName}', 
        `address` = '{$address}', 
        `phone_number` = '{$phoneNumber}' 
        where `id` = {$_SESSION['billing_details_id']}";
        unset($_SESSION["billing_details_id"]);
      } else {
        // if the first billing details entry needs to be created
        if (isset($_SESSION["create_billing_details"])) {
          $sql = "
          insert into `billing_details` 
          (`first_name`, `last_name`, `address`, `phone_number`, `fk_user`, `by_default`) 
          values 
          ('{$firstName}', '{$lastName}', '{$address}', '{$phoneNumber}', {$_SESSION['user']}, 1)";
          unset($_SESSION["create_billing_details"]);
        } 
        // if a new billing details entry needs to be added
        else {
          $sql = "
          insert into `billing_details` 
          (`first_name`, `last_name`, `address`, `phone_number`, `fk_user`) 
          values 
          ('{$firstName}', '{$lastName}', '{$address}', '{$phoneNumber}', {$_SESSION['user']})";
        }
      }

      if ($connection->query($sql)) {
          $message = "Updated billing details successfully.";
          $messageColor = "success";
      } else {
          $message = "Something went wrong, try again later...";
          $messageColor = "danger";
      }
    }
  }
  
  $connection->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <?php include "../../../view/head.php"; ?>
</head>
<body class="d-flex flex-column justify-content-between min-vh-100">
  <?php include "../../../view/navbar.php"; ?>
  <div class="container my-5 text-center">
    <h3 class="mb-5 mb-md-4 myH3">Update Your Billing Details</h3>
<?php 
  if (isset($message)) {
    echo '
    <div class="alert alert-' . $messageColor . ' mb-4">' . $message . '</div>
    ';
  }
?>
    <div class="row">
      <div class="col-lg-6 offset-lg-3 px-4 px-md-3 rounded-lg bg-dark">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <div class="form-group">
            <label for="firstName" class="mt-4 mt-md-3 mb-3 mb-md-2 text-white myP">First Name</label>
            <input type="text" name="firstName" id="firstName" class="form-control myP" value="<?php echo $firstName; ?>">
<?php  
  if (isset($firstNameError)) {
    echo '
            <span class="text-warning myP">' . $firstNameError . '</span>
    ';
  }
?>
          </div>
          <div class="form-group">
            <label for="lastName" class="my-3 my-md-2 text-white myP">Last Name</label>
            <input type="text" name="lastName" id="lastName" class="form-control myP" value="<?php echo $lastName; ?>">
<?php  
  if (isset($lastNameError)) {
    echo '
            <span class="text-warning myP">' . $lastNameError . '</span>
    ';
  }
?>
          </div>
          <div class="form-group">
            <label for="address" class="my-3 my-md-2 text-white myP">Address</label>
            <input type="text" name="address" id="address" class="form-control myP" value="<?php echo $address; ?>">
<?php  
  if (isset($addressError)) {
    echo '
            <span class="text-warning myP">' . $addressError . '</span>
    ';
  }
?>
          </div>
          <div class="form-group">
            <label for="phoneNumber" class="my-3 my-md-2 text-white myP">Phone Number</label>
            <input type="tel" name="phoneNumber" id="phoneNumber" class="form-control myP" value="<?php echo $phoneNumber; ?>">
<?php  
  if (isset($phoneError)) {
    echo '
            <span class="text-warning myP">' . $phoneError . '</span>
    ';
  }
?>
          </div>
          <button type="submit" class="btn btn-info my-4 my-md-3 myP">Update</button>
        </form>
      </div>
    </div>
    <a href="../account.php" class="btn btn-dark mt-4 mt-md-3 myP">Back</a>
  </div>
  <?php include "../../../view/footer.php"; ?>

  <?php echo $scripts; ?>
  <script src="../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>