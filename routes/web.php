<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReceiptController;

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

//// These routes do not require authentication
Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

//// These routes require authentication
Route::middleware(['auth'])->group(function() {
    Route::get('/new-admission', function () {
        return view('new-admission');
    });

    Route::get('/income-expense', function () {
        return view('income-expense');
    });

    Route::get('/student-list', function () {
        return view('student-list');
    });

    Route::get('/fee-settings', function () {
        return view('fee-settings');
    });
    
    Route::get('/fee-pay/{roll_no?}', function ($roll_no = '') {
        return view('fee-pay', ['roll_no' => $roll_no]);
    });

    Route::get('/fee-register', function () {
        return view('fee-register');
    });

    Route::get('/print-receipt/{id}', [ReceiptController::class, 'get']);
});

//// Redirect to login page if route not found
Route::fallback(function () {
    return redirect('/');
});