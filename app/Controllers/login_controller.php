<?php

// Load Model
App::loadModel(MODELS_PATH . "/login_model.php");

//------------------------------------------------------------
function login(): void
//------------------------------------------------------------
{
    // redirect to home if logged in
    if (isset($_SESSION["userID"])) {
        header('Location:' . APPURL . '/admin');
        exit;
    }

    $data['title'] = "Login";
    $data['email'] = "";
    $data['password'] = "";

    App::renderSimpleView(VIEWS_PATH . "/login/login.php", $data);
}

//------------------------------------------------------------
function logout(): void
//------------------------------------------------------------
{
    unset($_SESSION["userID"]);
    unset($_SESSION["userEmail"]);
    unset($_SESSION["userName"]);
    unset($_SESSION["userRole"]);
    unset($_SESSION['last_visit']);
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

        $user = findUserByEmail($postArray['email']);

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

        if ($user) {
            // Validate Password
            if (password_verify($postArray["password"], $user["userPassword"])) {
                create_user_session($user, $postArray);
                $output = "success";
            } else {
                $output .= "The Email or Password you entered was not valid.";
            }
        } else {
            $output .= "No account found with this email address.";
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
    // Set sessions
    $_SESSION['userID'] = $user['userID'];
    $_SESSION['userName'] = $user['userName'];
    $_SESSION['userEmail'] = $user['userEmail'];
    $_SESSION['userPicture'] = $user['userPicture'];
    $_SESSION['userRole'] = $user['userRole'];

    if (isset($_COOKIE['last_login'])) {
        $_SESSION['last_login'] = $_COOKIE['last_login'];
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
