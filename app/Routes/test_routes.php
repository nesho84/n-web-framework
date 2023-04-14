<?php
// --- ajax test --- //
Router::get('/ajax_test', 'PublicController@ajax_test');

// --- slug test --- //
Router::get('/slug-test/{slug}', 'PublicController@slug_test');

// --- route with callback function --- //
Router::get('/func', function () {
    echo 'this is a route with a callback function...';
});
