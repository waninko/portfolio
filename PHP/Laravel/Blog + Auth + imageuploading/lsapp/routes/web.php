<?php

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



// Route::get('/hei', function () {
//     return '<h1>Heisann Du!</h1>';
// });
// Route::get('/users/{id}/{name}', function ($id, $name) {
//     return 'this is user ' . $name . ' with an ID of ' . $id;
// });

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');


Route::resource('posts', 'PostsController'); //mapper automatisk funksjoner i kontrolleren


Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
