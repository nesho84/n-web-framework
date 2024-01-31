<?php
// ---------------------------------------------------------
// --------------------- Startup files ---------------------
// ------------------ Order is important! ------------------
// ---------------------------------------------------------

// Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Router;

// App Configuration
require_once __DIR__ . "/config/config.php";

// Common
require_once COMMON_PATH . "/utilities.php";
require_once COMMON_PATH . "/alerts.php";
require_once COMMON_PATH . "/templates.php";

// Initialize Router
$router = new Router;
$router->run();
// (new Router)->run();
