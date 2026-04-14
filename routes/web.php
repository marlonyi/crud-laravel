<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\CalificacionController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// CRUD Estudiantes
Route::resource('estudiantes', EstudianteController::class);

// CRUD Materias
Route::resource('materias', MateriaController::class);

// CRUD Inscripciones
Route::resource('inscripciones', InscripcionController::class);

// CRUD Calificaciones
Route::resource('calificaciones', CalificacionController::class);
