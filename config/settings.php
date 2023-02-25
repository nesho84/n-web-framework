<?php
ob_start();
session_start();

// Just for Develop
error_reporting(E_ALL);
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
//sets time for the session to expire. 
define('SESSION_DURATION', 3600); // the time is in seconds

//------------------------------------------------------------
// App 
//------------------------------------------------------------
defined('APPURL')
    or define('APPURL', 'http://localhost/n-web-framework');

defined('APPROOT')
    or define('APPROOT', dirname(__DIR__));

defined('ADMURL')
    or define('ADMURL', APPURL . '/admin');

defined('SITE_NAME')
    or define('SITE_NAME', 'n-web-framework');

/* Email Address - for the Contact page */
defined('CONTACT_FORM_EMAIL')
    or define('CONTACT_FORM_EMAIL', 'office@n-web-framework.com');

defined('UPLOADURL')
    or define('UPLOADURL', APPURL . '/public/uploads');

defined('UPLOAD_PATH')
    or define('UPLOAD_PATH', APPROOT . '/public/uploads');

defined('LIBRARY_PATH')
    or define('LIBRARY_PATH', APPROOT . '/app/Library');

defined('HELPERS_PATH')
    or define('HELPERS_PATH', APPROOT . '/app/helpers');

defined('SCRIPTS_PATH')
    or define('SCRIPTS_PATH', APPROOT . '/app/js');

defined('SCRIPTS_URL')
    or define('SCRIPTS_URL', APPROOT . '/app/js');

defined('CORE_PATH')
    or define('CORE_PATH', APPROOT . '/app/Core');

defined('ROUTES_PATH')
    or define('ROUTES_PATH', APPROOT . '/app/Routes');

defined('CONTROLLERS_PATH')
    or define('CONTROLLERS_PATH', APPROOT . '/app/Controllers');

defined('MODELS_PATH')
    or define('MODELS_PATH', APPROOT . '/app/Models');

defined('VIEWS_PATH')
    or define('VIEWS_PATH', APPROOT . '/app/Views');
