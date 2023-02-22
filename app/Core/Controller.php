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
            require_once $view;
        } else {
            die("'View' file not found '" . $view . "'");
        }
    }

    //------------------------------------------------------------
    protected function renderPublicView(string $view_path, array $data = []): void
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
    protected function renderAdminView(string|array $view_path, array $data = []): void
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

    //------------------------------------------------------------
    protected function includeHeader(string $section, array $data = []): void
    //------------------------------------------------------------
    {
        // Set full header path
        $header = VIEWS_PATH . "/$section/includes/header.php";;

        if (file_exists($header)) {
            require_once $header;
        } else {
            die("'Header' file not found '" . $header . "'");
        }
    }

    //------------------------------------------------------------
    protected function includeFooter(string $section, array $data = []): void
    //------------------------------------------------------------
    {
        // Set full header path
        $footer = VIEWS_PATH . "/$section/includes/footer.php";;

        if (file_exists($footer)) {
            require_once $footer;
        } else {
            die("'footer' file not found '" . $footer . "'");
        }
    }
}
