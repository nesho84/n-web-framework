<?php
// ---------------------------------------------------------
// --------------------- Startup files ---------------------
// ------------------ Order is important! ------------------
// ---------------------------------------------------------

// Global config
require_once __DIR__ . "/config/config.php";

// Core Library
require_once LIBRARY_PATH . "/helpers.php";
require_once LIBRARY_PATH . "/userSession.php";
require_once LIBRARY_PATH . "/components.php";
require_once LIBRARY_PATH . "/FlashMessages.php";

// MySQL Connection
require_once DB_PATH . "/db.php";

// Routing - Main Controller
require_once __DIR__ . "/app/app.php";

// Initialize App
$app = new App;
$app->init();
