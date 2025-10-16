<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactMessageApiController;

Route::prefix('contact')->group(function () {
    Route::post('/send', [ContactMessageApiController::class, 'store']);
    Route::get('/{id}', [ContactMessageApiController::class, 'show'])->where('id', '[0-9]+');
});
