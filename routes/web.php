<?php

if (config('maintenance_mode') == 'yes'){
    Route::get('{any?}', function ($any = null) {
        return view('maintenance');
    })->where('any', '.*');
} else {

Auth::routes();

Route::get('/sendapi', 'APIController@SendServerAPI');
Route::get('/cekapi', 'APIController@CheckAPI');

//Route::get('/cobaapi', 'APIController@CobaAPI');

Route::get('/ceksms', 'SMSController@checkinboxsms')->name('ceksms');

Route::post('/login', [
    'uses'          => '\App\Http\Controllers\Auth\LoginController@login',
    'middleware'    => 'checkstatus',
]);
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/profile', 'UserController@index')->name('profile');
Route::get('/deposit', 'UserController@deposit')->name('deposit');
Route::post('/deposit', 'UserController@storeDeposit');
Route::get('/deposit/{id}', 'UserController@depositDetail');
Route::get('/history', 'UserController@history');
Route::get('/profile/edit', 'UserController@edit');
Route::post('/profile', 'UserController@saveProfile');

Route::get('/', 'FrontpageController@index')->name('frontpage');
Route::get('/get_by_item', 'ProductsController@get_by_item')->name('options.get_by_item');
Route::get('/buy/{productSlug}', 'ProductsController@getDetail');

Route::post('/order', 'TransactionsController@store');
Route::get('/order/{trx_id}', 'TransactionsController@getStatus')->name('status');
Route::get('/cektrx', 'TransactionsController@cektrx')->name('cektrx');

Route::get('news',[
    'as' => 'News',
    'uses' => 'FrontpageController@getNews'
]);

Route::get('/{slugPage}',[
    'as' => 'Page',
    'uses' => 'FrontpageController@getPage'
]);

Route::get('/news/{slugNews}',[
    'as' => 'DetailNews',
    'uses' => 'FrontpageController@getDetailNews'
]);


}