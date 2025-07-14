<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NilaiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/nilaiRT', [NilaiController::class, 'getNilaiRT']);
Route::get('/nilaiST', [NilaiController::class, 'getNilaiST']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/divisions', [DivisionController::class, 'index']);
    Route::apiResource('/employee', EmployeeController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});
