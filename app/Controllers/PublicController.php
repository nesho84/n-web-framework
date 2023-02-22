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
        // $data = getLanguage($_SESSION["language"], 111);
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
            $name = htmlspecialchars(strip_tags($_POST['name']));
            $company = htmlspecialchars(strip_tags($_POST['company']));
            $telefon = htmlspecialchars(strip_tags($_POST['telefon']));
            $email = $_POST['email'];
            $mailText = htmlspecialchars(strip_tags($_POST['subject']));
            $mailTitle = 'Neue Nachricht von ' . SITE_NAME . '';

            // Validation START
            if (strlen($name) < 1) {
                $validated = false;
                $output .= "&bull; Name darf nicht leer sein! <br>";
            }
            if (strlen($company) < 1) {
                $validated = false;
                $output .= "&bull; Unternehmen darf nicht leer sein!<br>";
            }
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $validated = false;
                $output .= "&bull; E-mail ist nicht gültig! <br>";
            }
            if (strlen($mailText) < 1) {
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

            ####### Google reCAPTCHA request START ###############
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

            if ($captcha_success->success == false) {
                $validated = false;
                $output .= "&bull; Bitte zeigen Sie, dass Sie kein Roboter sind, oder aktualisieren Sie die Seite und versuchen Sie es erneut! <br>";
            } // else if ($captcha_success->success == true) { This user is verified by recaptcha }
            ####### Google reCAPTCHA request END #####################

            if ($validated === true) {
                //############ Email Send START ##########################
                $mailText = "<h3>Neue Nachricht von " . SITE_NAME . "</h3>
                        <hr><br>
                        <strong>Name:</strong> $name <br><br>
                        <strong>Firma:</strong> $company <br><br>
                        <strong>Telefon:</strong> $telefon <br><br>
                        <strong>Email:</strong> $email <br><br>
                        <strong>Betreff:</strong> $mailText";

                if (sendEmail($email, $name, $mailTitle, $mailText, CONTACT_FORM_EMAIL) === true) {
                    $output .= 'success';
                }
                //############ Email Send END ###########################
            }

            // Return results
            echo $output;
            exit;
        }
    }
}
