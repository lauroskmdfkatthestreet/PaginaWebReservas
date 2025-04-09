<?php

use App\Http\Controllers\ReservaController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserva;





// Página principal
Route::get('/', [IndexController::class, 'index'])->name('index');

// Rutas de reservas
Route::middleware(['auth'])->prefix('reservas')->group(function () {
    Route::get('/', [ReservaController::class, 'index'])->name('reservas.index');
    Route::post('/', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/calendario', [ReservaController::class, 'calendario'])->name('reservas.calendario');
    Route::get('/events', [ReservaController::class, 'getEvents'])->name('reservas.events');
    Route::get('/{reserva}', [ReservaController::class, 'show'])->name('reservas.show'); // Modificación aquí
    Route::delete('/{reserva}', [ReservaController::class, 'destroy'])->name('reservas.destroy'); // Modificación aquí

});

// Rutas de autenticación
Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');//cerrar sesion

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
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
