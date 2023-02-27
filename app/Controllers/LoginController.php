<?php

class LoginController extends Controller
{
    private LoginModel $loginModel;

    public function __construct()
    {
        $this->loginModel = $this->loadModel("/LoginModel.php");
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
        ];

        $this->renderSimpleView("/login/login", $data);
    }


    //------------------------------------------------------------
    public function logout(): void
    //------------------------------------------------------------
    {
        $data["title"] = "Logout";

        // Unset all of the session variables
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        unset($_SESSION["user"]);

        // Finally, destroy the session
        session_destroy();

        $this->renderSimpleView("/login/logout", $data);
    }

    //------------------------------------------------------------
    public function login_validate(): void
    //------------------------------------------------------------
    {
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
                    // Success =>> Create all Sessions
                    $this->create_user_session($user, $postArray);
                    // $this->create_settings_session($settings, $postArray);

                    $output = "success";
                }
            } else {
                $output .= "The Email or Password you entered was not valid.";
            }
        } else {
            $output .= !$user ? "No account found with this email address." : $result;
        }

        echo $output;
        exit;
    }

    //------------------------------------------------------------
    private function create_user_session(array $user, array $postArray): void
    //------------------------------------------------------------
    {
        // Regenerates the session ID and creates a new session
        session_regenerate_id(true);

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
    private function create_settings_session(array $settings, array $postArray): void
    //------------------------------------------------------------
    {
        // // Set User Settings Session array
        // $_SESSION['setings'] = [
        //     'id' => $settings['settingsID'],
        //     'name' => $settings['userName'],
        //     'email' => $settings['userEmail'],
        // ];
    }
}
