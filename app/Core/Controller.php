<?php

class Controller
{
    //------------------------------------------------------------
    protected function loadModel(string $model_path): ?object
    //------------------------------------------------------------
    {
        if (file_exists($model_path)) {
            require_once $model_path;

            $model = basename($model_path, '.php');

            if (class_exists($model)) {
                return new $model();
            } else {
                die("Model class $model not found");
            }
        } else {
            die("'Model' file not found '/" . $model_path . "'");
        }
    }

    //------------------------------------------------------------
    protected function renderView(string $view_path, array $data = []): void
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
    protected function renderSimpleView(string $view_path, array $data = []): void
    //------------------------------------------------------------
    {
        if (file_exists($view_path)) {
            require_once $view_path;
        } else {
            die("'View' file not found '/" . $view_path . "'");
        }
    }

    //------------------------------------------------------------
    protected function renderAdminView(string $view_path, array $data = []): void
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
