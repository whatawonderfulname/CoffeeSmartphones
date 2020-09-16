<?php 
  ob_start();
  session_start();

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  include "../../composer/vendor/autoload.php";
  include "../../services/main.php";
  include "../../services/database_connection.php";

  userCheck();

  $topic = "";
  $text = "";
  $error = false;

  if ($_POST) {
    $topic = escape($_POST["topic"]);
    $text = escape($_POST["text"]);

    // check if the input is valid
    if (empty($topic)) {
      $error = true;
      $topicError = "Please enter a topic.";
    }

    if (empty($text)) {
      $error = true;
      $textError = "Please enter a text.";
    }

    // send an email
    if (! $error){

      // get the user data
      $sql = "select `name`, `email` from `user` where `id` = {$_SESSION['user']}";
      $result = $connection->query($sql);
      $connection->close();
      $user = $result->fetch_assoc();
      $htmlText = "
        <html>
          Hello manager John Doe,<br>
          <br>
          {$user['name']} sent the following message:<br>
          <br>
          {$text}<br>
          Please, reply to {$user['email']}.<br>
          <br>
          Kind regards,<br>
          Your Coffee Team
        </html>
      ";
      $plainText = "Hello manager John Doe, {$user['name']} sent the following message. {$text} Please, reply to {$user['email']}. Kind regards, your Coffee Team.";
      
      if 
      (sendEmail(
        "alexander.schaedlich@gmail.com", 
        "Coffee Team", 
        $topic, 
        $htmlText, 
        $plainText
      )) 
      {
        $message = "Sent message successfully.";
        $messageColor = "success";
      } else {
        $message = "Something went wrong, try again later...";
        $messageColor = "danger";
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <?php include "../../view/head.php"; ?>
</head>
<body>
  <?php include "../../view/navbar.php"; ?>
  <main>
    <div class="container my-5">
      <!-- contact form -->
      <section>
        <h3 class="mb-5 mb-md-4 text-center myH3">Contact Us</h3>
        <p class="mb-4 mb-md-3 text-center myP">Please check <a href="faq.php">Frequently Asked Questions</a> before sending a message here.</p>
<?php 
  if (isset($message)) {
    echo '
        <div class="alert alert-' . $messageColor . ' mb-4 myP">' . $message . '</div>
    ';
  }
?>
        <div class="row">
          <div class="col-md-8 col-lg-6 offset-md-2 offset-lg-3">
            <div class="px-4 py-md-3 bg-dark text-white text-center rounded-lg">
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="msgForm">
                <div class="form-group">
                  <label for="topic" class="mt-4 mt-md-3 mb-3 mb-md-2 myP">Topic</label>
                  <input type="text" name="topic" id="topic" class="form-control myP" value="<?php echo $topic; ?>">
<?php  
  if (isset($topicError)) {
    echo '
                  <span class="text-warning myP">' . $topicError . '</span>
    ';
  }
?>
                </div>
                <div>
                  <label for="text" class="mb-3 mb-md-2 myP">Message</label>
                  <textarea name="text" id="text" class="form-control myP"> <?php echo $text; ?></textarea>
<?php  
  if (isset($topicError)) {
    echo '
                  <span class="text-warning myP">' . $textError . '</span>
    ';
  }
?>
                </div>
                <button type="submit" class="btn btn-primary my-4 my-md-3 myP">Send</button>
              </form>
          </div>
        </div>
      </section>
      <br>
      <!-- map -->
      <section>
        <h3 class="text-center my-5 myH3">Our Location</h3>
        <div id="map"></div>
      </section>
      <br>
    </div>
  </main>
  <?php include "../../view/footer.php"; ?>

        
  <?php echo $scripts; ?>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtjaD-saUZQ47PbxigOg25cvuO6_SuX3M&callback=initializeMap"
  async defer></script>
  <script src="../../js/contact.js"></script>
  <script src="../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>