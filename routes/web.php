<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;
use App\Models\Country;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\PortDashboardController;
use App\Http\Controllers\RiskScoreController;
use App\Http\Controllers\RiskDashboardController;
use App\Http\Controllers\RiskAlertController;
use App\Http\Controllers\RiskMapController;
use App\Http\Controllers\MonitoringLogController;


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

Route::get('/risk-score', [
    RiskScoreController::class,
    'index'
])->name('risk.index');

Route::get('/risk-score/{riskScore}', [
    RiskScoreController::class,
    'show'
])->name('risk.show');

Route::get('/risk-analytics', [
    RiskDashboardController::class,
    'index'
])->name('risk.analytics');

Route::get('/risk-alerts', [RiskAlertController::class, 'index'])
    ->name('risk-alerts.index');

Route::patch('/risk-alerts/{riskAlert}/read', [RiskAlertController::class, 'markAsRead'])
    ->name('risk-alerts.read');

Route::patch('/risk-alerts/read-all', [RiskAlertController::class, 'markAllAsRead'])
    ->name('risk-alerts.read-all');

Route::get('/risk-map', [RiskMapController::class, 'index'])
    ->name('risk.map');

Route::get('/monitoring-activity', [
    MonitoringLogController::class,
    'index'
])
    ->middleware('auth')
    ->name('monitoring.index');
require __DIR__.'/auth.php';
