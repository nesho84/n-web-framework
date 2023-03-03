<?php

class Sessions
{
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

        // Set last visited page
        self::getLastPage();

        // Session expire 
        self::sessionExpire();
    }

    //------------------------------------------------------------
    private static function sessionExpire(): void
    //------------------------------------------------------------
    {
        if (isset($_SESSION['user']['loggedin_time'])) {
            if (((time() - $_SESSION['user']['loggedin_time']) > SESSION_DURATION)) {
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
                                    window.location.replace('" . APPURL . "/logout');
                                }
                            });
                        });
                    </script>";
            }
        }
    }

    /**
     * Redirects to Login Page, if User is not Logged In! 
     * string|null, which means it can return a string (the last page URL), or null (if the user is logged in and the function only saves the current page URL in the session).
     * @return string|null
     */
    //------------------------------------------------------------
    public static function getLastPage(): string|null
    //------------------------------------------------------------
    {
        // Get page url 
        $page = isset($_GET['url']) ? APPURL . '/' . $_GET['url'] : '/';

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

        // Set the last_page cookie if user is logged out
        setcookie('last_page', htmlspecialchars($page, ENT_QUOTES, 'UTF-8'), time() + COOKIE_DURATION, '/');

        // Return the current page URL
        return htmlspecialchars($page, ENT_QUOTES, 'UTF-8');
    }
}
