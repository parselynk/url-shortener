<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/**
 * @note due to lack of time and for the sake of simplicity
 * the hit logic was mainly implemented here and in Url::getRediractionPath.
 */
Route::get('/{UUID}', function ($uuid) {
    $url = \App\Models\Url::where('shortcode_uuid', $uuid)->firstOrFail();
    return redirect($url->getRediractionPath());
});
