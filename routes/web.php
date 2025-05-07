<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\DailyProductionController;
use App\Http\Controllers\DailyConsumptionController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\DailySaleController;
use App\Http\Controllers\TreasuryController;
use App\Http\Controllers\MilkProductionDetailsController;
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

    Route::post('/milke', [MilkProductionDetailsController::class, 'store'])->name('milk.store');
    Route::put('/milk-records/{milkId}', [MilkProductionDetailsController::class, 'update'])->name('milk.update');
    Route::get('/animals/{animal}/milk-records', [AnimalController::class, 'milkRecords']);


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
        //Route::get('/{id}/edit', [DailyProductionController::class, 'edit'])->name('dailyProdection.edit');
        //Route::put('/{id}', [DailyProductionController::class, 'update'])->name('dailyProdection.update');
    });
    //daily Consumption
     Route::prefix('DailyConsumption')->group(function() {
        Route::post('/', [DailyConsumptionController::class, 'store'])->name('DailyConsumption.store');
        Route::get('/{id}/edit', [DailyConsumptionController::class, 'edit'])->name('DailyConsumption.edit');
        Route::put('/{id}', [DailyConsumptionController::class, 'update'])->name('DailyConsumption.update');
    });
    //Expenses
     Route::prefix('Expenses')->group(function() {
        Route::post('/', [ExpensesController::class, 'store'])->name('expense.store');
        Route::get('/{expense}/edit', [ExpensesController::class, 'edit'])->name('expense.edit');
        Route::put('/{expense}', [ExpensesController::class, 'update'])->name('expense.update');
        Route::delete('/{expense}/destroy', [ExpensesController::class, 'destroy'])->name('expense.destroy');

    });
    //income
     Route::prefix('income')->group(function() {
        Route::post('/', [DailySaleController::class, 'store'])->name('income.store');
        Route::get('/{daily_sale}/edit', [DailySaleController::class, 'edit'])->name('income.edit');
        Route::put('/{daily_sale}', [DailySaleController::class, 'update'])->name('income.update');
        Route::delete('/{daily_sale}/destroy', [DailySaleController::class, 'destroy'])->name('income.destroy');

    });
    // daily
    Route::prefix('daily')->group(function() {
        Route::get('/', [DailyProductionController::class, 'index'])->name('daily.index');
        Route::get('/production', [DailyProductionController::class, 'production'])->name('daily.production');
        Route::get('/consumption', [DailyConsumptionController::class, 'consumption'])->name('daily.consumption');

        Route::get('/production/{daily_production}/edit', [DailyProductionController::class, 'edit'])->name('daily-production.edit');
        Route::put('/production/{daily_production}', [DailyProductionController::class, 'update'])->name('daily-production.update');
        Route::delete('/production/{daily_production}', [DailyProductionController::class, 'destroy'])->name('daily-production.destroy');
        Route::get('/consumption/{daily_consumption}/edit', [DailyConsumptionController::class, 'edit'])->name('daily-consumption.edit');
        Route::put('/consumption/{daily_consumption}', [DailyConsumptionController::class, 'update'])->name('daily-consumption.update');
        Route::delete('/consumption/{daily_consumption}', [DailyConsumptionController::class, 'destroy'])->name('daily-consumption.destroy');
    });
    // treasury
    Route::prefix('treasury')->group(function() {
        Route::get('/', [TreasuryController::class, 'index'])->name('treasury.index');
        Route::get('/income', [TreasuryController::class, 'income'])->name('treasury.income');
        Route::get('/expense', [TreasuryController::class, 'expense'])->name('treasury.expense');
        Route::get('/liabilities', [TreasuryController::class, 'liabilities'])->name('treasury.liabilities');
        Route::get('/receivables', [TreasuryController::class, 'receivables'])->name('treasury.receivables');

        Route::get('/production/{daily_production}/edit', [DailyProductionController::class, 'edit'])->name('daily-production.edit');
        Route::put('/production/{daily_production}', [DailyProductionController::class, 'update'])->name('daily-production.update');
        Route::delete('/production/{daily_production}', [DailyProductionController::class, 'destroy'])->name('daily-production.destroy');
        Route::get('/consumption/{daily_consumption}/edit', [DailyConsumptionController::class, 'edit'])->name('daily-consumption.edit');
        Route::put('/consumption/{daily_consumption}', [DailyConsumptionController::class, 'update'])->name('daily-consumption.update');
        Route::delete('/consumption/{daily_consumption}', [DailyConsumptionController::class, 'destroy'])->name('daily-consumption.destroy');
    });


    Route::get('/buffalo-calf', [AnimalController::class, 'buffaloCalf'])->name('buffalo.calf');
    Route::get('/buffalo-pregnant', [AnimalController::class, 'buffaloPregnant'])->name('buffalo.pregnant');
    Route::get('/buffalo-dairy', [AnimalController::class, 'buffaloDairy'])->name('buffalo.dairy');
    Route::get('/buffalo-dairy-milk', [AnimalController::class, 'buffaloDairyMilk'])->name('milk.index');
    Route::get('/buffalo-fattening', [AnimalController::class, 'buffaloFattening'])->name('buffalo.fattening');

    Route::get('/cow-calf', [AnimalController::class, 'cowCalf'])->name('cow.calf');
    Route::get('/cow-pregnant', [AnimalController::class, 'cowPregnant'])->name('cow.pregnant');
    Route::get('/cow-dairy', [AnimalController::class, 'cowDairy'])->name('cow.dairy');
    Route::get('/cow-fattening', [AnimalController::class, 'cowFattening'])->name('cow.fattening');
    Route::get('/cow-dairy-milk', [AnimalController::class, 'cowDairyMilk'])->name('Cowmilk.index');

});

require __DIR__.'/auth.php';
