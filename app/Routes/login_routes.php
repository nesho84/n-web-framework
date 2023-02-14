<?php
// --- Login --- //
Router::add('/login', 'LoginController@login');
Router::add('/logout', 'LoginController@logout');
Router::add('/login/validate', 'LoginController@login_validate');
