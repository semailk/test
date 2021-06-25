<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;
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

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('index', [MainController::class, 'index'])->name('index');
Route::get('create', [MainController::class, 'create'])->name('create');
Route::post('store', [MainController::class, 'store'])->name('store');
Route::get('show/{id}', [MainController::class, 'show'])->name('show');
Route::get('delete/{id}', [MainController::class, 'delete'])->name('delete');
Route::get('edit/{id}', [MainController::class, 'edit'])->name('edit');
Route::post('update/{id}', [MainController::class, 'update'])->name('update');

Route::get('admin/index', [AdminController::class, 'index'])->middleware('auth');

