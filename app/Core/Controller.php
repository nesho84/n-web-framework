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
    protected function renderAdminView(string|array $view_path, array $data = []): void
    //------------------------------------------------------------
    {
        require_once VIEWS_PATH . "/admin/includes/header.php";

        $view_paths = is_array($view_path) ? $view_path : [$view_path];
        foreach ($view_paths as $view_path) {
            // Set full view path
            $view = VIEWS_PATH . $view_path;
            // Set .php extenstion, if is not set
            if (pathinfo($view_path, PATHINFO_EXTENSION) === "") {
                $view .= ".php";
            }
            if (file_exists($view)) {
                require_once $view;
            } else {
                die("'View' file not found '" . $view . "'");
            }
        }

        require_once VIEWS_PATH . "/admin/includes/footer.php";
    }

    //------------------------------------------------------------
    protected function renderSimpleView(string|array $view_path, array $data = []): void
    //------------------------------------------------------------
    {
        $view_paths = is_array($view_path) ? $view_path : [$view_path];
        foreach ($view_paths as $view_path) {
            // Set full view path
            $view = VIEWS_PATH . $view_path;
            // Set .php extenstion, if is not set
            if (pathinfo($view_path, PATHINFO_EXTENSION) === "") {
                $view .= ".php";
            }
            if (file_exists($view)) {
                require_once $view;
            } else {
                die("'View' file not found '" . $view . "'");
            }
        }
    }

    //------------------------------------------------------------
    protected function renderPublicView(string|array $view_path, array $data = []): void
    //------------------------------------------------------------
    {
        require_once VIEWS_PATH . "/public/includes/header.php";

        $view_paths = is_array($view_path) ? $view_path : [$view_path];
        foreach ($view_paths as $view_path) {
            // Set full view path
            $view = VIEWS_PATH . $view_path;
            // Set .php extenstion, if is not set
            if (pathinfo($view_path, PATHINFO_EXTENSION) === "") {
                $view .= ".php";
            }
            if (file_exists($view)) {
                require_once $view;
            } else {
                die("'View' file not found '" . $view . "'");
            }
        }

        require_once VIEWS_PATH . "/public/includes/footer.php";
    }

    // protected function renderView(string|array $view_path, array $data = []): void
    // {
    //     $content = '';
    //     foreach ($view_paths as $view_path) {
    //         $view = VIEWS_PATH . $view_path;
    //         if (pathinfo($view_path, PATHINFO_EXTENSION) === "") {
    //             $view .= ".php";
    //         }
    //         if (file_exists($view)) {
    //             ob_start();
    //             require_once $view;
    //             $content .= ob_get_clean();
    //         } else {
    //             die("'View' file not found '" . $view . "'");
    //         }
    //     }
    //     require_once VIEWS_PATH . "/admin/includes/header.php";
    //     echo $content;
    //     require_once VIEWS_PATH . "/admin/includes/footer.php";
    // }
}
