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

        // Session expire 
        self::sessionExpire();
    }

    //------------------------------------------------------------
    private static function sessionExpire()
    //------------------------------------------------------------
    {
        if (isset($_SESSION['user']['loggedin_time']) and isset($_SESSION['user']['id'])) {
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
}
