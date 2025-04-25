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
    Route::get('/buffalo-fattening', function () {return view('buffalo-fattening');})->name('buffalo.fattening');


});
    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

     // مسارات الحيوانات
     Route::prefix('animals')->group(function() {
        Route::post('/', [AnimalController::class, 'store'])->name('animals.store');
        Route::get('/{animal}/edit', [AnimalController::class, 'edit'])->name('animals.edit');
        Route::put('/{animal}', [AnimalController::class, 'update'])->name('animals.update');

        Route::get('/{animal}/health-records', [AnimalController::class, 'getHealthRecords'])->name('animals.health-records');
    });



    Route::get('/buffalo-calf', [AnimalController::class, 'buffaloCalf'])->name('buffalo.calf');
    Route::get('/buffalo-pregnant', [AnimalController::class, 'buffaloPregnant'])->name('buffalo.pregnant');
    Route::get('/buffalo-dairy', [AnimalController::class, 'buffaloDairy'])->name('buffalo.dairy');
    Route::get('/buffalo-fattening', [AnimalController::class, 'buffaloFattening'])->name('buffalo.fattening');

});

require __DIR__.'/auth.php';
