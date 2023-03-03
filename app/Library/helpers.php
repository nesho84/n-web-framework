<?php

/**
 * Prints array in nicer format
 * @param array $var array to print
 */
//------------------------------------------------------------
function dd(array $var): void
//------------------------------------------------------------
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    die;
}

/**
 * Prints array in nicer format
 * @param array $var array to print
 */
//------------------------------------------------------------
function dd_print(array $var): void
//------------------------------------------------------------
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

/**
 * Get's the current page(url) from the url
 * @param array $url url of the page
 * @return void if the $url matches
 */
//------------------------------------------------------------
function activePage(array $url): void
//------------------------------------------------------------
{
    // Get page url 
    $page = isset($_GET['url']) ? $_GET['url'] : '/';
    $page = filter_var($page, FILTER_SANITIZE_URL);

    $page_parts = explode("/", $page);

    foreach ($page_parts as $u) {
        // Route with {id} - Get the id from the url - (ex. post/33)
        if (is_numeric($u)) {
            // replace it with {id} to match the route - (ex. post/{id})
            $page = str_replace($u, '{id}', $page);
        }
        // Route with {slug} - Get the url slug - (ex. post/this-is-a-post) but ignore about-us page
        if (strpos($u, "-") && $u != "about-us") {
            // replace it with {slug} to match the route - (ex. post/{slug})
            $page = str_replace($u, '{slug}', $page);
        }
    }

    foreach ($url as $u) {
        if ($u === $page) {
            echo 'active';
        }
    }
}

/**
 * Force redirect to ignore php error 'headers already sent...'
 * @param string $url of the page
 * @return void
 */
//------------------------------------------------------------
function redirect(string $url): void
//------------------------------------------------------------
{
    header("Location: $url");
}

/**
 * Force redirect to ignore php error 'headers already sent...'
 * @param string $url of the page
 * @return void
 */
//------------------------------------------------------------
function forceRedirect(string $url): void
//------------------------------------------------------------
{
    if (headers_sent()) {
        echo ("<script>location.href='$url'</script>");
    } else {
        header("Location: $url");
    }
}

/**
 * helper Function to send html email
 * @param string $From, $FromName, $mailTitle, $mailText,... 
 * @return string if the email was sent
 */
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//------------------------------------------------------------
function sendEmail(string $From, string $FromName, string $mailTitle, string $mailText, string $To, $CC = '', $BCC = '', $Attachments = ''): bool|string
//------------------------------------------------------------
{
    require LIBRARY_PATH . '/PHPMailer-master/src/Exception.php';
    require LIBRARY_PATH . '/PHPMailer-master/src/PHPMailer.php';
    require LIBRARY_PATH . '/PHPMailer-master/src/SMTP.php';

    $mail = new PHPMailer(true);
    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        // $mail->isSMTP(); //Send using SMTP
        // $mail->Host       = 'smtp.gmail.com'; //Set the SMTP server to send through
        // $mail->SMTPAuth   = true; //Enable SMTP authentication
        $mail->Username   = $To; //SMTP username
        // $mail->Password   = 'secret'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        // $mail->Port       = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($From, $FromName);
        $mail->AddAddress($To);
        $mail->AddReplyTo($From);
        // $mail->addCC($CC);
        // $mail->addBCC($BCC);

        // //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);
        $mail->Subject = utf8_decode($mailTitle);
        $mail->Body = utf8_decode($mailText);
        $mail->AltBody = strip_tags(utf8_decode($mailText));

        $mail->Send();

        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
