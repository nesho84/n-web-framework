<?php

// Load Model
App::loadModel(MODELS_PATH . "/login_model.php");

//------------------------------------------------------------
function login(): void
//------------------------------------------------------------
{
    IsUserLoggedIn(true);

    $data['title'] = "Login";
    $data['email'] = "";
    $data['password'] = "";

    App::renderSimpleView(VIEWS_PATH . "/login/login.php", $data);
}

//------------------------------------------------------------
function logout(): void
//------------------------------------------------------------
{
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

    $data["title"] = "Logout";

    App::renderSimpleView(VIEWS_PATH . "/login/logout.php", $data);
}

//------------------------------------------------------------
function login_validate(): void
//------------------------------------------------------------
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $postArray = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $result = findUserByEmail($postArray['email']);

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

        // We check for array because: the $stmt->fetch() method is used to retrieve a single row(array assoc) from the result set, otherwise will return false, If a PDO query doesn't find any results 
        if (is_array($result)) {
            // Validate Password
            if (password_verify($postArray["password"], $result["userPassword"])) {
                // Create all needed Session
                create_user_session($result, $postArray);
                $output = "success";
            } else {
                $output .= "The Email or Password you entered was not valid.";
            }
        } else {
            $output .= $result;
        }

        echo $output;
        exit;
    } else {
        header('Location:' . APPURL . '/login');
        exit;
    }
}

//------------------------------------------------------------
function create_user_session(array $user, array $postArray): void
//------------------------------------------------------------
{
    // Regenerates the session ID and creates a new session
    session_regenerate_id(true);

    // Set User Session array
    $_SESSION['user'] = [
        'id' => $user['userID'],
        'name' => $user['userName'],
        'email' => $user['userEmail'],
        'pic' => $user['userPicture'],
        'role' => $user['userRole'],
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
