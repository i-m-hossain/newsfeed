<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'verified'])->group(function(){
    Route::prefix('chirps')->group(function(){
        Route::get('/', [ChirpController::class ,'index'])->name('chirps.index');
        Route::post('/', [ChirpController::class ,'store'])->name('chirps.store');
        Route::patch('/{chirp}', [ChirpController::class ,'update'])->name('chirps.update');
        Route::delete('/{chirp}', [ChirpController::class ,'destroy'])->name('chirps.destroy');
        Route::get('/{chirp}/edit', [ChirpController::class ,'edit'])->name('chirps.edit');
        Route::get('/{chirp}/comments', [CommentController::class ,'create'])->name('chirps.comment.create');
        Route::post('/{chirp}/comments', [CommentController::class ,'store'])->name('chirps.comment.store');
    });
    Route::prefix('comment')->group(function(){
        Route::get('/{comment}/edit', [CommentController::class ,'edit'])->name('comment.edit');
        Route::patch('/{comment}', [CommentController::class, 'update'])->name('comment.update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
    });
});
require __DIR__.'/auth.php';
