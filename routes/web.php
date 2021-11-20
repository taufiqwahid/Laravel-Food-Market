<?php

use App\Http\Controllers\API\MidtransController;
use App\Http\Controllers\DashboardController;
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

// HOMEPAGE
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// DASHBOARD
Route::prefix('dashboard')->middleware('auth:sanctum', 'admin')->group(
    function () {
        return Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    }
);

// Midtrans related
Route::get('midtrans/success', [MidtransController::class, 'success']);
Route::get('midtrans/unfinish', [MidtransController::class, 'unfinish']);
Route::get('midtrans/error', [MidtransController::class, 'error']);
