<?php

use App\Models\Ticket;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesageController;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/tickets/{ticket}', function (Ticket $ticket) {
    $ticket->load('messages'); // Charger la relation messages
    return view('ticket-details', ['ticket' => $ticket]);
})->name('ticket-details');

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

    //Routes des rapports
    Route::get('dashboard/rapport/pesee', function () {
        return view('dashboard.rapport.pesee');
    })->name('rapport-pesee');
    Route::get('dashboard/rapport/facture', function () {
        return view('dashboard.rapport.facture');
    })->name('rapport-facture');
    Route::get('dashboard/rapport/vehicule', function () {
        return view('dashboard.rapport.vehicule');
    })->name('rapport-vehicule');
    Route::get('dashboard/rapport/entreprise', function () {
        return view('dashboard.rapport.entreprise');
    })->name('rapport-entreprise');
    Route::get('dashboard/rapport/conducteur', function () {
        return view('dashboard.rapport.conducteur');
    })->name('rapport-conducteur');
    Route::get('dashboard/rapport/marchandise', function () {
        return view('dashboard.rapport.marchandise');
    })->name('rapport-marchandise');

    Route::get('/dashboard/caisse', function () {
        return view('dashboard.caisse');
    })->name('caisse');
    Route::get('/dashboard/users', function () {
        return view('dashboard.users');
    })->name('users');
    Route::get('/dashboard/supports', function () {
        return view('dashboard.supports');
    })->name('supports');
});
