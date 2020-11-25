<?php

// Продукты

Route::match(['get', 'post'], '/', ['uses' => 'ProductController@index', 'as' => 'main']);
Route::match(['get', 'post'], '/category/{id?}', ['uses' => 'ProductController@category', 'as' => 'category']);
Route::get('/product/{id?}', ['uses' => 'ProductController@product', 'as' => 'product']);
Route::match(['get', 'post'], '/search', ['uses' => 'ProductController@searchPhrase', 'as' => 'search']);
Route::get('/cart', ['uses' => 'ProductController@cart', 'as' => 'cart']);
Route::get('/order', ['uses' => 'ProductController@viewOrder', 'as' => 'viewOrder']);
Route::post('/order', ['uses' => 'ProductController@storeOrder', 'as' => 'storeOrder']);

/*Route::get('/new/{id?}', ['uses' => 'MonitoringController@newTrouble', 'as' => 'new', 'middleware' => ['web','auth']]);
Route::post('/new/{id?}', ['uses' => 'MonitoringController@storeTrouble', 'middleware' => ['web','auth']]);

Route::get('/edit/{id}', ['uses' => 'MonitoringController@editTrouble', 'as' => 'edit', 'middleware' => ['web','auth']]);
Route::post('/edit/{id}', ['uses' => 'MonitoringController@storeTrouble', 'middleware' => ['web','auth']]);*/

// Ajax запросы

Route::post('/ajax/searchPhrase', ['uses' => 'AjaxController@searchPhrase']);
Route::post('/ajax/cart', ['uses' => 'AjaxController@cart']);
Route::post('/ajax/changeCart', ['uses' => 'AjaxController@changeCart']);
Route::post('/ajax/pagination', ['uses' => 'AjaxController@pagination']);
/*Route::post('/ajax/directorate', ['uses' => 'AjaxController@getFilials']);
Route::post('/ajax/filial', ['uses' => 'AjaxController@getCities']);
Route::post('/ajax/city', ['uses' => 'AjaxController@getOffices']);
Route::post('/ajax/phrase', ['uses' => 'AjaxController@getPhrases']);
Route::post('/ajax/fullText', ['uses' => 'AjaxController@getFullText']);
Route::post('/ajax/getNow', ['uses' => 'AjaxController@getNow']);*/

// Администрирование

Route::group(['prefix' => '/admin', 'as' => 'admin'], function () {

    Route::match(['get', 'post'], '/', ['uses' => 'AdminController@backup']);

});

// Аутентификация

Auth::routes();
