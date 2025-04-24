<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnimalController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/suppliers', function () {
        return view('suppliers');
    })->name('suppliers');


    Route::get('/buffalo', function () {return view('buffalo');})->name('buffalo');
    Route::get('/buffalo-calf', function () {return view('buffalo-calf');})->name('buffalo.calf');
    Route::get('/buffalo-dairy', function () {return view('buffalo-dairy');})->name('buffalo.dairy');
    Route::get('/buffalo-fattening', function () {return view('buffalo-fattening');})->name('buffalo.fattening');
    Route::get('/buffalo-pregnant', function () {return view('buffalo-pregnant');})->name('buffalo.pregnant');
    //dd(auth()->check());


});
    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/animals', [AnimalController::class, 'store'])->name('animals.store');

});

require __DIR__.'/auth.php';
