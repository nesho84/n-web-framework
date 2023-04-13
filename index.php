<?php
// ---------------------------------------------------------
// --------------------- Startup files ---------------------
// ------------------ Order is important! ------------------
// ---------------------------------------------------------

// App Configuration
require_once __DIR__ . "/config/config.php";

// Common
require_once COMMON_PATH . "/Sessions.php";
require_once COMMON_PATH . "/FileHandler.php";
require_once COMMON_PATH . "/DataValidator.php";
require_once COMMON_PATH . "/EmailService.php";
require_once COMMON_PATH . "/utilities.php";
require_once COMMON_PATH . "/alerts.php";
require_once COMMON_PATH . "/templates.php";

// MySQL Connection
require_once CORE_PATH . "/Database.php";
// Routing
require_once CORE_PATH . "/Router.php";
// Base Controller
require_once CORE_PATH . "/Controller.php";
// Base Model
require_once CORE_PATH . "/Model.php";

// Initialize Router
$router = new Router;
$router->run();
