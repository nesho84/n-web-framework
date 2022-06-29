<?php
// --- Home --- //
App::route('/', 'public_controller@index');

// --- about-us --- //
App::route('/about-us', 'public_controller@about_us');

// --- contact --- //
App::route('/contact', 'public_controller@contact');
App::route('/contact/validate', 'public_controller@contact_validate');
