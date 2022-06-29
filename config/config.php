<?php
session_start();

// Just for Develop
// error_reporting(E_ALL);

//------------------------------------------------------------
// DB 
//------------------------------------------------------------
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_NAME', 'ibis_dsl_db');
define('DB_USER', 'root');
define('DB_PASS', '123456');

// define('DB_HOST', 'w00cf111.kasserver.com');
// define('DB_CHARSET', 'utf8');
// define('DB_NAME', 'd039c845');
// define('DB_USER', 'd039c845');
// define('DB_PASS', 'Lapidarius##11');

//------------------------------------------------------------
// App 
//------------------------------------------------------------
defined("APPURL")
    or define("APPURL", "http://localhost/ibis-dsl.ch");
// or define("APPURL", "https://ibis-dsl.ch");

defined("ADMURL")
    or define("ADMURL", APPURL . "/admin");

defined("SITE_NAME")
    or define("SITE_NAME", 'ibis-dsl.ch');

/* Email Address - for the Contact page */
defined("CONTACT_FORM_EMAIL")
    or define("CONTACT_FORM_EMAIL", 'office@ibis-dsl.ch');

defined("UPLOADURL")
    or define("UPLOADURL", APPURL . "/public/uploads");

defined("APPROOT")
    or define("APPROOT", dirname(__DIR__));

defined('UPLOAD_PATH')
    or define('UPLOAD_PATH', APPROOT . '/public/uploads');

defined("LIBRARY_PATH")
    or define("LIBRARY_PATH", APPROOT . '/app/Library');

defined("ROUTES_PATH")
    or define("ROUTES_PATH", APPROOT . '/app/Routes');

defined("DB_PATH")
    or define("DB_PATH", APPROOT . '/config');

defined("CONTROLLERS_PATH")
    or define("CONTROLLERS_PATH", APPROOT . '/app/Controllers');

defined("MODELS_PATH")
    or define("MODELS_PATH", APPROOT . '/app/Models');

defined("VIEWS_PATH")
    or define("VIEWS_PATH", APPROOT . '/app/Views');
