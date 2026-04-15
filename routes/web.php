<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\Api\V1\EstudianteController as ApiEstudianteController;
use App\Http\Controllers\Api\V1\MateriaController as ApiMateriaController;
use App\Http\Controllers\Api\V1\InscripcionController as ApiInscripcionController;
use App\Http\Controllers\Api\V1\CalificacionController as ApiCalificacionController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Audit Log
Route::middleware('auth')->group(function () {
    Route::resource('audits', AuditController::class)->only(['index', 'show']);
});

// CRUD routes con autenticación
Route::middleware('auth')->group(function () {
    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('materias', MateriaController::class);
    Route::resource('inscripciones', InscripcionController::class);
    Route::resource('calificaciones', CalificacionController::class);
});

// API RESTful routes v1
Route::prefix('api/v1')->middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('estudiantes', ApiEstudianteController::class);
    Route::apiResource('materias', ApiMateriaController::class);
    Route::apiResource('inscripciones', ApiInscripcionController::class);
    Route::apiResource('calificaciones', ApiCalificacionController::class);
});

require __DIR__.'/auth.php';
