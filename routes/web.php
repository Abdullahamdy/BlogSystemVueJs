<?php

use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminCheck;
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
Route::middleware([AdminCheck::class])->prefix('app')->group(function () {
    Route::post('/create_tag', [AdminController::class, 'createtag']);
    Route::post('/edit_tag', [AdminController::class, 'editetag']);
    Route::post('/delete_tag', [AdminController::class, 'deletetag']);
    Route::get('/get_tags', [AdminController::class, 'gettags']);
    Route::get('/get_categories', [AdminController::class, 'getcategories']);
    Route::post('/create_category', [AdminController::class, 'addcategory']);
    Route::post('/edit_category', [AdminController::class, 'editcategory']);
    Route::post('/upload', [AdminController::class, 'uploadimage']);
    Route::post('/delete-img', [AdminController::class, 'deleteImage']);
    Route::post('/delete_category', [AdminController::class, 'deletecategory']);
    Route::get('/get_users', [AdminController::class, 'getusers']);
    Route::post('/create_user', [AdminController::class, 'createuser']);
    Route::post('/edit_user', [AdminController::class, 'edituser']);
    Route::post('/delete_user', [AdminController::class, 'deleteuser']);
    Route::post('/admin_login', [AdminController::class, 'adminLogin']);
    Route::get('/get_roles', [AdminController::class, 'getroles']);
    Route::post('/create_role', [AdminController::class, 'addrole']);
    Route::post('/edit_role', [AdminController::class, 'editrole']);
    Route::post('/delete_role', [AdminController::class, 'deleterole']);
    Route::post('/assign_role', [AdminController::class, 'assignrole']);
    Route::post('/create-blog', [AdminController::class, 'createBlog']);
    Route::get('/blogsdata', [AdminController::class, 'blogdata']);
});

Route::post('createblogs',[AdminController::class,'upload']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::get('/', [AdminController::class, 'index']);
Route::any('{slug}', [AdminController::class, 'index']);
// Route::any('{slug}', function(){
//     return view('welcome');
// });
