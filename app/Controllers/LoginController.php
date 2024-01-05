<?php

class LoginController extends Controller
{
    private LoginModel $loginModel;
    private SettingsModel $settingsModel;

    public function __construct()
    {
        // Load Model
        $this->loginModel = $this->loadModel("/LoginModel.php");

        // Load SettingsModel
        $this->settingsModel = $this->loadModel("/admin/SettingsModel");
    }

    //------------------------------------------------------------
    public function login(): void
    //------------------------------------------------------------
    {
        // Redirect if logged in
        Sessions::requireLogin(true);

        $data = [
            'title' => 'Login',
            'email' => '',
            'password' => '',
            'last_page' => Sessions::getLastPage(),
        ];

        $this->renderSimpleView("/login/login", $data);
    }


    //------------------------------------------------------------
    public function logout(): void
    //------------------------------------------------------------
    {
        $data["title"] = "Logout";

        Sessions::removeAllSessions();

        $this->renderSimpleView("/login/logout", $data);
    }

    //------------------------------------------------------------
    public function login_validate(): void
    //------------------------------------------------------------
    {
        Sessions::setHeaders();

        $postArray = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $output = "";

        if (empty($postArray["email"])) {
            $output .= "Please enter your Email";
        }
        if (filter_var($postArray["email"], FILTER_VALIDATE_EMAIL) === false) {
            $output .= "The email you entered was not valid.";
        }
        if (empty($postArray["password"])) {
            $output .= "Please enter your password";
        }

        $user = $this->loginModel->findUserByEmail($postArray['email']);
        // We check for array because: the $stmt->fetch() method is used to retrieve a single row(array assoc) from the result set, otherwise will return false, If a PDO query doesn't find any results
        if (is_array($user) && count($user) > 0) {
            // Validate Password
            if (password_verify($postArray["password"], $user["userPassword"])) {
                // Check if the user is Active
                if ($user["userStatus"] !== 1) {
                    $output .= "Your Account is not active, please contact support.";
                } else {
                    // Success =>> Create User Sessions
                    $this->create_user_session($user, $postArray);
                    // Success =>> Create User Settings Sessions
                    $settings = $this->settingsModel->getSettingsByUserId($user['userID']);
                    $this->create_settings_session($settings);

                    $output = "success";
                }
            } else {
                $output .= "The Email or Password you entered was not valid.";
            }
        } else {
            $output .= !$user ? "No account found with this email address." : $user;
        }

        echo json_encode(["message" => $output]);
        exit;
    }

    //------------------------------------------------------------
    private function create_user_session(array $user, array $postArray): void
    //------------------------------------------------------------
    {
        // Regenerates the session ID and creates a new session
        session_regenerate_id(true);

        // Save CSRF_TOKEN in the session
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        // Set User Session array
        $_SESSION['user'] = [
            'session_token' => session_id(),
            'id' => $user['userID'],
            'name' => $user['userName'],
            'email' => $user['userEmail'],
            'pic' => $user['userPicture'],
            'role' => $user['userRole'],
            'loggedin_time' => time(),
        ];

        if (isset($_COOKIE['last_login'])) {
            $_SESSION['user']['last_login'] = $_COOKIE['last_login'];
        }
        setcookie('last_login', time(), 2147483647);

        // Remember me checkBox
        if (!empty($postArray['loginRemember'])) {
            setcookie('email', $postArray['email'], time() + 30 * 24 * 60 * 60);
            // setcookie('password', $postArray['password'], time() + 30 * 24 * 60 * 60);
        } else {
            if (isset($_COOKIE["email"])) {
                setcookie("email", "", time() - 3600);
            }
            if (isset($_COOKIE["password"])) {
                // setcookie("password", "", time() - 3600);
            }
        }
    }

    //------------------------------------------------------------
    private function create_settings_session(array $settings): void
    //------------------------------------------------------------
    {
        // Set User Settings Session array
        $_SESSION['settings'] = [
            'settingID' => $settings['settingID'],
            'languageID' => $settings['languageID'],
            'settingTheme' => $settings['settingTheme'],
        ];
    }
}
