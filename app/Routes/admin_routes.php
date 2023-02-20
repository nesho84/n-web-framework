<?php
// --- Admin --- //
Router::get('/admin', 'admin/AdminController@index');

// --- categories --- //
Router::get('/admin/categories', 'admin/CategoriesController@index');
Router::get('/admin/categories/create', 'admin/CategoriesController@create');
Router::post('/admin/categories/insert', 'admin/CategoriesController@insert');
Router::get('/admin/categories/edit/{id}', 'admin/CategoriesController@edit');
Router::post('/admin/categories/update/{id}', 'admin/CategoriesController@update');
Router::post('/admin/categories/delete/{id}', 'admin/CategoriesController@delete');

// --- pages --- //
Router::get('/admin/pages', 'admin/PagesController@index');
Router::get('/admin/pages/create', 'admin/PagesController@create');
Router::post('/admin/pages/insert', 'admin/PagesController@insert');
Router::get('/admin/pages/edit/{id}', 'admin/PagesController@edit');
Router::post('/admin/pages/update/{id}', 'admin/PagesController@update');
Router::post('/admin/pages/delete/{id}', 'admin/PagesController@delete');

// --- services --- //
Router::get('/admin/services', 'admin/services_controller@index');
Router::get('/admin/services/create', 'admin/services_controller@create');
Router::post('/admin/services/insert', 'admin/services_controller@insert');
Router::get('/admin/services/edit/{id}', 'admin/services_controller@edit');
Router::post('/admin/services/update/{id}', 'admin/services_controller@update');
Router::post('/admin/services/delete/{id}', 'admin/services_controller@delete');

// --- translations --- //
Router::get('/admin/translations', 'admin/TranslationsController@index');
Router::get('/admin/translations/create', 'admin/TranslationsController@create');
Router::post('/admin/translations/insert', 'admin/TranslationsController@insert');
Router::get('/admin/translations/edit/{id}', 'admin/TranslationsController@edit');
Router::post('/admin/translations/update/{id}', 'admin/TranslationsController@update');
Router::post('/admin/translations/delete/{id}', 'admin/TranslationsController@delete');

// --- users --- //
Router::get('/admin/users', 'admin/UsersController@index');
Router::get('/admin/users/profile/{id}', 'admin/UsersController@profile');
Router::get('/admin/users/create', 'admin/UsersController@create');
Router::post('/admin/users/insert', 'admin/UsersController@insert');
Router::get('/admin/users/edit/{id}', 'admin/UsersController@edit');
Router::post('/admin/users/update/{id}', 'admin/UsersController@update');
Router::post('/admin/users/delete/{id}', 'admin/UsersController@delete');
