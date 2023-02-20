<?php

class Controller
{
    //------------------------------------------------------------
    protected function loadModel(string $model_path): ?object
    //------------------------------------------------------------
    {
        // Set full Model path
        $model = MODELS_PATH . $model_path;

        // Set .php extenstion, if is not set
        if (pathinfo($model_path, PATHINFO_EXTENSION) === "") {
            $model = MODELS_PATH . $model_path . ".php";
        }

        if (file_exists($model)) {
            require_once $model;

            $model_class = basename($model_path, '.php');
            if (class_exists($model_class)) {
                return new $model_class();
            } else {
                die("Model class $model_class not found");
            }
        } else {
            die("'Model' file not found '" . $model . "'");
        }
    }

    //------------------------------------------------------------
    protected function renderView(string $view_path, array $data = []): void
    //------------------------------------------------------------
    {
        // Set full view path
        $view = VIEWS_PATH . $view_path;

        // Set .php extenstion, if is not set
        if (pathinfo($view_path, PATHINFO_EXTENSION) === "") {
            $view = VIEWS_PATH . $view_path . ".php";
        }

        if (file_exists($view)) {
            require_once VIEWS_PATH . "/public/includes/header.php";
            require_once $view;
            require_once VIEWS_PATH . "/public/includes/footer.php";
        } else {
            die("'View' file not found '" . $view . "'");
        }
    }

    //------------------------------------------------------------
    protected function renderSimpleView(string $view_path, array $data = []): void
    //------------------------------------------------------------
    {
        // Set full view path
        $view = VIEWS_PATH . $view_path;

        // Set .php extenstion, if is not set
        if (pathinfo($view_path, PATHINFO_EXTENSION) === "") {
            $view = VIEWS_PATH . $view_path . ".php";
        }

        if (file_exists($view)) {
            require_once $view;
        } else {
            die("'View' file not found '" . $view . "'");
        }
    }

    //------------------------------------------------------------
    protected function renderAdminView(string $view_path, array $data = []): void
    //------------------------------------------------------------
    {
        // Set full view path
        $view = VIEWS_PATH . $view_path;

        // Set .php extenstion, if is not set
        if (pathinfo($view_path, PATHINFO_EXTENSION) === "") {
            $view = VIEWS_PATH . $view_path . ".php";
        }

        if (file_exists($view)) {
            require_once VIEWS_PATH . "/admin/includes/header.php";
            require_once $view;
            require_once VIEWS_PATH . "/admin/includes/footer.php";
        } else {
            die("'View' file not found '" . $view . "'");
        }
    }

    /**
     * Redirects to Login Page, if User is not Logged In! 
     * @param bool $isLoginPage redirect from login page if already logged in
     * @return void
     */
    //------------------------------------------------------------
    function requireLogin(bool $isLoginPage = false): void
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
    }
}
