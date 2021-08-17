<?php

use App\Http\Controllers\ScraperController;
use App\Http\Controllers\SearchController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/search', [SearchController::class, 'showForm'])->name('search');
Route::post('/search', [SearchController::class, 'findMovie']);
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete']);
Route::get('/movie/{movie:id}', [SearchController::class, 'serve'])->name('serve.movie');
Route::get('/scraper', [ ScraperController::class, 'scraper' ]);
