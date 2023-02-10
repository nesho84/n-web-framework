<?php
// --- Admin --- //
Router::route('/admin', 'admin/admin_controller@index');

// --- categories --- //
Router::route('/admin/categories', 'admin/categories_controller@index');
Router::route('/admin/categories/create', 'admin/categories_controller@create');
Router::route('/admin/categories/insert', 'admin/categories_controller@insert');
Router::route('/admin/categories/edit/{id}', 'admin/categories_controller@edit');
Router::route('/admin/categories/update/{id}', 'admin/categories_controller@update');
Router::route('/admin/categories/delete/{id}', 'admin/categories_controller@delete');

// --- pages --- //
Router::route('/admin/pages', 'admin/pages_controller@index');
Router::route('/admin/pages/create', 'admin/pages_controller@create');
Router::route('/admin/pages/insert', 'admin/pages_controller@insert');
Router::route('/admin/pages/edit/{id}', 'admin/pages_controller@edit');
Router::route('/admin/pages/update/{id}', 'admin/pages_controller@update');
Router::route('/admin/pages/delete/{id}', 'admin/pages_controller@delete');

// --- services --- //
// Router::route('/admin/services', 'admin/services_controller@index');
// Router::route('/admin/services/create', 'admin/services_controller@create');
// Router::route('/admin/services/insert', 'admin/services_controller@insert');
// Router::route('/admin/services/edit/{id}', 'admin/services_controller@edit');
// Router::route('/admin/services/update/{id}', 'admin/services_controller@update');
// Router::route('/admin/services/delete/{id}', 'admin/services_controller@delete');

// --- translations --- //
Router::route('/admin/translations', 'admin/translations_controller@index');
Router::route('/admin/translations/create', 'admin/translations_controller@create');
Router::route('/admin/translations/insert', 'admin/translations_controller@insert');
Router::route('/admin/translations/edit/{id}', 'admin/translations_controller@edit');
Router::route('/admin/translations/update/{id}', 'admin/translations_controller@update');
Router::route('/admin/translations/delete/{id}', 'admin/translations_controller@delete');

// --- users --- //
Router::route('/admin/users', 'admin/users_controller@index');
Router::route('/admin/users/profile/{id}', 'admin/users_controller@profile');
Router::route('/admin/users/create', 'admin/users_controller@create');
Router::route('/admin/users/insert', 'admin/users_controller@insert');
Router::route('/admin/users/edit/{id}', 'admin/users_controller@edit');
Router::route('/admin/users/update/{id}', 'admin/users_controller@update');
Router::route('/admin/users/delete/{id}', 'admin/users_controller@delete');
