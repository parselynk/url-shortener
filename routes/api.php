<?php

use App\Http\Controllers\UrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1/url')->group(function () {
    Route::get('/{uuid}', [UrlController::class, 'show']);
    Route::post('/', [UrlController::class, 'store']);
    Route::put('/{uuid}', [UrlController::class, 'update']);
});
