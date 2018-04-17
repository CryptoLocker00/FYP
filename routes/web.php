<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'Auth\LoginController@showLoginForm');
Auth::routes();

Route::group(['namespace' => 'Backend', 'middleware' => 'auth', 'prefix' => 'backend'], function () {
    // user
    Route::get('/', 'QuotationController@view');

    Route::get('/user', 'UserController@view');
    Route::get('/user/create', 'UserController@getCreate');
    Route::get('/user/{id}/edit', 'UserController@getUpdate');
    Route::post('/user/create', 'UserController@postCreate');
    Route::patch('/user/update', 'UserController@postUpdate');
    Route::delete('/user/delete', 'UserController@postDelete');

    //client
    Route::get('/client', 'ClientController@view');
    Route::get('/client/create', 'ClientController@getCreate');
    Route::get('/client/{id}/edit', 'ClientController@getEdit');
    Route::post('/client/create', 'ClientController@postCreate');
    Route::patch('/client/update', 'ClientController@postEdit');
    Route::delete('/client/delete', 'ClientController@postDelete');

    //Item
    Route::get('/item', 'ItemController@view');
    Route::get('/item/create', 'ItemController@getCreate');
    Route::get('/item/{id}/edit', 'ItemController@getEdit');
    Route::post('/item/create', 'ItemController@postCreate');
    Route::patch('/item/update', 'ItemController@postEdit');
    Route::delete('/item/delete', 'ItemController@postDelete');

    //Quotation
    Route::get('/quotation', 'QuotationController@view');
//    Route::get('/quotation/create', 'QuotationController@getCreate');
    Route::get('/quotation/{id}/edit', 'QuotationController@getEdit');
    Route::get('/quotation/{id}/pdf', 'QuotationController@viewPDF');
    Route::post('/quotation/create', 'QuotationController@postCreate');
    Route::patch('/quotation/update', 'QuotationController@postEdit');
    Route::delete('/quotation/delete', 'QuotationController@postDelete');

    Route::get('/invoice', 'InvoiceController@view');
    Route::get('/invoice/create', 'InvoiceController@getCreate');
    Route::get('/invoice/{id}/edit', 'InvoiceController@getEdit')->name('invoice.show');;
    Route::get('/invoice/{invoice}/pdf', 'InvoiceController@viewPDF')->name('invoice.pdf');
    Route::post('/invoice/create', 'InvoiceController@postCreate');
    Route::patch('/invoice/update', 'InvoiceController@postEdit');
    Route::delete('/invoice/delete', 'InvoiceController@postDelete');
});

