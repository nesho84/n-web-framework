<?php
// --- Login --- //
App::route('/login', 'login_controller@login');
App::route('/logout', 'login_controller@logout');
App::route('/login/validate', 'login_controller@login_validate');
