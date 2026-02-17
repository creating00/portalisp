<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\PagoController;

Volt::route('/', 'home.index');

Volt::route('/login', 'auth.login')->name('login');
Volt::route('/register', 'auth.register');
Volt::route('/my-contracts', 'contracts.index')
    ->name('contracts.index');

Volt::route('/my-contracts/{id}', 'contracts.show')
    ->name('contracts.show');

Volt::route('/test', 'test');

Route::middleware(['web'])->group(function () {
    Route::post('/pagos/mercadopago/preferencia', [PagoController::class, 'generarPreferencia'])->name('pago.mp.prep');
    //Route::get('/pago/exitoso', [PagoController::class, 'exito'])->name('pago.exitoso');
    Route::get('/pago/fallido', [PagoController::class, 'fallido'])->name('pago.fallido');
});

Route::any('/pago/exitoso', [App\Http\Controllers\PagoController::class, 'exito']);
