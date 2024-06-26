<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

Route::post('/register-admin', [AdminController::class, 'registerAdmin']);
Route::post('/login', [AdminController::class, 'login']);
Route::post('/admin/create-user', [AdminController::class, 'createUser']);

Route::get('/admin/users', [AdminController::class, 'fetchUsers']);
Route::put('/admin/users/{id}', [AdminController::class, 'editUser']);
Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);
Route::post('/products', [AdminController::class, 'addProduct']);
Route::get('/products/{id}', [AdminController::class, 'getProduct']);
Route::post('/manufacturers', [AdminController::class, 'addManufacturer']);
Route::post('/storage', [AdminController::class, 'addStorage']);
Route::get('/storage/{id}', [AdminController::class, 'getStorage']);
Route::post('/orders', [AdminController::class, 'addOrder'])->middleware('auth:sanctum');