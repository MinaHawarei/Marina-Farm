<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\DailyProductionController;
use App\Http\Controllers\DailyConsumptionController;
use App\Http\Controllers\ExpensesController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/suppliers', function () {
        return view('suppliers');
    })->name('suppliers');


    Route::get('/buffalo', function () {return view('buffalo');})->name('buffalo.index');
    Route::get('/cow', function () {return view('cow.index');})->name('cow.index');


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
    //daily Prodection
     Route::prefix('dailyProdection')->group(function() {
        Route::post('/', [DailyProductionController::class, 'store'])->name('dailyProdection.store');
        Route::get('/{animal}/edit', [DailyProductionController::class, 'edit'])->name('dailyProdection.edit');
        Route::put('/{animal}', [DailyProductionController::class, 'update'])->name('dailyProdection.update');
    });
    //daily Consumption
     Route::prefix('DailyConsumption')->group(function() {
        Route::post('/', [DailyConsumptionController::class, 'store'])->name('DailyConsumption.store');
        Route::get('/{animal}/edit', [DailyConsumptionController::class, 'edit'])->name('DailyConsumption.edit');
        Route::put('/{animal}', [DailyConsumptionController::class, 'update'])->name('DailyConsumption.update');
    });
    //Expenses
     Route::prefix('Expenses')->group(function() {
        Route::post('/', [ExpensesController::class, 'store'])->name('expense.store');
        Route::get('/{animal}/edit', [ExpensesController::class, 'edit'])->name('expense.edit');
        Route::put('/{animal}', [ExpensesController::class, 'update'])->name('expense.update');
    });



    Route::get('/buffalo-calf', [AnimalController::class, 'buffaloCalf'])->name('buffalo.calf');
    Route::get('/buffalo-pregnant', [AnimalController::class, 'buffaloPregnant'])->name('buffalo.pregnant');
    Route::get('/buffalo-dairy', [AnimalController::class, 'buffaloDairy'])->name('buffalo.dairy');
    Route::get('/buffalo-fattening', [AnimalController::class, 'buffaloFattening'])->name('buffalo.fattening');

    Route::get('/cow-calf', [AnimalController::class, 'cowCalf'])->name('cow.calf');
    Route::get('/cow-pregnant', [AnimalController::class, 'cowPregnant'])->name('cow.pregnant');
    Route::get('/cow-dairy', [AnimalController::class, 'cowDairy'])->name('cow.dairy');
    Route::get('/cow-fattening', [AnimalController::class, 'cowFattening'])->name('cow.fattening');

});

require __DIR__.'/auth.php';
