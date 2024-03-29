<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        $rooms = \App\Models\Room::latest()->take(3)->get();
        return view('dashboard', compact('rooms'));
    })->name('dashboard');

    Route::resource('users', UserController::class);
    Route::post('users/search', [UserController::class, 'search'])->name('users.search');

    Route::resource('rooms', RoomController::class);
    Route::get('rooms/{room}/take', [RoomController::class, 'take'])->name('rooms.take');
    Route::patch('rooms/{room}/take', [RoomController::class, 'takeRoom'])->name('rooms.takeRoom');
    Route::patch('rooms/{room}/dismiss', [RoomController::class, 'dismiss'])->name('rooms.dismiss');
    Route::post('rooms/search', [RoomController::class, 'search'])->name('rooms.search');
});
