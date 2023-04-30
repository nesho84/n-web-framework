<?php
//------------------------------------------------------------
// Sessions
//------------------------------------------------------------
session_name('NWF_SESSION');
// Use SSL/TLS encryption
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
// Set session cookie parameters
session_set_cookie_params([
    'path' => '/n-web-framework',
    'secure' => true,
    'httponly' => true,
]);
// Session and Cookie duration
define('SESSION_DURATION', 3600); // the time is in seconds (60min)
define('COOKIE_DURATION', 60 * 60 * 24 * 30); // 30 days
if (session_status() === PHP_SESSION_NONE) {
    ob_start();
    session_start();
}

//------------------------------------------------------------
// Error Reporting
//------------------------------------------------------------
error_reporting(E_ALL); // Just for Develop
ini_set('ignore_repeated_errors', TRUE); // always use TRUE
ini_set('display_errors', TRUE); // Error/Exception display, use FALSE only in production
ini_set('log_errors', TRUE); // Error/Exception file logging engine.
ini_set('error_log', dirname(__DIR__) . '/error.log'); // Logging file path

//------------------------------------------------------------
// MySQL Connection
//------------------------------------------------------------
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_NAME', 'nwf_db');
define('DB_USER', 'root');
define('DB_PASS', '123456');

//------------------------------------------------------------
// Version
//------------------------------------------------------------
define('APP_VERSION', '3.1.1');

//------------------------------------------------------------
// User Admin
//------------------------------------------------------------
define('A_USERNAME', 'admin');
define('A_USER_EMAIL', 'admin@company.com');
define('A_USER_ROLE', 'admin');
define('A_USER_PASSWORD', '010203');

//------------------------------------------------------------
// App 
//------------------------------------------------------------
define('SITE_NAME', 'n-web-framework');
define('APPURL', 'http://localhost/n-web-framework');
define('APPROOT', dirname(__DIR__));
define('ADMURL', APPURL . '/admin');
define('ADM_VIEWS', APPURL . '/app/Views/admin');
define('CONTACT_FORM_EMAIL', 'office@n-web-framework.com');
define('UPLOADURL', APPURL . '/public/uploads');
define('UPLOAD_PATH', APPROOT . '/public/uploads');
define('DB_BACKUPURL', APPURL . '/public/backups/database');
define('DB_BACKUPS_PATH', APPROOT . '/public/backups/database');
define('ROUTES_PATH', APPROOT . '/app/Routes');
define('MODELS_PATH', APPROOT . '/app/Models');
define('VIEWS_PATH', APPROOT . '/app/Views');
define('CONTROLLERS_PATH', APPROOT . '/app/Controllers');
define('CORE_PATH', APPROOT . '/app/Core');
define('COMMON_PATH', APPROOT . '/app/common');
define('LIBRARY_PATH', APPROOT . '/app/library');
define('SCRIPTS_PATH', APPROOT . '/app/js');
define('SCRIPTS_URL', APPURL . '/app/js');
