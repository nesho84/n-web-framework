<?php
// --- Admin --- //
Router::get('/admin', 'admin/AdminController@index');

// --- Categories --- //
Router::get('/admin/categories', 'admin/CategoriesController@index');
Router::get('/admin/categories/create', 'admin/CategoriesController@create');
Router::post('/admin/categories/insert', 'admin/CategoriesController@insert');
Router::get('/admin/categories/edit/{id}', 'admin/CategoriesController@edit');
Router::post('/admin/categories/update/{id}', 'admin/CategoriesController@update');
Router::get('/admin/categories/delete/{id}', 'admin/CategoriesController@delete');

// --- Pages --- //
Router::get('/admin/pages', 'admin/PagesController@index');
Router::get('/admin/pages/create', 'admin/PagesController@create');
Router::post('/admin/pages/insert', 'admin/PagesController@insert');
Router::get('/admin/pages/edit/{id}', 'admin/PagesController@edit');
Router::post('/admin/pages/update/{id}', 'admin/PagesController@update');
Router::get('/admin/pages/delete/{id}', 'admin/PagesController@delete');

// --- Languages --- //
Router::get('/admin/languages', 'admin/LanguagesController@index');
Router::get('/admin/languages/create', 'admin/LanguagesController@create');
Router::post('/admin/languages/insert', 'admin/LanguagesController@insert');
Router::get('/admin/languages/edit/{id}', 'admin/LanguagesController@edit');
Router::post('/admin/languages/update/{id}', 'admin/LanguagesController@update');
Router::get('/admin/languages/delete/{id}', 'admin/LanguagesController@delete');

// --- Translations --- //
Router::get('/admin/translations', 'admin/TranslationsController@index');
Router::get('/admin/translations/create', 'admin/TranslationsController@create');
Router::post('/admin/translations/insert', 'admin/TranslationsController@insert');
Router::get('/admin/translations/edit/{id}', 'admin/TranslationsController@edit');
Router::post('/admin/translations/update/{id}', 'admin/TranslationsController@update');
Router::get('/admin/translations/delete/{id}', 'admin/TranslationsController@delete');

// --- Users --- //
Router::get('/admin/users', 'admin/UsersController@index');
Router::get('/admin/users/profile/{id}', 'admin/UsersController@profile');
Router::get('/admin/users/create', 'admin/UsersController@create');
Router::post('/admin/users/insert', 'admin/UsersController@insert');
Router::get('/admin/users/edit/{id}', 'admin/UsersController@edit');
Router::post('/admin/users/update/{id}', 'admin/UsersController@update');
Router::get('/admin/users/delete/{id}', 'admin/UsersController@delete');

// --- Settings --- //
Router::get('/admin/settings', 'admin/SettingsController@index');
Router::get('/admin/settings/edit_modal/{id}', 'admin/SettingsController@edit_modal');
Router::post('/admin/settings/update/{id}', 'admin/SettingsController@update');
Router::post('/admin/settings/dbbackup', 'admin/SettingsController@dbbackup');
Router::get('/admin/settings/dbbackups_modal', 'admin/SettingsController@dbbackups_modal');
Router::get('/admin/settings/dbbackup_delete', 'admin/SettingsController@dbbackup_delete');

// --- Files --- //
Router::get('/admin/files', 'admin/FilesController@index');
Router::get('/admin/files/create', 'admin/FilesController@create');
Router::post('/admin/files/insert', 'admin/FilesController@insert');
Router::get('/admin/files/delete/{id}', 'admin/FilesController@delete');

// --- Invoices --- //
Router::get('/admin/invoices', 'admin/InvoicesController@index');
Router::get('/admin/invoices/create', 'admin/InvoicesController@create');
Router::post('/admin/invoices/insert', 'admin/InvoicesController@insert');
Router::get('/admin/invoices/edit/{id}', 'admin/InvoicesController@edit');
Router::post('/admin/invoices/update/{id}', 'admin/InvoicesController@update');
Router::get('/admin/invoices/delete/{id}', 'admin/InvoicesController@delete');
Router::get('/admin/invoices/pdf_output', 'admin/InvoicesController@invoice_pdf');

// --- Events --- //
Router::get('/admin/events', 'admin/EventsController@index');
Router::get('/admin/events/fetchEvents', 'admin/EventsController@fetchEvents');
Router::get('/admin/events/create_modal', 'admin/EventsController@create_modal');
Router::post('/admin/events/insert', 'admin/EventsController@insert');
Router::post('/admin/events/insertJson', 'admin/EventsController@insertJson');
Router::post('/admin/events/updateJson/{id}', 'admin/EventsController@updateJson');
Router::post('/admin/events/deleteJson/{id}', 'admin/EventsController@deleteJson');
