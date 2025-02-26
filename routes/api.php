<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ExpenseController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('student')->group(function () {
    Route::post('/create', [StudentController::class, 'create']);
    Route::post('/edit/{uuid}', [StudentController::class, 'edit']);
    Route::get('/get/{uuid}', [StudentController::class, 'get']);
    Route::get('/getByRollNo/{roll_no}', [StudentController::class, 'getByRollNo']);
    Route::get('/list', [StudentController::class, 'list']);
    Route::get('/listFees/{standard}', [StudentController::class, 'listFees']);
    Route::delete('/delete/{uuid}', [StudentController::class, 'delete']);
});

Route::prefix('fee')->group(function() {
    Route::get('/get/{standard}/{medium}', [FeeController::class, 'get']);
    Route::get('/list/{medium}', [FeeController::class, 'list']);
    Route::post('/edit/{standard}/{medium}', [FeeController::class, 'edit']);
    Route::post('/pay/{studentUUID}', [FeeController::class, 'pay']);
});

Route::prefix('receipt')->group(function() {
    Route::get('/list/{studentUUID}', [ReceiptController::class, 'list']);
});

Route::prefix('expense')->group(function() {
    Route::get('/list', [ExpenseController::class, 'list']);
    Route::post('/create', [ExpenseController::class, 'create']);
});