<?php
// --- Admin --- //
App::route('/admin', 'admin/admin_controller@index');

// --- pages --- //
App::route('/admin/pages', 'admin/pages_controller@index');
App::route('/admin/pages/create', 'admin/pages_controller@create');
App::route('/admin/pages/insert', 'admin/pages_controller@insert');
App::route('/admin/pages/edit/{:id}', 'admin/pages_controller@edit');
App::route('/admin/pages/update/{:id}', 'admin/pages_controller@update');
App::route('/admin/pages/delete/{:id}', 'admin/pages_controller@delete');

// --- categories --- //
App::route('/admin/categories', 'admin/categories_controller@index');
App::route('/admin/categories/create', 'admin/categories_controller@create');
App::route('/admin/categories/insert', 'admin/categories_controller@insert');
App::route('/admin/categories/edit/{:id}', 'admin/categories_controller@edit');
App::route('/admin/categories/update/{:id}', 'admin/categories_controller@update');
App::route('/admin/categories/delete/{:id}', 'admin/categories_controller@delete');

// --- translations --- //
App::route('/admin/translations', 'admin/translations_controller@index');
App::route('/admin/translations/create', 'admin/translations_controller@create');
App::route('/admin/translations/insert', 'admin/translations_controller@insert');
// App::route('/admin/translations/edit/{:id}', 'admin/translations_controller@edit');
// App::route('/admin/translations/update/{:id}', 'admin/translations_controller@update');
// App::route('/admin/translations/delete/{:id}', 'admin/translations_controller@delete');

// --- services --- //
// App::route('/admin/services', 'admin/services_controller@index');
// App::route('/admin/services/create', 'admin/services_controller@create');
// App::route('/admin/services/insert', 'admin/services_controller@insert');
// App::route('/admin/services/edit/{:id}', 'admin/services_controller@edit');
// App::route('/admin/services/update/{:id}', 'admin/services_controller@update');
// App::route('/admin/services/delete/{:id}', 'admin/services_controller@delete');

// --- users --- //
App::route('/admin/users', 'admin/users_controller@index');
App::route('/admin/users/create', 'admin/users_controller@create');
App::route('/admin/users/insert', 'admin/users_controller@insert');
App::route('/admin/users/edit/{:id}', 'admin/users_controller@edit');
App::route('/admin/users/update/{:id}', 'admin/users_controller@update');
App::route('/admin/users/delete/{:id}', 'admin/users_controller@delete');
