<?php
// --- Admin --- //
Router::add('/admin', 'admin/AdminController@index');

// --- categories --- //
Router::add('/admin/categories', 'admin/CategoriesController@index');
Router::add('/admin/categories/create', 'admin/CategoriesController@create');
Router::add('/admin/categories/insert', 'admin/CategoriesController@insert');
Router::add('/admin/categories/edit/{id}', 'admin/CategoriesController@edit');
Router::add('/admin/categories/update/{id}', 'admin/CategoriesController@update');
Router::add('/admin/categories/delete/{id}', 'admin/CategoriesController@delete');

// --- pages --- //
Router::add('/admin/pages', 'admin/PagesController@index');
Router::add('/admin/pages/create', 'admin/PagesController@create');
Router::add('/admin/pages/insert', 'admin/PagesController@insert');
Router::add('/admin/pages/edit/{id}', 'admin/PagesController@edit');
Router::add('/admin/pages/update/{id}', 'admin/PagesController@update');
Router::add('/admin/pages/delete/{id}', 'admin/PagesController@delete');

// --- services --- //
// Router::add('/admin/services', 'admin/services_controller@index');
// Router::add('/admin/services/create', 'admin/services_controller@create');
// Router::add('/admin/services/insert', 'admin/services_controller@insert');
// Router::add('/admin/services/edit/{id}', 'admin/services_controller@edit');
// Router::add('/admin/services/update/{id}', 'admin/services_controller@update');
// Router::add('/admin/services/delete/{id}', 'admin/services_controller@delete');

// --- translations --- //
Router::add('/admin/translations', 'admin/TranslationsController@index');
Router::add('/admin/translations/create', 'admin/TranslationsController@create');
Router::add('/admin/translations/insert', 'admin/TranslationsController@insert');
Router::add('/admin/translations/edit/{id}', 'admin/TranslationsController@edit');
Router::add('/admin/translations/update/{id}', 'admin/TranslationsController@update');
Router::add('/admin/translations/delete/{id}', 'admin/TranslationsController@delete');

// --- users --- //
Router::add('/admin/users', 'admin/UsersController@index');
Router::add('/admin/users/profile/{id}', 'admin/UsersController@profile');
Router::add('/admin/users/create', 'admin/UsersController@create');
Router::add('/admin/users/insert', 'admin/UsersController@insert');
Router::add('/admin/users/edit/{id}', 'admin/UsersController@edit');
Router::add('/admin/users/update/{id}', 'admin/UsersController@update');
Router::add('/admin/users/delete/{id}', 'admin/UsersController@delete');
