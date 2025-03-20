<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, "index"])->name("home");

Route::get('/product/creer', [ProductController::class, 'create'])->name('product.create')->middleware("auth");
Route::post('/product/creer', [ProductController::class, 'store'])->middleware("auth");
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
//**auth */
Route::get("/register", [AuthController::class, 'showRegister'])->name('register')->middleware("guest");
Route::post("/register", [AuthController::class, 'register'])->middleware("guest");
Route::get("/login", [AuthController::class, 'showLogin'])->name('login')->middleware("guest");
Route::post("/login", [AuthController::class, 'login'])->middleware("guest");

Route::delete('/deconnexion',[AuthController::class,'logout'])->name('auth.logout')->middleware("auth");




