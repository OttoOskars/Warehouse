<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

Route::post('/register-admin', [AdminController::class, 'registerAdmin']);
Route::post('/login', [AdminController::class, 'login']);
