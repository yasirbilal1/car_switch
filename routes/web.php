<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailManagement;
use App\Http\Controllers\Users;
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
    return view('users.login');
});

Route::resource('email', EmailManagement::class);
Route::resource('users', Users::class);
Route::post('/login', [Users::class, 'login'])->name('authenticate_user');

Route::post('/get_email_by_id', [EmailManagement::class, 'getEmailById']);
Route::post('/reply_all', [EmailManagement::class, 'replyAll'])->name('reply_all_users');


