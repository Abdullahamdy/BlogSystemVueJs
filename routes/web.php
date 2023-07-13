<?php

use App\Http\Controllers\AdminController;
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
Route::post('/app/create_tag',[AdminController::class,'createtag']);
Route::post('/app/edit_tag',[AdminController::class,'editetag']);
Route::post('/app/delete_tag',[AdminController::class,'deletetag']);
Route::get('/app/get_tags',[AdminController::class,'gettags']);
