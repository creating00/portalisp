<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\PagoController;

Volt::route('/', 'home.index')->name('home.index');

Volt::route('/login', 'auth.login')->name('login');
Volt::route('/register', 'auth.register');
Volt::route('/my-contracts', 'contracts.index')
    ->name('contracts.index')
    ->middleware('api.auth');

Volt::route('/my-contracts/{id}', 'contracts.show')
    ->name('contracts.show')
    ->middleware('api.auth')->lazy();

Volt::route('/profile', 'profile.index')
    ->name('profile')
    ->middleware('api.auth');

Volt::route('/test', 'test');

Route::middleware(['web'])->group(function () {
    Route::post('/pagos/mercadopago/check-config', [PagoController::class, 'checkDisponibilidad'])->name('pago.mp.check');
    Route::post('/pagos/mercadopago/preferencia', [PagoController::class, 'generarPreferencia'])->name('pago.mp.prep');
    Route::get('/pago/exitoso', [PagoController::class, 'exito'])->name('pago.exito');
    Route::get('/pago/fallido', [PagoController::class, 'fallido'])->name('pago.fallido');
});

//Route::any('/pago/exitoso', [PagoController::class, 'exito']);

// Route::prefix('test-design')->group(function () {
//     Route::get('/exito', function () {
//         return view('pagos.exito');
//     });

//     Route::get('/error', function () {
//         return view('pagos.fallido');
//     });
// });
