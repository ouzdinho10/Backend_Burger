<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BurgerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\UsersController;


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/burgers', [BurgerController::class, 'store']);
    Route::delete('/burgers/{burger}', [BurgerController::class, 'destroy']);
    Route::get('/admins', [AdminsController::class, 'index']);
    Route::get('/admins/orders', [AdminsController::class, 'commande']);
    Route::post('/orders/{order}/complete', [OrderController::class, 'complete']);
    Route::post('/orders/{order}/annuler', [OrderController::class, 'annuler']);
    Route::get('/orders/filtre', [OrderController::class, 'filtre']);
    Route::get('/admins/statistics', [AdminsController::class, 'statistic']);
    // routes/api.php
    Route::get('/users', [UsersController::class, 'index']);
    Route::get('/orders', [OrderController::class, 'index']);
});

Route::post('/orders/cancel/{order}', [OrderController::class, 'cancel']);

Route::get('/users/{id}/profile', [UsersController::class, 'show']);
Route::get('/orders/status/{burgerId}', [OrderController::class, 'getStatus']);
Route::get('/user', [UsersController::class, 'currentUser']);

Route::get('/burgers', [BurgerController::class, 'index'])->name('burgers.index');;
Route::get('/burgers/{burger}', [BurgerController::class, 'show']);
Route::put('/burgers/{burger}', [BurgerController::class, 'update']);



Route::post('/orders', [OrderController::class, 'store']);
Route::post('/orders/{order}/pay', [OrderController::class, 'markAsPaid']);



Route::post('/login', [UsersController::class, 'auth']);
Route::post('/logout', [UsersController::class, 'logout']);
Route::post('/register', [UsersController::class, 'register']);
