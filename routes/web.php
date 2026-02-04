<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'home.index');

Volt::route('/login', 'auth.login');
Volt::route('/register', 'auth.register');
Volt::route('/my-contracts', 'contracts.index')
    ->name('contracts.index');

Volt::route('/my-contracts/{id}', 'contracts.show')
    ->name('contracts.show');

Volt::route('/test', 'test');
