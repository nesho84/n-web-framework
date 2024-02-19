<?php

namespace App\Core;

class Controller
{
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
    protected function renderAdminView(string|array $view_path, array $data = []): void
    //------------------------------------------------------------
    {
        // Global Session Data
        $data['sessions'] = Sessions::getSessionData();

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
