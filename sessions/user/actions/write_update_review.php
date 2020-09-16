<?php
    ob_start();
    session_start();

    include "../../../services/main.php";
    include "../../../services/database_connection.php";

    userCheck();

    $rating = ["selected", "", "", "", "", ""];
    $title = "";
    $text = "";
    $error = false;
    $ratingError = "";
    $titleError = "";
    $textError = "";
    $category = "";
    $id = "";
    $reviewId = "";

    if (isset($_GET["write"])) {
        if 
        (count($_GET) !== 3 
        || ! isset($_GET["category"]) 
        || ! isset($_GET["id"])) 
        {
            goToIndex();
        }
    } elseif (isset($_GET["update"])) {
        if 
        (count($_GET) !== 4 
        || ! isset($_GET["category"]) 
        || ! isset($_GET["id"]) 
        || ! isset($_GET["reviewId"])) 
        {
            goToIndex();
        }
    }
    
    // get the data related to the review
    if ($_GET) {
        $category = escape($_GET["category"]);
        $id = escape($_GET["id"]);
    }

    if (isset($_GET["update"])) {
        $reviewId = escape($_GET["reviewId"]);
        $sql = "select * from `review` where `id` = {$reviewId}";
        $result = $connection->query($sql);
        $review = $result->fetch_assoc();
        $rating = ["", "", "", "", ""];
        $rating[$review["stars"]] = "selected";
        $title = $review["title"];
        $text = $review["text_area"];
    }

    // create / update a review
    if ($_POST) {
        // sanitize the input to prevent sql injection
        $ratingNumber = sanitize($_POST["rating"]);
        $rating = ["", "", "", "", "", ""];
        $rating[$ratingNumber] = "selected";
        $title = sanitize($_POST["title"]);
        $text = sanitize($_POST["text"]);
        $category = sanitize($_POST["category"]);
        $id = sanitize($_POST["id"]);
        $reviewId = sanitize($_POST["reviewId"]);

        // check if the input is valid
        if ($ratingNumber == 0) {
            $error = true;
            $ratingError = "Please choose a rating.";
        }

        if (empty($title)) {
            $error = true;
            $titleError = "Please enter a title.";
        }

        if (empty($text)) {
            $error = true;
            $textError = "Please enter a text message.";
        }

        // save the review in the database
        if (! $error){
            if (! empty($reviewId)) {
                $sql = "update `review` set 
                `stars` = {$ratingNumber}, 
                `title` = '{$title}', 
                `text_area` = '{$text}' 
                where `id` = {$reviewId}";

                if ($connection->query($sql)) {
                    $message = "Updated review successfully.";
                    $messageColor = "success";
                } else {
                    $message = "Something went wrong, try again later...";
                    $messageColor = "danger";
                }
            } else {
                $sql = "insert into `review` 
                (`fk_user`, `fk_{$category}`, `stars`, `title`, `text_area`) 
                values 
                ({$_SESSION['user']}, {$id}, {$ratingNumber}, '{$title}', '{$text}')";

                if ($connection->query($sql)) {
                    $message = "Created review successfully.";
                    $messageColor = "success";
                } else {
                    $message = "Something went wrong, try again later...";
                    $messageColor = "danger";
                }
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
    <div>
        <?php include "../../../view/navbar.php"; ?>
        <div class="container my-5 text-center">
            <h3 class="mb-5 mb-md-4 myH3">Review</h3> 
<?php  
    if (isset($message)) {
        echo '
            <div class="alert alert-' . $messageColor . ' mb-4 mb-md-3 myP">' . $message . '</div>

            <a href="../../common/details.php?category=' . $category . '&&id=' . $id . '" class="btn btn-dark myP">Back</a>
        ';
    }
    
    if ($_GET) {
?>
            <div class="row">
                <div class="col-lg-6 offset-lg-3 rounded-lg bg-dark">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="reviewForm">
                        <div class="form-group">
                            <label for="rating" class="mt-4 mt-md-3 mb-3 mb-md-2 text-white myP">Rating</label>
                            <select name="rating" id="rating" class="form-control" required>
                                <option <?php echo $rating[0]; ?> value="0">Rate, please</option>
                                <option <?php echo $rating[5]; ?> value="5">5</option>
                                <option <?php echo $rating[4]; ?> value="4">4</option>
                                <option <?php echo $rating[3]; ?> value="3">3</option>
                                <option <?php echo $rating[2]; ?> value="2">2</option>
                                <option <?php echo $rating[1]; ?> value="1">1</option>
                            </select>
                            <span class="text-warning myP"><?php echo $ratingError; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="title" class="my-3 my-md-2 text-white myP">Title</label>
                            <input type="text" name="title" id="title" class="form-control myP" value="<?php echo $title; ?>">
                            <span class="text-warning myP"><?php echo $titleError; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="reviewText" class="my-3 my-md-2 text-white myP">Text</label>
                            <textarea name="text" id="reviewText" class="form-control myP"><?php echo $text; ?></textarea>
                            <span class="text-warning"><?php echo $textError; ?></span>
                        </div>
                        <input type="hidden" name="category" value="<?php echo $category; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="reviewId" value="<?php echo $reviewId; ?>">
                        <button type="submit" class="btn btn-info my-4 my-md-3 myP">Submit</button>
                    </form>
                </div>
            </div>
<?php  
    }
?>
        </div>
    </div>
    <?php include "../../../view/footer.php"; ?>

    
    <?php echo $scripts; ?>
    <script src="../../../ajax/navbar.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>
