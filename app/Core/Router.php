<?php

class Router
{
    private string $url;
    private static array $routes = [];
    private array $params = [];
    private string $controller_path;
    private string $controller_class;
    private string $action;

    //------------------------------------------------------------
    public static function get(string $route, callable|string $callback, array $middleware = []): void
    //------------------------------------------------------------
    {
        self::add('GET', $route, $callback, $middleware);
    }

    //------------------------------------------------------------
    public static function post($route, callable|string $callback, array $middleware = []): void
    //------------------------------------------------------------
    {
        self::add('POST', $route, $callback, $middleware);
    }

    //------------------------------------------------------------
    private static function add(string $method, string $route, callable|string $callback, array $middleware = []): void
    //------------------------------------------------------------
    {
        if (is_string($callback)) {
            if (strpos($callback, '@')) {
                $exp = explode('@', $callback);
                self::$routes[] = [
                    'method' => $method,
                    'route' => $route,
                    'controller' => $exp[0],
                    'action' => $exp[1],
                    'middleware' => $middleware,
                ];
            }
        } else {
            self::$routes[] = [
                'method' => $method,
                'route' => $route,
                'callback' => $callback,
            ];
        }
    }

    //------------------------------------------------------------
    public function run(): void
    //------------------------------------------------------------
    {
        // GET requested url
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

        // Validate Routes
        $validRoute = $this->validate($this->url);
        if ($validRoute) {
            // Call any stored middlewares
            if (isset($validRoute['middleware'])) {
                foreach ($validRoute['middleware'] as $middleware) {
                    (new Auth)->handle($middleware);
                }
            }

            // First check server request method
            $mt = $validRoute['method'] ?? null;
            if ($_SERVER['REQUEST_METHOD'] !== $mt) {
                // This is not a POST request, send a 405 error
                http_response_code(405);
                header('Allow: ' . $mt);
                echo json_encode(["message" => "Request method '" . $_SERVER['REQUEST_METHOD'] . "' not supported"]);
                exit;
            }
            // Load Controller
            $ct = $validRoute['controller'] ?? null;
            if (isset($ct)) {
                $this->controller_path = CONTROLLERS_PATH . "/" . $ct . ".php";
                $this->controller_class = basename($this->controller_path, '.php');
                $this->action = $validRoute['action'];
                $this->loadController();
            } else {
                call_user_func($validRoute['callback'], $this->url, $validRoute);
            }
        } else {
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
            require_once VIEWS_PATH . '/errors/404.php';
            exit;
        }
    }

    //------------------------------------------------------------
    private function validate(string $uri): array|bool
    //------------------------------------------------------------
    {
        // New Aproach 2024
        foreach (self::$routes as $route) {
            $route_pattern = preg_quote($route['route'], '#');
            $route_pattern = preg_replace('#\\\{(.+?)\\\}#', '(.+)', $route_pattern);

            if (preg_match('#^' . $route_pattern . '$#', $uri, $matches)) {
                if (isset($matches[1])) {
                    // $matches[0] is the route and $matches[1] is the param
                    array_push($this->params, $matches[1]);
                }
                return $route;
            }
        }

        return false;
    }

    //------------------------------------------------------------
    private function loadController(): void
    //------------------------------------------------------------
    {
        if (file_exists($this->controller_path)) {
            require_once $this->controller_path;

            $controller_object = null;

            if (class_exists($this->controller_class)) {
                // Initialize Controller
                $controller_object = new $this->controller_class();
            } else {
                die("Controller class $this->controller_class not found");
            }

            if (method_exists($controller_object, $this->action)) {
                // Call controller functions with or without params
                if ($this->params) {
                    // Example: post/1 or post/edit/2
                    // Where 1 or 2 is the param
                    // Example: function edit($param1){} or edit($param1, $param2){}
                    call_user_func_array([$controller_object, $this->action], $this->params);
                } else {
                    // Example action = show
                    // In the function we get ex. function show(){}
                    call_user_func([$controller_object, $this->action]);
                }
            } else {
                die("Controller Function '" . $this->action . "' not found");
            }
        } else {
            die("'Controller' file not found '/" . $this->controller_path . "'");
        }
    }
}
