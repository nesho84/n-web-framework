<?php
// ---------------------------------------------------------
// --------------------- Startup files ---------------------
// ------------------ Order is important! ------------------
// ---------------------------------------------------------

// App Settings
require_once __DIR__ . "/config/settings.php";

// MySQL Connection
require_once CORE_PATH . "/Database.php";
// Sessions Handler
require_once CORE_PATH . "/Sessions.php";
// Routing
require_once CORE_PATH . "/Router.php";
// Base Model
require_once CORE_PATH . "/Model.php";
// Base Controller
require_once CORE_PATH . "/Controller.php";

// Custom Library
require_once LIBRARY_PATH . "/helpers.php";
require_once LIBRARY_PATH . "/components.php";
require_once LIBRARY_PATH . "/flashMessages.php";

// Initialize Router
$router = new Router;
$router->run();
