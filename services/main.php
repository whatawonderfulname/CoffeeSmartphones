<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    function sendEmail($recipientEmail, $recipientName, $subject, $message, $alternativeMessage) {
        $mail = new PHPMailer(true); // true enables exceptions

        try {

            // mail parameters
            $mail->setFrom("alexander.schaedlich@gmail.com", "Coffee Team");
            $mail->addAddress($recipientEmail, $recipientName);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $message;
            $mail->AltBody = $alternativeMessage;

            // smtp parameters
            $mail->isSMTP();
            $mail->Host = "smtp.elasticemail.com";
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Username = "alexander.schaedlich@gmail.com";
            $mail->Password = "12359E29D17A4C805176438EC9E4020DCACA";
            $mail->Port = 2525;

            // send
            $mail->send();
            return true;
        } 

        // catch PHPMailer exception
        catch (Exception $e) {
            echo $e->errorMessage();
            return false;
        } 

        // catch PHP exception
        catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // stop all error reporting
    error_reporting(0); 
    
    // variables for the database connection
    $myHost = "localhost";
    $myUser = "root";
    $myPassword = "";
    $myDatabase = "fullstack111";

    // the absolute path of the root folder
    $myPath = "http://127.0.0.1/Full%20Stack%20Project/fs01-project5-common/alex1/";
    $scripts = "
        <script>
            let myPath = '{$myPath}';
        </script>
    ";

    // redirect to the index page if a user is not allowed to open the current page
    function goToIndex() {
        global $myPath;
        header("Location: {$myPath}index.php");
        die; // terminates the execution of the script
    }

    function userCheck() {
        if (! isset($_SESSION["user"])) {
            goToIndex();
        }
    }

    function adminCheck() {
        if (! isset($_SESSION["admin"])) {
            goToIndex();
        }
    }

    // convert applicable characters into html entities; both single and double quotes will be converted
    function escape($string) {
        return htmlentities($string, ENT_QUOTES); 
    }

    function sanitize($string) {
        $string = trim($string); // strips whitespace, tab characters etc. from the beginning and the end of a string
        $string = escape($string);
        return $string;
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email: The email address
     * @param string $size: Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $default: Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
     * @param string $rating: Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boolean $image: True to return a complete IMG tag False for just the URL
     * @param array $attributes: Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     */

    function getGravatar($email, $size = 160, $default = 'mp', $rating = 'g', $image = false, $attributes = array()) {
        $url = "https://www.gravatar.com/avatar/";
        $url .= md5(strtolower(trim($email))); // md5 hashing algorithm
        $url .= "?s={$size}&d={$default}&r={$rating}";

        if ($image) {
            $url = '<img src="' . $url . '"';

            foreach ($attributes as $key => $value) {
                $url .= ' ' . $key . '="' . $value . '"';
            }

            $url .= ' />';
        }

        return $url;
    }

    // give a numeric string a currency format
    function createCurrencyFormat($numericString) {
        if ($numericString != 0) {
            $formatter = new NumberFormatter("de_DE", NumberFormatter::CURRENCY);
            return $formatter->formatCurrency($numericString, "EUR");
        } else {
            return "";
        }
    }

    // create star elements
    function createStars($integer) {
        $result = '';
        if ($integer > 0) {
            for ($i = 0; $i < $integer; $i++) {
                $result .= '<span class="fullStar">&starf;</span>';
            }
            
            for ($i = 0; $i < 5 - $integer; $i++) {
                $result .= '<span class="emptyStar">&star;</span>';
            }
        } else {
            $result = '<span class="notRated">not rated</span>';
        }
        return $result;
    }
?>