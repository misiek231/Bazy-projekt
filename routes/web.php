<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
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

Route::get('/', fn() => view('welcome'))->name("index");
Route::get('/offers/my', [OfferController::class, 'myOffers'])->name('offers.my');
Route::resource('offers', OfferController::class);

Route::controller(ReservationController::class)->group(function () {
    Route::get('/reservations', 'index')->name('reservations.index');
    Route::get('/reservations/create/{roomId}', 'create')->name('reservations.create');
    Route::post('/reservations', 'store')->name('reservations.store');
    Route::get('/reservations/{reservation}', 'show')->name('reservations.show');
    Route::get('/reservations/{reservation}/edit', 'edit')->name('reservations.edit');
    Route::put('/reservations/{reservation}', 'update')->name('reservations.update');
    Route::delete('/reservations/{reservation}', 'destroy')->name('reservations.destroy');
});

Route::controller(RoomController::class)->group(function () {
    Route::get('/rooms', 'index')->name('rooms.index');
    Route::get('/rooms/create/{offerId}', 'create')->name('rooms.create');
    Route::post('/rooms', 'store')->name('rooms.store');
    Route::get('/rooms/{room}', 'show')->name('rooms.show');
    Route::get('/rooms/{room}/edit', 'edit')->name('rooms.edit');
    Route::put('/rooms/{room}', 'update')->name('rooms.update');
    Route::delete('/rooms/{room}', 'destroy')->name('rooms.destroy');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('login.authenticate');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/register', 'create')->name('register');
    Route::post('/register', 'store')->name('register.store');
});
