<?php
// --- Admin --- //
Router::get('/admin', 'admin/AdminController@index', ["auth"]);

// --- Categories --- //
Router::get('/admin/categories', 'admin/CategoriesController@index', ['auth']);
Router::get('/admin/categories/create', 'admin/CategoriesController@create', ['auth']);
Router::post('/admin/categories/insert', 'admin/CategoriesController@insert', ['auth']);
Router::get('/admin/categories/edit/{id}', 'admin/CategoriesController@edit', ['auth']);
Router::post('/admin/categories/update/{id}', 'admin/CategoriesController@update', ['auth']);
Router::get('/admin/categories/delete/{id}', 'admin/CategoriesController@delete', ['auth']);

// --- Pages --- //
Router::get('/admin/pages', 'admin/PagesController@index', ['auth']);
Router::get('/admin/pages/create', 'admin/PagesController@create', ['auth']);
Router::post('/admin/pages/insert', 'admin/PagesController@insert', ['auth']);
Router::get('/admin/pages/edit/{id}', 'admin/PagesController@edit', ['auth']);
Router::post('/admin/pages/update/{id}', 'admin/PagesController@update', ['auth']);
Router::get('/admin/pages/delete/{id}', 'admin/PagesController@delete', ['auth']);

// --- Languages --- //
Router::get('/admin/languages', 'admin/LanguagesController@index', ['auth']);
Router::get('/admin/languages/create', 'admin/LanguagesController@create', ['auth']);
Router::post('/admin/languages/insert', 'admin/LanguagesController@insert', ['auth']);
Router::get('/admin/languages/edit/{id}', 'admin/LanguagesController@edit', ['auth']);
Router::post('/admin/languages/update/{id}', 'admin/LanguagesController@update', ['auth']);
Router::get('/admin/languages/delete/{id}', 'admin/LanguagesController@delete', ['auth']);

// --- Translations --- //
Router::get('/admin/translations', 'admin/TranslationsController@index', ['auth']);
Router::get('/admin/translations/create', 'admin/TranslationsController@create', ['auth']);
Router::post('/admin/translations/insert', 'admin/TranslationsController@insert', ['auth']);
Router::get('/admin/translations/edit/{id}', 'admin/TranslationsController@edit', ['auth']);
Router::post('/admin/translations/update/{id}', 'admin/TranslationsController@update', ['auth']);
Router::get('/admin/translations/delete/{id}', 'admin/TranslationsController@delete', ['auth']);

// --- Users --- //
Router::get('/admin/users', 'admin/UsersController@index', ['auth']);
Router::get('/admin/users/profile/{id}', 'admin/UsersController@profile', ['auth']);
Router::get('/admin/users/create', 'admin/UsersController@create', ['auth']);
Router::post('/admin/users/insert', 'admin/UsersController@insert', ['auth']);
Router::get('/admin/users/edit/{id}', 'admin/UsersController@edit', ['auth']);
Router::post('/admin/users/update/{id}', 'admin/UsersController@update', ['auth']);
Router::get('/admin/users/delete/{id}', 'admin/UsersController@delete', ['auth']);

// --- Settings --- //
Router::get('/admin/settings', 'admin/SettingsController@index', ['auth']);
Router::get('/admin/settings/edit_modal/{id}', 'admin/SettingsController@edit_modal', ['auth']);
Router::post('/admin/settings/update/{id}', 'admin/SettingsController@update', ['auth']);
Router::post('/admin/settings/dbbackup', 'admin/SettingsController@dbbackup', ['auth']);
Router::get('/admin/settings/dbbackups_modal', 'admin/SettingsController@dbbackups_modal', ['auth']);
Router::get('/admin/settings/dbbackup_delete', 'admin/SettingsController@dbbackup_delete', ['auth']);

// --- Files --- //
Router::get('/admin/files', 'admin/FilesController@index', ['auth']);
Router::get('/admin/files/create', 'admin/FilesController@create', ['auth']);
Router::post('/admin/files/insert', 'admin/FilesController@insert', ['auth']);
Router::get('/admin/files/delete/{id}', 'admin/FilesController@delete', ['auth']);

// --- Invoices --- //
Router::get('/admin/invoices', 'admin/InvoicesController@index', ['auth']);
Router::get('/admin/invoices/create', 'admin/InvoicesController@create', ['auth']);
Router::post('/admin/invoices/insert', 'admin/InvoicesController@insert', ['auth']);
Router::get('/admin/invoices/edit/{id}', 'admin/InvoicesController@edit', ['auth']);
Router::post('/admin/invoices/update/{id}', 'admin/InvoicesController@update', ['auth']);
Router::get('/admin/invoices/delete/{id}', 'admin/InvoicesController@delete', ['auth']);
Router::get('/admin/invoices/pdf_output', 'admin/InvoicesController@invoice_pdf', ['auth']);

// --- Events --- //
Router::get('/admin/events', 'admin/EventsController@index', ['auth']);
Router::get('/admin/events/create_modal', 'admin/EventsController@create_modal', ['auth']);
Router::post('/admin/events/insert', 'admin/EventsController@insert', ['auth']);
Router::get('/admin/events/eventsJson', 'admin/EventsController@eventsJson', ['auth']);
Router::post('/admin/events/insertJson', 'admin/EventsController@insertJson', ['auth']);
Router::post('/admin/events/updateJson/{id}', 'admin/EventsController@updateJson', ['auth']);
Router::post('/admin/events/deleteJson/{id}', 'admin/EventsController@deleteJson', ['auth']);
