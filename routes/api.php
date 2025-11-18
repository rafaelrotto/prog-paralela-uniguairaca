<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\UserController;
use App\Jobs\TesteFila;
use Illuminate\Support\Facades\Route;

Route::get('/teste-fila', function () {
    TesteFila::dispatch();
    return 'Job enviado para a fila!';
});

/*
Route::post('/users', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::get('/users/{id}', [UserController::class, 'show']);
*/

Route::post('/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::middleware(['user.type:admin'])->group(function () {
        Route::apiResource('/companies', CompanyController::class);
    });

     Route::middleware(['user.type:manager,admin,teacher, student'])->group(function () {
        Route::apiResource('/project', ProjectController::class);
    });

    Route::middleware(['user.type:manager,admin'])->group(function () {
        Route::apiResource('/users', UserController::class);
        Route::get('/users/export/csv', [UserController::class, 'exportCsv']);
    });

    Route::middleware(['user.type:teacher, student'])->group(function () {
        //;
    });

    Route::middleware(['user.type:teacher'])->group(function () {
        //
    });

    Route::middleware(['user.type:student'])->group(function () {
        //
    });
});
