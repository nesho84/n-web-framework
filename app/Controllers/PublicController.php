<?php

class PublicController extends Controller
{
    private PublicModel $publicModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Load Model
        $this->publicModel = $this->loadModel("/PublicModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        // Get data from the Model
        $data['page'] = $this->publicModel->getActivePage('home');

        $this->renderPublicView("/public/index", $data);
    }

    //------------------------------------------------------------
    public function ajax_test(): void
    //------------------------------------------------------------
    {
        // Get data from the Model
        // $data = getLanguage($_SESSION["languageID"], 111);
        $data = $this->publicModel->getActivePage('about');

        echo json_encode($data);
    }

    //------------------------------------------------------------
    public function slug_test(string $slug): void
    //------------------------------------------------------------
    {
        // Get data from the Model
        // $data = ...
        echo "slug page<br>";
        echo "your requested slug: " . $slug;
    }

    //------------------------------------------------------------
    public function about_us(): void
    //------------------------------------------------------------
    {
        // Get data from the Model
        $data['page'] = $this->publicModel->getActivePage('about');

        $this->renderPublicView("/public/about_us", $data);
    }

    //------------------------------------------------------------
    public function contact(): void
    //------------------------------------------------------------
    {
        // Get data from the Model
        $data['page'] = $this->publicModel->getActivePage('contact');

        $this->renderPublicView("/public/contact/contact", $data);
    }

    //------------------------------------------------------------
    public function contact_validate(): void
    //------------------------------------------------------------
    {
        $validated = true;
        $output = '';

        if (isset($_POST['submited'])) {
            $fromName = htmlspecialchars(strip_tags($_POST['name']));
            $company = htmlspecialchars(strip_tags($_POST['company']));
            $telefon = htmlspecialchars(strip_tags($_POST['telefon']));
            $from = $_POST['email'];
            $body = htmlspecialchars(strip_tags($_POST['subject']));
            $subject = 'Neue Nachricht von ' . SITE_NAME . '';

            // Validation START
            if (strlen($fromName) < 1) {
                $validated = false;
                $output .= "&bull; Name darf nicht leer sein! <br>";
            }
            if (strlen($company) < 1) {
                $validated = false;
                $output .= "&bull; Unternehmen darf nicht leer sein!<br>";
            }
            if (filter_var($from, FILTER_VALIDATE_EMAIL) === false) {
                $validated = false;
                $output .= "&bull; E-mail ist nicht gültig! <br>";
            }
            if (strlen($body) < 1) {
                $validated = false;
                $output .= "&bull; Betreff darf nicht leer sein! <br>";
            }
            if (isset($_POST["policy"]) && $_POST["policy"] == "ok") {
                $policy = $_POST["policy"];
            } else {
                $validated = false;
                $output .= "&bull; Bitte akzeptiere unseren datenschutzhinweis.<br>";
            }
            // Validation END

            //############ Google reCAPTCHA request START ###############
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array(
                'secret' => '6LdEqsEfAAAAAE8NM57YO7ZRIHFOqEf-cVayDyBx',
                'response' => $_POST['g-recaptcha-response'],
            );
            $options = array(
                'http' => array(
                    'header' => "Content-Type: application/x-www-form-urlencoded",
                    'method' => 'POST',
                    'content' => http_build_query($data),
                ),
            );
            $context = stream_context_create($options);
            $verify = file_get_contents($url, false, $context);
            $captcha_success = json_decode($verify);

            // // Commented for development => get a captcha key and uncomment it in production
            // if ($captcha_success->success == false) {
            //     $validated = false;
            //     $output .= "&bull; Bitte zeigen Sie, dass Sie kein Roboter sind, oder aktualisieren Sie die Seite und versuchen Sie es erneut! <br>";
            // } 

            // else if ($captcha_success->success == true) { This user is verified by recaptcha }
            //############ Google reCAPTCHA request END #####################

            if ($validated === true) {
                //############ Email Send START ##########################
                $body = "<h3>Neue Nachricht von " . SITE_NAME . "</h3>
                <hr><br>
                <strong>Name:</strong> $fromName <br><br>
                <strong>Firma:</strong> $company <br><br>
                <strong>Telefon:</strong> $telefon <br><br>
                <strong>Email:</strong> $from <br><br>
                <strong>Betreff:</strong> $body";

                try {
                    EmailService::send([
                        'host' => 'smtp.gmail.com',
                        'port' => 587,
                        'username' => 'example@gmail.com',
                        'password' => 'password',
                        'from' => $from,
                        'fromName' => $fromName,
                        'to' => [CONTACT_FORM_EMAIL, 'recipient1@example.com', 'recipient2@example.com', 'recipient3@example.com'],
                        'cc' => ['ccrecipient1@example.com', 'ccrecipient2@example.com'],
                        'bcc' => ['bccrecipient1@example.com', 'bccrecipient2@example.com'],
                        'subject' => $subject,
                        'body' => $body,
                        'isHtml' => true,
                        'attachments' => [
                            // [
                            //     'path' => '/path/to/attachment1.pdf',
                            //     'name' => 'attachment1.pdf',
                            //     'encoding' => 'base64',
                            //     'type' => 'application/pdf'
                            // ],
                            // [
                            //     'path' => '/path/to/attachment2.txt',
                            //     'name' => 'attachment2.txt',
                            //     'encoding' => 'base64',
                            //     'type' => 'text/plain'
                            // ]
                        ],
                    ]);
                    // echo 'Email sent successfully.';
                    $output .= 'success';
                } catch (Exception $e) {
                    $output = $e->getMessage();
                }
                //############ Email Send END ###########################
            }

            // Return results
            echo $output;
            exit;
        }
    }
}
