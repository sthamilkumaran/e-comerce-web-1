<?php

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function (){

    Route::get('dashboard',[App\Http\Controllers\Admin\DashboardController::class, 'index']);

    // Category Routs
    Route::get('/category',[App\Http\Controllers\Admin\CategoryController::class, 'index']);
    Route::post('/category',[App\Http\Controllers\Admin\CategoryController::class, 'store']);

    // Brands Routs
    Route::get('/brands',function(){
        return view('admin.brand.index');
    });
});



