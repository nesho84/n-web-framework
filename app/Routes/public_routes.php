<?php
// --- Home --- //
Router::get('/', 'PublicController@index');

// --- about-us --- //
Router::get('/about-us', 'PublicController@about_us');

// --- contact --- //
Router::get('/contact', 'PublicController@contact');
Router::post('/contact/validate', 'PublicController@contact_validate');
