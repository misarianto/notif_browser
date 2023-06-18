<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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
    $users = User::get();
    return view('home', compact('users'));
});

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/api/user', [UserController::class, 'api'])->name('user.api');
Route::post('/store', [UserController::class, 'store'])->name('user.store');
