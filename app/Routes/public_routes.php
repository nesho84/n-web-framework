<?php
// --- Home --- //
Router::get('/', 'PublicController@index');

// --- about-us --- //
Router::get('/about-us', 'PublicController@about_us');

// --- contact --- //
Router::get('/contact', 'PublicController@contact');
Router::post('/contact/validate', 'PublicController@contact_validate');

// --- notfound --- //
Router::get('/notfound', function () {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
    require_once VIEWS_PATH . "/errors/404.php";
});

// --- noscript --- //
Router::get('/noscript', function () {
    require_once VIEWS_PATH . "/errors/noscript.php";
});
