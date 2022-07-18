<?php

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

Route::post('admin/add-tag', [TagController::class, 'addTag']);

Route::get('admin/get-tag', [TagController::class, 'getTag']);
Route::post('admin/edit-tag', [TagController::class, 'editTag']);
