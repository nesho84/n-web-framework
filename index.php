<?php
// ---------------------------------------------------------
// --------------------- Startup files ---------------------
// ------------------ Order is important! ------------------
// ---------------------------------------------------------

// Global settings
require_once __DIR__ . "/config/settings.php";

// MySQL Connection
require_once CORE_PATH . "/Database.php";

// Routing - Main Controller
require_once CORE_PATH . "/Router.php";

// Core Library
require_once LIBRARY_PATH . "/helpers.php";
require_once LIBRARY_PATH . "/userSession.php";
require_once LIBRARY_PATH . "/components.php";
require_once LIBRARY_PATH . "/flashMessages.php";

// Initialize App
$router = new Router;
$router->run();
