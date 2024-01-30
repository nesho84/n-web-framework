<?php
// --- Login --- //
Router::get('/login', 'LoginController@login', ['guest']);
Router::post('/login/validate', 'LoginController@login_validate', ['guest']);
Router::get('/logout', 'LoginController@logout', ['auth']);
