<?php
// --- Home --- //
Router::add('/', 'PublicController@index');

// --- about-us --- //
Router::add('/about-us', 'PublicController@about_us');

// --- contact --- //
Router::add('/contact', 'PublicController@contact');
Router::add('/contact/validate', 'PublicController@contact_validate');

// --- ajax test --- //
Router::add('/ajax_test', 'PublicController@ajax_test');
// --- slug test --- //
Router::add('/slug-test/{slug}', 'PublicController@slug_test');
