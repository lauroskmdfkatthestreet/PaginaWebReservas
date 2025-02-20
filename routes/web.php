<?php

use App\Http\Controllers\ReservaController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// Opción 1: Definir la ruta con el controlador (Recomendada)
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/reservas/events', [ReservaController::class, 'getEvents'])->name('reservas.events');

Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');
Route::get('/reservas/create', [ReservaController::class, 'create'])->name('reservas.create'); // ✅ ESTA ES LA RUTA QUE FALTABA
Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
Route::get('/reservas/events', [ReservaController::class, 'events'])->name('reservas.events');






// Rutas de autenticación
Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'show'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');


Route::get('/admin', function () {
    // Vista de admin
})->middleware('role:admin');

Route::get('/profesor', function () {
    // Vista de profesor
})->middleware('role:profesor');





// Ruta accesible solo por administradores
Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Ruta accesible solo por profesores
Route::middleware(['auth', 'role:profesor'])->group(function () {
    Route::get('/profesor', function () {
        return view('profesor.dashboard');
    })->name('profesor.dashboard');
});
