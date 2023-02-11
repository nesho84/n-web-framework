<?php
// --- Admin --- //
Router::route('/admin', 'admin/AdminController@index');

// --- categories --- //
Router::route('/admin/categories', 'admin/CategoriesController@index');
Router::route('/admin/categories/create', 'admin/CategoriesController@create');
Router::route('/admin/categories/insert', 'admin/CategoriesController@insert');
Router::route('/admin/categories/edit/{id}', 'admin/CategoriesController@edit');
Router::route('/admin/categories/update/{id}', 'admin/CategoriesController@update');
Router::route('/admin/categories/delete/{id}', 'admin/CategoriesController@delete');

// --- pages --- //
Router::route('/admin/pages', 'admin/PagesController@index');
Router::route('/admin/pages/create', 'admin/PagesController@create');
Router::route('/admin/pages/insert', 'admin/PagesController@insert');
Router::route('/admin/pages/edit/{id}', 'admin/PagesController@edit');
Router::route('/admin/pages/update/{id}', 'admin/PagesController@update');
Router::route('/admin/pages/delete/{id}', 'admin/PagesController@delete');

// --- services --- //
// Router::route('/admin/services', 'admin/services_controller@index');
// Router::route('/admin/services/create', 'admin/services_controller@create');
// Router::route('/admin/services/insert', 'admin/services_controller@insert');
// Router::route('/admin/services/edit/{id}', 'admin/services_controller@edit');
// Router::route('/admin/services/update/{id}', 'admin/services_controller@update');
// Router::route('/admin/services/delete/{id}', 'admin/services_controller@delete');

// --- translations --- //
Router::route('/admin/translations', 'admin/TranslationsController@index');
Router::route('/admin/translations/create', 'admin/TranslationsController@create');
Router::route('/admin/translations/insert', 'admin/TranslationsController@insert');
Router::route('/admin/translations/edit/{id}', 'admin/TranslationsController@edit');
Router::route('/admin/translations/update/{id}', 'admin/TranslationsController@update');
Router::route('/admin/translations/delete/{id}', 'admin/TranslationsController@delete');

// --- users --- //
Router::route('/admin/users', 'admin/UsersController@index');
Router::route('/admin/users/profile/{id}', 'admin/UsersController@profile');
Router::route('/admin/users/create', 'admin/UsersController@create');
Router::route('/admin/users/insert', 'admin/UsersController@insert');
Router::route('/admin/users/edit/{id}', 'admin/UsersController@edit');
Router::route('/admin/users/update/{id}', 'admin/UsersController@update');
Router::route('/admin/users/delete/{id}', 'admin/UsersController@delete');
