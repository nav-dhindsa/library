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

Route::post('/books', 'BooksController@store');
Route::get('/books', 'BooksController@index');
Route::patch('/books/{book}', 'BooksController@update');
Route::delete('/books/{book}', 'BooksController@destroy');
Route::post('/checkout/{book}', 'CheckoutBookController@store');
Route::post('/checkin/{book}', 'CheckinBookController@store');
Route::post('/action', 'BooksController@action');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
