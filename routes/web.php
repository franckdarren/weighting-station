<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesageController;

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

    Route::get('/pesage', [PesageController::class, 'index'])->name('pesage');

    Route::get('/chart-data', function () {
        return [
            'dataPesage' => \App\Models\BonPesee::count(),
            'dataFacture' => \App\Models\FacturePesage::count(),
            'dataFullFacture' => \App\Models\FacturePesage::count(),
            'dataFactureBuy' => \App\Models\FacturePesage::where('statut', 'Payée')->count(),
            'dataFactureNotBuy' => \App\Models\FacturePesage::where('statut', 'En attente de paiement')->count(),
        ];
    });

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
