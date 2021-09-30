<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ItemController@index')->name('index');
Route::get('/item/category/{category}', 'ItemController@category')->name('item.category');
Route::get('/item/list', 'ItemController@list_items')->name('item.list');
Route::get('/item/cart/{id}', 'ItemController@cart')->name('item.cart');
Route::post('/item/buy/{id}', 'PurchaseController@buy')->name('item.buy');
Route::get('/item/purchases', 'PurchaseController@index')->name('purchases.index');
Route::get('/item/purchases/category', 'PurchaseController@category')->name('purchases.category');

Route::resource('item', 'ItemController');