<?php

class Controller
{
    //------------------------------------------------------------
    public static function loadModel(string $model_path, string $model): mixed
    //------------------------------------------------------------
    {
        if (file_exists($model_path)) {
            require_once $model_path;

            if (class_exists($model)) {
                return new $model();
            } else {
                echo "Model class $model_path not found";
            }
        } else {
            die("'Model' file not found '/" . $model_path . "'");
        }
    }

    //------------------------------------------------------------
    public static function renderView(string $view_path, array $data = []): void
    //------------------------------------------------------------
    {
        if (file_exists($view_path)) {
            require_once VIEWS_PATH . "/public/includes/header.php";
            require_once $view_path;
            require_once VIEWS_PATH . "/public/includes/footer.php";
        } else {
            die("'View' file not found '/" . $view_path . "'");
        }
    }

    //------------------------------------------------------------
    public static function renderSimpleView(string $view_path, array $data = []): void
    //------------------------------------------------------------
    {
        if (file_exists($view_path)) {
            require_once $view_path;
        } else {
            die("'View' file not found '/" . $view_path . "'");
        }
    }

    //------------------------------------------------------------
    public static function renderAdminView(string $view_path, array $data = []): void
    //------------------------------------------------------------
    {
        if (file_exists($view_path)) {
            require_once VIEWS_PATH . "/admin/includes/header.php";
            require_once $view_path;
            require_once VIEWS_PATH . "/admin/includes/footer.php";
        } else {
            die("'View' file not found '/" . $view_path . "'");
        }
    }
}
