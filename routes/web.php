<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/countries', [CountryController::class, 'index'])
    ->middleware(['auth'])
    ->name('countries.index');

Route::get('/countries/{country}', [CountryController::class, 'show'])
    ->middleware(['auth'])
    ->name('countries.show');

Route::post('/countries/sync', [CountryController::class, 'sync'])
    ->middleware(['auth'])
    ->name('countries.sync');

Route::post('/countries/{country}/exchange-rate', [CountryController::class, 'syncExchangeRate'])
    ->middleware(['auth'])
    ->name('countries.exchange.sync');


require __DIR__.'/auth.php';
