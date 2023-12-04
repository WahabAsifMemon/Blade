<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
 
 
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('register');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/user-register', [UserController::class, 'registerPost'])->name('create');
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/user-login', [UserController::class, 'loginPost'])->name('login_user');
});
 
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('/logout', [UserController::class, 'logout'])->name('logout');
});