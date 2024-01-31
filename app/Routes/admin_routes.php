<?php

use App\Core\Router;

// --- Admin --- //
Router::get('/admin', 'AdminController@index', ["auth"]);

// --- Categories --- //
Router::get('/admin/categories', 'CategoriesController@index', ['auth']);
Router::get('/admin/categories/create', 'CategoriesController@create', ['auth']);
Router::post('/admin/categories/insert', 'CategoriesController@insert', ['auth']);
Router::get('/admin/categories/edit/{id}', 'CategoriesController@edit', ['auth']);
Router::post('/admin/categories/update/{id}', 'CategoriesController@update', ['auth']);
Router::get('/admin/categories/delete/{id}', 'CategoriesController@delete', ['auth']);

// --- Pages --- //
Router::get('/admin/pages', 'PagesController@index', ['auth']);
Router::get('/admin/pages/create', 'PagesController@create', ['auth']);
Router::post('/admin/pages/insert', 'PagesController@insert', ['auth']);
Router::get('/admin/pages/edit/{id}', 'PagesController@edit', ['auth']);
Router::post('/admin/pages/update/{id}', 'PagesController@update', ['auth']);
Router::get('/admin/pages/delete/{id}', 'PagesController@delete', ['auth']);

// --- Languages --- //
Router::get('/admin/languages', 'LanguagesController@index', ['auth']);
Router::get('/admin/languages/create', 'LanguagesController@create', ['auth']);
Router::post('/admin/languages/insert', 'LanguagesController@insert', ['auth']);
Router::get('/admin/languages/edit/{id}', 'LanguagesController@edit', ['auth']);
Router::post('/admin/languages/update/{id}', 'LanguagesController@update', ['auth']);
Router::get('/admin/languages/delete/{id}', 'LanguagesController@delete', ['auth']);

// --- Translations --- //
Router::get('/admin/translations', 'TranslationsController@index', ['auth']);
Router::get('/admin/translations/create', 'TranslationsController@create', ['auth']);
Router::post('/admin/translations/insert', 'TranslationsController@insert', ['auth']);
Router::get('/admin/translations/edit/{id}', 'TranslationsController@edit', ['auth']);
Router::post('/admin/translations/update/{id}', 'TranslationsController@update', ['auth']);
Router::get('/admin/translations/delete/{id}', 'TranslationsController@delete', ['auth']);

// --- Users --- //
Router::get('/admin/users', 'UsersController@index', ['auth']);
Router::get('/admin/users/profile/{id}', 'UsersController@profile', ['auth']);
Router::get('/admin/users/create', 'UsersController@create', ['auth']);
Router::post('/admin/users/insert', 'UsersController@insert', ['auth']);
Router::get('/admin/users/edit/{id}', 'UsersController@edit', ['auth']);
Router::post('/admin/users/update/{id}', 'UsersController@update', ['auth']);
Router::get('/admin/users/delete/{id}', 'UsersController@delete', ['auth']);

// --- Settings --- //
Router::get('/admin/settings', 'SettingsController@index', ['auth']);
Router::get('/admin/settings/edit_modal/{id}', 'SettingsController@edit_modal', ['auth']);
Router::post('/admin/settings/update/{id}', 'SettingsController@update', ['auth']);
Router::post('/admin/settings/dbbackup', 'SettingsController@dbbackup', ['auth']);
Router::get('/admin/settings/dbbackups_modal', 'SettingsController@dbbackups_modal', ['auth']);
Router::get('/admin/settings/dbbackup_delete', 'SettingsController@dbbackup_delete', ['auth']);

// --- Files --- //
Router::get('/admin/files', 'FilesController@index', ['auth']);
Router::get('/admin/files/create', 'FilesController@create', ['auth']);
Router::post('/admin/files/insert', 'FilesController@insert', ['auth']);
Router::get('/admin/files/delete/{id}', 'FilesController@delete', ['auth']);

// --- Invoices --- //
Router::get('/admin/invoices', 'InvoicesController@index', ['auth']);
Router::get('/admin/invoices/create', 'InvoicesController@create', ['auth']);
Router::post('/admin/invoices/insert', 'InvoicesController@insert', ['auth']);
Router::get('/admin/invoices/edit/{id}', 'InvoicesController@edit', ['auth']);
Router::post('/admin/invoices/update/{id}', 'InvoicesController@update', ['auth']);
Router::get('/admin/invoices/delete/{id}', 'InvoicesController@delete', ['auth']);
Router::get('/admin/invoices/pdf_output', 'InvoicesController@invoice_pdf', ['auth']);

// --- Events --- //
Router::get('/admin/events', 'EventsController@index', ['auth']);
Router::get('/admin/events/create_modal', 'EventsController@create_modal', ['auth']);
Router::post('/admin/events/insert', 'EventsController@insert', ['auth']);
Router::get('/admin/events/eventsJson', 'EventsController@eventsJson', ['auth']);
Router::post('/admin/events/insertJson', 'EventsController@insertJson', ['auth']);
Router::post('/admin/events/updateJson/{id}', 'EventsController@updateJson', ['auth']);
Router::post('/admin/events/deleteJson/{id}', 'EventsController@deleteJson', ['auth']);
