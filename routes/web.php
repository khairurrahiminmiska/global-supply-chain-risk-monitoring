<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;
use App\Models\Country;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\PortDashboardController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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

Route::post('/countries/{country}/news', [CountryController::class, 'syncNews'])
    ->name('countries.news.sync')
    ->middleware('auth');

Route::post(
    '/countries/{country}/economy',
    [CountryController::class, 'syncEconomy']
)->name('countries.economy');

Route::post(
    '/countries/{country}/weather',
    [CountryController::class,'syncWeather']
)->name('countries.weather.sync');

Route::post(
    '/countries/{country}/risk',
    [CountryController::class,'calculateRisk']
)->middleware('auth')
 ->name('countries.risk.calculate');

 Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])
    ->name('dashboard.chart');

Route::post('/ports/import',[PortController::class,'import'])
    ->name('ports.import');

Route::get('/ports',[
    PortDashboardController::class,
    'index'
])->name('ports.index');


require __DIR__.'/auth.php';
