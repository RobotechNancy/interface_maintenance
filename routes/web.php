<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
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
    $logs = Log::orderBy('id', 'desc')->get();
    return view('dashboard', compact('logs'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('log', [LogController::class, 'create'])
->middleware(['auth'])
->name('log');

require __DIR__.'/auth.php';
