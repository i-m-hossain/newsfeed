<?php

use App\Http\Controllers\api\v1\order\OrderController;
use App\Jobs\ProcessLoop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function () {
    Route::get('/order', [OrderController::class, 'getAllOrder'])->name('getAllOrder');
    Route::get('/test/1', function () {
        dispatch(new ProcessLoop(100000));
        return "hello from test 122";
    });
    Route::get("/test/2", function () {
        return "hello world from test 2";
    });
});