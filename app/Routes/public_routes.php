<?php
// --- Home --- //
Router::route('/', 'PublicController@index');

// --- about-us --- //
Router::route('/about-us', 'PublicController@about_us');

// --- contact --- //
Router::route('/contact', 'PublicController@contact');
Router::route('/contact/validate', 'PublicController@contact_validate');

// --- ajax test --- //
Router::route('/ajax_test', 'PublicController@ajax_test');
// --- slug test --- //
Router::route('/slug-test/{slug}', 'PublicController@slug_test');
