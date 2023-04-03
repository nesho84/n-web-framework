<?php
// ---------------------------------------------------------
// --------------------- Startup files ---------------------
// ------------------ Order is important! ------------------
// ---------------------------------------------------------

// App Configuration
require_once __DIR__ . "/config/config.php";

// MySQL Connection
require_once CORE_PATH . "/Database.php";
// Routing
require_once CORE_PATH . "/Router.php";
// Base Controller
require_once CORE_PATH . "/Controller.php";
// Base Model
require_once CORE_PATH . "/Model.php";

// Helpers
require_once HELPERS_PATH . "/Sessions.php";
require_once HELPERS_PATH . "/FileHandler.php";
require_once HELPERS_PATH . "/helpers.php";
require_once HELPERS_PATH . "/components.php";
require_once HELPERS_PATH . "/flashMessages.php";

// Library

// Initialize Router
$router = new Router;
$router->run();
