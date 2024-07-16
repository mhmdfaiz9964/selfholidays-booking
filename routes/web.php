<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomCategoryController;
use App\Http\Controllers\HotelController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::post('users', [UserController::class, 'store'])->name('users.store');
Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


Route::get('room-categories', [RoomCategoryController::class, 'index'])->name('room-categories.index');
Route::get('room-categories/create', [RoomCategoryController::class, 'create'])->name('room-categories.create');
Route::post('room-categories', [RoomCategoryController::class, 'store'])->name('room-categories.store');
Route::get('room-categories/{roomCategory}/edit', [RoomCategoryController::class, 'edit'])->name('room-categories.edit');
Route::put('room-categories/{roomCategory}', [RoomCategoryController::class, 'update'])->name('room-categories.update');
Route::delete('room-categories/{roomCategory}', [RoomCategoryController::class, 'destroy'])->name('room-categories.destroy');


Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/create', [HotelController::class, 'create'])->name('hotels.create');
Route::post('/hotels/store', [HotelController::class, 'store'])->name('hotels.store');
Route::get('/hotels/{hotel}/edit', [HotelController::class, 'edit'])->name('hotels.edit');
Route::put('/hotels/{hotel}/update', [HotelController::class, 'update'])->name('hotels.update');
Route::delete('/hotels/{hotel}/destroy', [HotelController::class, 'destroy'])->name('hotels.destroy');
Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');
