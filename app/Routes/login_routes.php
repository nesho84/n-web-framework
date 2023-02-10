<?php
// --- Login --- //
Router::route('/login', 'login_controller@login');
Router::route('/logout', 'login_controller@logout');
Router::route('/login/validate', 'login_controller@login_validate');
