<?php

class Router
{
    private string $url;
    private static array $routes = [];
    private array $params = [];
    private string $controller_path;
    private string $controller_name;

    //------------------------------------------------------------
    public static function add(string $route, $callback): void
    //------------------------------------------------------------
    {
        if (is_string($callback)) {
            if (strpos($callback, '@')) {
                $exp = explode('@', $callback);
                self::$routes[] = [
                    "route" => $route,
                    "controller_name" => basename(explode('@', $callback)[0]),
                    "controller_path" => $exp[0],
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

        $validRoute = $this->validate($this->url);

        if ($validRoute) {
            $cf = $validRoute['controller_path'];
            if (isset($cf)) {
                // Load Controller
                $this->controller_name = $validRoute['controller_name'];
                $this->controller_path = CONTROLLERS_PATH . "/" . $cf . ".php";
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
    private function validate(string $uri): array|bool
    //------------------------------------------------------------
    {
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
            $controller_object = null;

            if (class_exists($this->controller_name)) {
                // Initialize Controller
                $controller_object = new $this->controller_name();
            } else {
                echo "Controller class $controller not found";
            }

            if (method_exists($controller_object, $action)) {
                if ($this->params) {
                    // Example: post/1 or post/edit/2
                    // Where 1 or 2 is the param 
                    // Example: function edit($param1){} or edit($param1, $param2){}
                    call_user_func_array($action, $this->params);
                } else {
                    // Example action = show
                    // In the function we get ex. function show(){}
                    call_user_func([$controller_object, $action]);
                }
            } else {
                die("Controller Function '" . $action . "' not found");
            }
        } else {
            die("'Controller' file not found '/" . $this->controller_path . "'");
        }
    }
}
