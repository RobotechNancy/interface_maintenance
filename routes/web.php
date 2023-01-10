<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\RelaisController;
use App\Models\Log;

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
    return view('home');
});

Route::get('/dashboard', function () {
    $logs = Log::orderBy('id', 'desc')->limit(100)->get();
    return view('dashboard', compact('logs'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('log/{test?}', [LogController::class, 'create'])
->middleware(['auth'])
->name('log');

Route::post('get_logtable_size/{test?}', [LogController::class, 'getLogtableSize'])
->middleware(['auth'])
->name('getLogtableSize');

Route::post('clearlogs/{test?}', [LogController::class, 'clear'])
->middleware(['auth'])
->name('clearlogs');

Route::post('exportlogs/{test?}', [LogController::class, 'export'])
->middleware(['auth'])
->name('exportlogs');

Route::post('relais/{test?}', [RelaisController::class, 'relaisStatus'])
->middleware(['auth'])
->name('relais');

require __DIR__.'/auth.php';
