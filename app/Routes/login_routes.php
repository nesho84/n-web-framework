<?php
// --- Login --- //
Router::route('/login', 'LoginController@login');
Router::route('/logout', 'LoginController@logout');
Router::route('/login/validate', 'LoginController@login_validate');
