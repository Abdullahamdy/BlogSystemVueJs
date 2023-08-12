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
Route::get('/app/get_categories',[AdminController::class,'getcategories']);
Route::post('/app/create_category',[AdminController::class,'addcategory']);
Route::post('/app/edit_category',[AdminController::class,'editcategory']);
Route::post('/app/upload',[AdminController::class,'uploadimage']);
Route::post('/app/delete-img',[AdminController::class,'deleteImage']);
Route::post('/app/delete_category',[AdminController::class,'deletecategory']);
Route::get('/app/get_users',[AdminController::class,'getusers']);
Route::post('/app/create_user',[AdminController::class,'createuser']);
Route::post('/app/edit_user',[AdminController::class,'edituser']);
Route::post('/app/delete_user',[AdminController::class,'deleteuser']);
Route::post('/app/admin_login',[AdminController::class,'adminLogin']);
Route::get('/logout',[AdminController::class,'logout']);
Route::get('/',[AdminController::class,'index']);
Route::any('{slug}',[AdminController::class,'index']);
// Route::any('{slug}', function(){
//     return view('welcome');
// });
