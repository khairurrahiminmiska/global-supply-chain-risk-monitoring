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
use App\Http\Controllers\PortMapController;
use App\Http\Controllers\MonitoringLogController;
use App\Http\Controllers\SystemHealthController;
use App\Http\Controllers\WeatherMonitorController;
use App\Http\Controllers\NewsIntelligenceController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\BusinessDashboardController;


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

Route::post('/countries/import', [CountryController::class, 'import'])
    ->middleware('auth')
    ->name('countries.import');

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
)->middleware('auth')->name('countries.economy');

Route::post(
    '/countries/{country}/weather',
    [CountryController::class,'syncWeather']
)->middleware('auth')->name('countries.weather.sync');

Route::post(
    '/countries/{country}/risk',
    [CountryController::class,'calculateRisk']
)->middleware('auth')
 ->name('countries.risk.calculate');

 Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])
    ->name('dashboard.chart');

Route::post('/ports/import',[PortController::class,'import'])
    ->middleware('auth')
    ->name('ports.import');

Route::get('/ports',[
    PortDashboardController::class,
    'index'
])->middleware('auth')->name('ports.index');

Route::get('/ports/map', [PortMapController::class, 'index'])
    ->middleware('auth')
    ->name('ports.map');

Route::get('/risk-score', [
    RiskScoreController::class,
    'index'
])->middleware('auth')->name('risk.index');

Route::get('/risk-score/{riskScore}', [
    RiskScoreController::class,
    'show'
])->middleware('auth')->name('risk.show');

Route::get('/risk-analytics', [
    RiskDashboardController::class,
    'index'
])->middleware('auth')->name('risk.analytics');

Route::get('/risk-alerts', [RiskAlertController::class, 'index'])
    ->middleware('auth')->name('risk-alerts.index');

Route::patch('/risk-alerts/{riskAlert}/read', [RiskAlertController::class, 'markAsRead'])
    ->middleware('auth')->name('risk-alerts.read');

Route::patch('/risk-alerts/read-all', [RiskAlertController::class, 'markAllAsRead'])
    ->middleware('auth')->name('risk-alerts.read-all');

Route::get('/risk-map', [RiskMapController::class, 'index'])
    ->middleware('auth')->name('risk.map');

Route::get('/monitoring-activity', [
    MonitoringLogController::class,
    'index'
])->middleware('auth')->name('monitoring.index');

Route::get('/system-health', [
    SystemHealthController::class,
    'index'
])->middleware('auth')->name('system.health');

Route::get('/weather-monitor', [
    WeatherMonitorController::class,
    'index'
])->middleware('auth')
  ->name('weather.index');

Route::post('/weather-monitor/sync', [
    WeatherMonitorController::class,
    'sync'
])->middleware('auth')
  ->name('weather.sync');

Route::get('/news-intelligence', [
    NewsIntelligenceController::class,
    'index'
])->middleware('auth')
  ->name('news.index');

Route::get('/comparison', [
    ComparisonController::class,
    'index'
])->middleware('auth')
  ->name('comparison.index');

Route::post('/comparison', [
    ComparisonController::class,
    'compare'
])->middleware('auth')
  ->name('comparison.compare');

Route::get('/business-dashboard', [
    BusinessDashboardController::class,
    'index'
])->middleware('auth')
  ->name('business.index');

// Watchlist
Route::get('/watchlist', [\App\Http\Controllers\WatchlistController::class, 'index'])
    ->middleware('auth')->name('watchlist.index');
Route::post('/watchlist/{country}', [\App\Http\Controllers\WatchlistController::class, 'store'])
    ->middleware('auth')->name('watchlist.store');
Route::delete('/watchlist/{watchlist}', [\App\Http\Controllers\WatchlistController::class, 'destroy'])
    ->middleware('auth')->name('watchlist.destroy');

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('index');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [\App\Http\Controllers\AdminController::class, 'userDestroy'])->name('users.destroy');
    Route::get('/ports', [\App\Http\Controllers\AdminController::class, 'ports'])->name('ports');
    Route::delete('/ports/{port}', [\App\Http\Controllers\AdminController::class, 'portDestroy'])->name('ports.destroy');

    Route::get('/articles', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [\App\Http\Controllers\ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [\App\Http\Controllers\ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [\App\Http\Controllers\ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [\App\Http\Controllers\ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [\App\Http\Controllers\ArticleController::class, 'destroy'])->name('articles.destroy');
});

require __DIR__.'/auth.php';
