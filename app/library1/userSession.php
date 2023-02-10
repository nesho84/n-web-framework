<?php

/**
 * Redirects to Login Page, if User is not Logged In! 
 * @param bool $isLoginPage redirect from login page if already logged in
 */
//------------------------------------------------------------
function IsUserLoggedIn(bool $isLoginPage = false): void
//------------------------------------------------------------
{
    // TODO: Check this user id session against the database to ensure that the user is still valid and exist, this will ensure a secure way of handling sessions and user validation.

    if (!isset($_SESSION['user']["id"]) || empty($_SESSION['user']["id"])) {
        if ($isLoginPage === false) {
            // User is not logged in, redirect to login page
            header("Location:" . APPURL . "/login");
            exit;
        }
    }

    // Login Page: if User is logged in, redirect to Admin page
    if (isset($_SESSION['user']["id"]) || !empty($_SESSION['user']["id"])) {
        if ($isLoginPage === true) {
            header("Location:" . APPURL . "/admin");
            exit;
        }
    }
}
