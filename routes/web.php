<?php

use App\Http\Controllers\ReservaController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;

Auth::routes();




// Página principal
Route::get('/', [IndexController::class, 'index'])->name('index');

// Rutas de reservas
Route::prefix('reservas')->group(function () {


    Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');

    Route::get('/', [ReservaController::class, 'index'])->name('reservas.index');
    Route::get('/create', [ReservaController::class, 'create'])->name('reservas.create'); // ✅ Ruta añadida
    Route::get('/calendario', [ReservaController::class, 'calendario'])->name('reservas.calendario');
    Route::get('/eventos', [ReservaController::class, 'obtenerEventos'])->name('reservas.eventos');
    Route::get('/events', [ReservaController::class, 'getEvents'])->name('reservas.events');
});

// Rutas de autenticación
Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');//cerrar sesion

Route::get('/login', [LoginController::class, 'show'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Rutas protegidas por roles
Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'role:profesor'])->group(function () {
    Route::get('/profesor', function () {
        return view('profesor.dashboard');
    })->name('profesor.dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\IndexController::class, 'index'])->name('home');
