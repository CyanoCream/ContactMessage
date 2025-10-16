<?php

use App\Http\Controllers\ContactMessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('contacts.index');
});

Route::middleware('auth')->group(function () {
    // Contact Messages Routes
    Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contacts.index');
    Route::get('/contact-messages/create', [ContactMessageController::class, 'create'])->name('contacts.create');
    Route::post('/contact-messages', [ContactMessageController::class, 'store'])->name('contacts.store');
    Route::get('/contact-messages/{id}', [ContactMessageController::class, 'show'])->name('contacts.show');
    Route::put('/contact-messages/{id}/status', [ContactMessageController::class, 'updateStatus'])->name('contacts.update-status');
    Route::delete('/contact-messages/{id}', [ContactMessageController::class, 'destroy'])->name('contacts.destroy');
});

require __DIR__.'/auth.php';
