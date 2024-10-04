<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/dashboard/pesage', function () {
        return view('dashboard.pesage');
    })->name('pesage');
    Route::get('/dashboard/facturation', function () {
        return view('dashboard.facturation');
    })->name('facturation');
    Route::get('/dashboard/texteReglementation', function () {
        return view('dashboard.texteReglementation');
    })->name('texteReglementation');
    Route::get('/dashboard/rapport', function () {
        return view('dashboard.rapport');
    })->name('rapport');
    Route::get('/dashboard/caisse', function () {
        return view('dashboard.caisse');
    })->name('caisse');
});
