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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/exam',function(){
// 	return view('/exam.create');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('examinfo','ExaminfoController');
Route::resource('makequestion' , 'QuestionController');
Route::resource('student','StudentController');
Route::resource('answer','AnswerController');
Route::resource('result' , 'ResultController');

Route::get('/books','ResultController@indexBooks')->name('books');
Route::post('/books','ResultController@books');
Route::patch('/book/{book}','ResultController@updateBook');
Route::delete('/book/{book}','ResultController@deleteBook');

Route::get('/authors','AuthorController@index')->name('authors');
Route::post('/author','AuthorController@store');

Route::post('/checkout/{book}','BookCheckout@store');
Route::post('/checkin/{book}','BookCheckin@store');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
