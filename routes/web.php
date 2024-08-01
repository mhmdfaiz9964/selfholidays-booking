<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomCategoryController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\MobileVerificationController;
use App\Http\Controllers\BookingController; 
use App\Http\Controllers\RoomPricingController; 
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
    return view('frontend.index');
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
Route::get('supplements/create', [HotelController::class, 'createSupplement'])->name('supplements.create');
Route::post('supplements', [HotelController::class, 'storeSupplement'])->name('supplements.store');
Route::get('meals/create', [HotelController::class, 'createMeal'])->name('meals.create');
Route::post('meals', [HotelController::class, 'storeMeal'])->name('meals.store');
Route::get('meals/fetch', [HotelController::class, 'fetchMeals'])->name('meals.fetch');
Route::get('supplements/fetch', [HotelController::class, 'fetchSupplements'])->name('supplements.fetch');
Route::delete('/supplements/{id}', [HotelController::class, 'destroySupplement'])->name('supplements.destroy');
Route::delete('/meals/{id}', [HotelController::class, 'destroyMeal'])->name('meals.destroy');
Route::post('/store-supplements', [RoomPricingController::class, 'storeSupplements'])->name('store.supplements');

Route::get('/verify-mobile', [MobileVerificationController::class, 'showForm'])->name('frontend.verify.form');
Route::get('/next-page', [MobileVerificationController::class, 'verifySuccess'])->name('next.page');
Route::get('/hotel', [BookingController::class, 'index'])->name('hotel.index');
Route::get('/hotels/{hotel}/room-pricings/create', [RoomPricingController::class, 'create'])->name('room_pricing.create');
Route::post('/room-pricings/store', [RoomPricingController::class , 'store'])->name('room_pricing.store');
Route::get('/hotels/{hotel}/pricing/{pricing}/edit', [RoomPricingController::class, 'edit'])->name('room_pricing.edit');
Route::delete('/hotels/pricing/{pricing}', [RoomPricingController::class, 'destroy'])->name('room_pricing.destroy');
Route::put('/hotels/{hotelId}/pricing/{pricingId}', [RoomPricingController::class, 'update'])
     ->name('room_pricing.update');
Route::get('/hotel/{hotel}/booking', [BookingController::class, 'show'])->name('hotel.show');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/hotel/pdf/{id}', [HotelController::class, 'viewPdf'])->name('hotel.pdf');
Route::post('/calculate-price', [BookingController::class, 'calculatePrice'])->name('api.calculatePrice');
