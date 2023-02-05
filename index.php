<?php
// ---------------------------------------------------------
// --------------------- Startup files ---------------------
// ------------------ Order is important! ------------------
// ---------------------------------------------------------

// Global settings
require_once __DIR__ . "/config/settings.php";

// MySQL Connection
require_once CORE_PATH . "/database.php";

// Core Library
require_once LIBRARY_PATH . "/helpers.php";
require_once LIBRARY_PATH . "/userSession.php";
require_once LIBRARY_PATH . "/components.php";
require_once LIBRARY_PATH . "/flashMessages.php";

// Routing - Main Controller
require_once __DIR__ . "/app/app.php";

// Initialize App
$app = new App;
$app->run();
