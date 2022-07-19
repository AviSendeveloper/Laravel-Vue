<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
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

Route::any('{slug}', function() {
    return view('welcome');
});

Route::post('/app/fetch-tags', [TestController::class, 'fetchTags']);

Route::prefix('admin')->group(function() {
    Route::get('/get-tag', [TagController::class, 'getTag']);
    Route::post('/add-tag', [TagController::class, 'addTag']);
    Route::post('/edit-tag', [TagController::class, 'editTag']);
    Route::get('/delete-tag/{id}', [TagController::class, 'deleteTag']);

    Route::get('/get-category', [CategoryController::class, 'getCategory']);
    Route::post('/add-category', [CategoryController::class, 'addCategory']);
    Route::post('/edit-category', [CategoryController::class, 'editCategory']);
    Route::get('/delete-category/{id}', [CategoryController::class, 'deleteCategory']);

    Route::post('/upload-category-image', [CategoryController::class, 'uploadImage']);
});

