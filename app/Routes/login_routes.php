<?php
// --- Login --- //
Router::get('/login', 'LoginController@login');
Router::get('/logout', 'LoginController@logout');
Router::post('/login/validate', 'LoginController@login_validate');
