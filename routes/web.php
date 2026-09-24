<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::post('/solicitudes', [LeadController::class, 'store'])
    ->middleware('throttle:8,1')
    ->name('leads.store');
