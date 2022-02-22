<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
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
Route::get('/', [App\Http\Controllers\HomeController::class, 'posts'])->name('posts');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('posts')->group(function (){

    Route::get('/my', [App\Http\Controllers\HomeController::class, 'getMyPosts'])->name('my.posts');
});

Route::post('/avatar/store/{id?}', [HomeController::class, 'avatarStore'])->name('avatar.store');

Route::prefix('admin')->group(function (){
    Route::get('/users/edit', [AdminController::class, 'index'])->name('admin.index')->middleware(['isAdmin']);
});
