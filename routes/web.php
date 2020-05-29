<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserRegistered;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/create-task', 'HomeController@createTask')->name('home');
Route::get('/task-list', 'HomeController@taskList')->name('home');
Route::post('/add-task', 'TaskController@add')->name('home');
Route::post('/delete-task', 'TaskController@delete')->name('home');
Route::post('/update-task', 'TaskController@updateTask')->name('home');

// Mail::to($data()->email)-> send(new NewUserRegistered());

// Route::get('/email', function () {
//
//     return new NewUserRegistered;
// });
