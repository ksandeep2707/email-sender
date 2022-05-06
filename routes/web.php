<?php

use App\Http\Controllers\ContentController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin',[ContentController::class,'index']);
Route::post('/add/topic',[ContentController::class,'saveTopic']);
Route::post('/add/user',[ContentController::class,'saveUser']);
Route::post('/add/content',[ContentController::class,'saveContent']);
Route::post('/send/mail',[ContentController::class,'sendMail']);



