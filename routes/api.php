<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\CountryApiController;
use App\Http\Controllers\Api\PortApiController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\CurrencyApiController;
use App\Http\Controllers\Api\RiskApiController;
use App\Models\RiskScore;

Route::get('/countries', [
    CountryApiController::class,
    'index'
]);

Route::get('/ports', [
    PortApiController::class,
    'index'
]);

Route::get('/news', [
    NewsApiController::class,
    'index'
]);

Route::get('/currency', [
    CurrencyApiController::class,
    'index'
]);

Route::get('/risk', [
    RiskApiController::class,
    'index'
]);

Route::get('/risk', function () {

    $riskScores = RiskScore::with('country')
        ->orderByDesc('total_score')
        ->get();

    return response()->json([
        'success' => true,
        'total' => $riskScores->count(),
        'data' => $riskScores
    ]);

});
