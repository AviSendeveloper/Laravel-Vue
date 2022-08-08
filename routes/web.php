<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\TestController;
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

Route::get('/test', [TestController::class, 'test']);

Route::post('/app/fetch-tags', [TestController::class, 'fetchTags']);

Route::prefix('admin')->middleware('admin')->group(function() {
    Route::get('/get-tag', [TagController::class, 'getTag']);
    Route::post('/add-tag', [TagController::class, 'addTag']);
    Route::post('/edit-tag', [TagController::class, 'editTag']);
    Route::post('/delete-tag', [TagController::class, 'deleteTag']);

    Route::get('/get-category', [CategoryController::class, 'getCategory']);
    Route::post('/add-category', [CategoryController::class, 'addCategory']);
    Route::post('/edit-category', [CategoryController::class, 'editCategory']);
    Route::post('/delete-category', [CategoryController::class, 'deleteCategory']);

    Route::post('/upload-category-image', [CategoryController::class, 'uploadImage']);
    Route::post('/delete-category-image', [CategoryController::class, 'deleteImage']);

    Route::get('/get-admin', [AdminController::class, 'getAdmin']);
    Route::post('/add-admin', [AdminController::class, 'addAdmin']);
    Route::post('/edit-admin', [AdminController::class, 'editAdmin']);
    Route::post('/delete-admin', [AdminController::class, 'deleteAdmin']);

    Route::get('/get-role', [RoleController::class, 'getRole']);
    Route::post('/add-role', [RoleController::class, 'addRole']);
    Route::post('/edit-role', [RoleController::class, 'editRole']);
    Route::post('/delete-role', [RoleController::class, 'deleteRole']);
    Route::post('/role-assign', [RoleController::class, 'assignRole']);
});
    
Route::post('admin/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::any('{slug}', [IndexController::class, 'index']);

// Route::any('{slug}', function() {
//     return view('welcome');
// });

