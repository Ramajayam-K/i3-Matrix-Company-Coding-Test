<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [UsersController::class, 'index'])->name('dashboard');
    Route::post('/user', [UsersController::class, 'show'])->name('user');
    Route::post('/userCreate', [UsersController::class, 'create'])->name('userCreate');

    Route::post('/userUpdate', [UsersController::class, 'update'])->name('userUpdate');
    Route::delete('/user', [UsersController::class, 'destroy'])->name('user');
    Route::post('/RestoreUser', [UsersController::class, 'restore'])->name('RestoreUser');
    Route::post('/GetAllUsers', [UsersController::class, 'GetAllUsers'])->name('GetAllUsers');


    

});

require __DIR__.'/auth.php';
