<?php

class Router
{
    private string $url;
    private static array $routes = [];
    private array $params = [];
    private string $controller_path;

    //------------------------------------------------------------
    public static function route(string $route, $callback): void
    //------------------------------------------------------------
    {
        if (is_string($callback)) {
            if (strpos($callback, '@')) {
                $exp = explode('@', $callback);
                self::$routes[] = [
                    "route" => $route,
                    "controller" => $exp[0],
                    "action" => $exp[1],
                ];
            }
        } else {
            self::$routes[] = [
                "route" => $route,
                "callback" => $callback,
            ];
        }
    }

    //------------------------------------------------------------
    public function run(): void
    //------------------------------------------------------------
    {
        // GET request url
        $this->url = isset($_GET['url']) ? '/' . rtrim($_GET['url'], "/") : '/';
        $this->url = filter_var($this->url, FILTER_SANITIZE_SPECIAL_CHARS);

        // Autoload - Routes files
        $path = ROUTES_PATH . '/*.php';
        if (count(glob($path)) > 0) {
            foreach (glob($path) as $files) {
                require_once $files;
            }
        } else {
            die("'Route files' not found /" . ROUTES_PATH);
        }

        $validRoute = $this->route_validate($this->url);

        if ($validRoute) {
            if (isset($validRoute['controller'])) {
                // Load Controller
                $this->controller_path = CONTROLLERS_PATH . "/" . $validRoute['controller'] . ".php";
                $this->loadController($validRoute['action']);
            } else {
                // Call the given callback function 
                echo call_user_func($validRoute['callback'], $this->url, $validRoute);
            }
        } else {
            // die("'Route' not found '" . $this->url . "'");
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
            //Include custom message page.
            require_once VIEWS_PATH . '/errors/404.php';
            exit;
        }
    }

    //------------------------------------------------------------
    private function route_validate(string $uri): array|bool
    //------------------------------------------------------------
    {
        // // Basic solution 1
        // $uri_parts = explode("/", $uri);
        // // Replace url parts to match the route
        // foreach ($uri_parts as $u) {
        //     // Route with {id} - Get the id from the url - (ex. post/33)
        //     if (is_numeric($u)) {
        //         // Set route params
        //         array_push($this->params, $u);
        //         // Replace it with {id} to match the route
        //         // ex. post/1 will be post/{id}
        //         $uri = str_replace($u, '{id}', $uri);
        //     }
        //     // Replace it with {slug} to match the route
        //     // ex. post/this-is-a-post with be post/{slug} and ignore about-us
        //     if (strpos($u, "-") && $u != "about-us") {
        //         // Set route params
        //         array_push($this->params, $u);
        //         // replace it with {slug} to match the route - (ex. post/{slug})
        //         $uri = str_replace($u, '{slug}', $uri);
        //     }
        // }
        // // Check if the route matches
        // foreach (self::$routes as $r) {
        //     if ($uri === $r['route']) {
        //         $r['params'] = $this->params;
        //         return $r;
        //     }
        // }

        // // Advanced solution 1
        // foreach (self::$routes as $r) {
        //     $route_pattern = preg_replace("/\{[^\}]+\}/", "([^/]+)", $r['route']);
        //     if (preg_match("#^$route_pattern$#", $uri, $matches)) {
        //         // Only if $matches is set
        //         if (count($matches) > 1) {
        //             // Because $matches[0] is the route and $matches[1] is the param
        //             array_push($this->params, $matches[1]);
        //         }
        //         return $r;
        //     }
        // }

        // Advanced solution 2 (supports {id} -> number and {slug} -> this-is-text)
        foreach (self::$routes as $r) {
            $route_pattern = preg_quote($r['route'], '#');
            if (preg_match('#^' . str_replace('\{id\}', '(\d+)', $route_pattern) . '$#', $uri, $matches)) {
                // {id} musst be a number
                if (isset($matches[1])) {
                    // Because $matches[0] is the route and $matches[1] is the param
                    array_push($this->params, $matches[1]);
                }
                return $r;
            } elseif (preg_match('#^' . str_replace('\{slug\}', '([\w-]+)', $route_pattern) . '$#', $uri, $matches)) {
                // {slug} a string with '-'
                if (isset($matches[1])) {
                    // Because $matches[0] is the route and $matches[1] is the param
                    array_push($this->params, $matches[1]);
                }
                return $r;
            }
        }

        return false;
    }

    //------------------------------------------------------------
    private function loadController(string $action): void
    //------------------------------------------------------------
    {
        if (file_exists($this->controller_path)) {
            require_once $this->controller_path;
            if (function_exists($action)) {
                if ($this->params) {
                    // Example: post/1 or post/edit/2
                    // Where 1 or 2 is the param 
                    // Example: function edit($param1){} or edit($param1, $param2){}
                    call_user_func_array($action, $this->params);
                } else {
                    // Example action = show
                    // In the function we get ex. function show(){}
                    call_user_func($action);
                }
            } else {
                die("Controller Function '" . $action . "' not found");
            }
        } else {
            die("'Controller' file not found '/" . $this->controller_path . "'");
        }
    }

    //------------------------------------------------------------
    public static function loadModel(string $model_path): void
    //------------------------------------------------------------
    {
        if (file_exists($model_path)) {
            require_once $model_path;
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
