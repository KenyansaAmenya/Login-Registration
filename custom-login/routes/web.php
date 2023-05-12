<?php

use App\Http\Controllers\AuthManager;
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
//Get request is for displaying of the login and registration forms
//Post request is for login to the database

Route::get('/', function () {
    return view('welcome');
})->name('home');

//This displays the login form
Route::get('/login', [AuthManager::class, 'login'])->name('login');

Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');

//This displays the regisration form
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');

//We access the registration route using the .post name
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');

//Logout Route
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

//This makes sure that a user cannot access the profile page without login
Route::group(['middleware' => 'auth'], function () {
    //Profile route
    Route::get('/profile', function () {
        return "Hi";
    });
});