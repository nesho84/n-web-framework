<?php
// --- Home --- //
Router::route('/', 'public_controller@index');

// --- about-us --- //
Router::route('/about-us', 'public_controller@about_us');

// --- contact --- //
Router::route('/contact', 'public_controller@contact');
Router::route('/contact/validate', 'public_controller@contact_validate');

// --- ajax test --- //
Router::route('/ajax_test', 'public_controller@ajax_test');
// --- slug test --- //
Router::route('/slug-test/{slug}', 'public_controller@slug_test');
