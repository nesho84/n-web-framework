<?php

class Sessions
{
    // The static instance variable stores a reference to the single instance of the class.
    protected static self $instance;

    /**
     * This method creates a new instance of the class if one does not already exist, and returns it.
     * @return self the current instance of the class.
     */
    public static function getInstance(): self
    {
        // If the instance variable is not set, create a new instance of the class.
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        // Return the instance variable.
        return self::$instance;
    }

    /**
     * Redirects to Login Page, if User is not Logged In! 
     * @param bool $isLoginPage redirect from login page if already logged in
     * @return void
     */
    //------------------------------------------------------------
    public static function requireLogin(bool $isLoginPage = false): void
    //------------------------------------------------------------
    {
        // TODO: Check this user id session against the database to ensure that the user is still valid and exist, this will ensure a secure way of handling sessions and user validation.

        if (!isset($_SESSION['user']["id"]) || empty($_SESSION['user']["id"])) {
            if ($isLoginPage === false) {
                // User is not logged in, redirect to login page
                redirect(APPURL . "/login");
                exit;
            }
        }

        // Login Page: if User is logged in, redirect to Admin page
        if (isset($_SESSION['user']["id"]) || !empty($_SESSION['user']["id"])) {
            if ($isLoginPage === true) {
                redirect(APPURL . "/admin");
                exit;
            }
        }

        // Session expire 
        self::sessionExpire();

        // // Set last visited page
        // self::getLastPage();
    }

    //------------------------------------------------------------
    private static function sessionExpire(): void
    //------------------------------------------------------------
    {
        if (isset($_SESSION['user']['loggedin_time'])) {
            if (((time() - $_SESSION['user']['loggedin_time']) > SESSION_DURATION)) {
                // // @TODO: Set the last_page cookie
                // self::setLastPageCookie();

                // Show the alert (sweetalert2)
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'info',
                                title: 'Oops...',
                                text: 'Your session has expired!',
                                footer: '<small>You will be redirected to the Login page.</small>'
                            }).then((result) => {
                                if (result) {
                                    window.location.replace('" . APPURL . "/logout?expire=1');
                                }
                            });
                        });
                    </script>";
            }
        }
    }

    //------------------------------------------------------------
    public static function removeAllSessions(): void
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
        unset($_SESSION['csrf_token']);

        // regenerate session ID and remove any active sessions
        session_unset();
        session_destroy();
        session_write_close();
    }

    //------------------------------------------------------------
    private static function getPage(): string
    //------------------------------------------------------------
    {
        return isset($_GET['url']) ? APPURL . '/' . $_GET['url'] : '/';
    }

    //------------------------------------------------------------
    public static function getLastPage(): string|null
    //------------------------------------------------------------
    {
        // Get page url 
        $page = self::getPage();

        // Check if the user is logged in
        if (isset($_SESSION['user']["id"]) && $_SESSION['user']["id"]) {
            // Save the current page URL in the session
            $_SESSION['last_page'] = htmlspecialchars($page, ENT_QUOTES, 'UTF-8');
        } else {
            // Try to get the last visited page URL from the session
            if (isset($_SESSION['last_page'])) {
                $last_page = $_SESSION['last_page'];
            } else {
                // Try to get the last visited page URL from the cookie
                if (isset($_COOKIE['last_page'])) {
                    $last_page = $_COOKIE['last_page'];
                } else {
                    $last_page = APPURL . "/login";
                }
            }

            // Validate the last visited page URL
            if (filter_var($last_page, FILTER_VALIDATE_URL) === false) {
                $last_page = APPURL . "/login";
            }

            return $last_page;
        }

        // Return the current page URL
        return htmlspecialchars($page, ENT_QUOTES, 'UTF-8');
    }

    //------------------------------------------------------------
    public static function setLastPageCookie(): void
    //------------------------------------------------------------
    {
        // Get page url 
        $page = self::getPage();

        setcookie('last_page', htmlspecialchars($page, ENT_QUOTES, 'UTF-8'), time() + COOKIE_DURATION, '/');
    }

    /**
     * This method sets the required headers for the session
     * @return self the current instance of the class.
     */
    //------------------------------------------------------------
    public static function setHeaders(): self
    //------------------------------------------------------------
    {
        header("Content-Type: application/json");
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: DENY");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: same-origin");
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

        // Return the current instance of the class.
        return self::getInstance();
    }

    /**
     * Validates CSRF Token sent by header or from the form input
     * @param string $csrfToken [optional]
     * @return self the current instance of the class.
     */
    //------------------------------------------------------------
    public static function requireCSRF(string $csrfToken = ""): self
    //------------------------------------------------------------
    {
        // Validate CSRF token
        if ($csrfToken !== "") {
            if ($csrfToken !== $_SESSION['csrf_token']) {
                http_response_code(419);
                echo json_encode([
                    "status" => "error",
                    'message' => 'Invalid or missing CSRF token'
                ]);
                exit();
            }
        } else {
            $csrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
            if ($csrfToken !== $_SESSION['csrf_token']) {
                http_response_code(419);
                echo json_encode([
                    "status" => "error",
                    'message' => 'Invalid or missing CSRF token'
                ]);
                exit();
            }
        }

        return self::getInstance();
    }
}
