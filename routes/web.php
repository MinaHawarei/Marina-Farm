<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\DailyProductionController;
use App\Http\Controllers\DailyConsumptionController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\DailySaleController;
use App\Http\Controllers\TreasuryController;
use App\Http\Controllers\MilkProductionDetailsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\BuyersController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HealthRecordController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SyncSessionUser;




Route::middleware(['auth', SyncSessionUser::class , 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/milke', [MilkProductionDetailsController::class, 'store'])->name('milk.store');
    Route::post('/health', [HealthRecordController::class, 'store'])->name('health.store');
    Route::put('/milk-records/{milkId}', [MilkProductionDetailsController::class, 'update'])->name('milk.update');
    Route::get('/animals/{animal}/milk-records', [AnimalController::class, 'milkRecords']);
    //profile
    Route::prefix('profile')->group(function() {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
     //animals
     Route::prefix('animals')->group(function() {
        Route::post('/', [AnimalController::class, 'store'])->name('animals.store');
        Route::get('/{animal}/edit', [AnimalController::class, 'edit'])->name('animals.edit');
        Route::put('/{animal}', [AnimalController::class, 'update'])->name('animals.update');
        Route::get('/{animal}/health-records', [AnimalController::class, 'getHealthRecords'])->name('animals.health-records');
    });
    //daily Prodection
     Route::prefix('dailyProdection')->group(function() {
        Route::post('/', [DailyProductionController::class, 'store'])->name('dailyProdection.store');
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
        Route::get('/daily', [TreasuryController::class, 'daily'])->name('treasury.daily');
        Route::get('/production/{daily_production}/edit', [DailyProductionController::class, 'edit'])->name('daily-production.edit');
        Route::put('/production/{daily_production}', [DailyProductionController::class, 'update'])->name('daily-production.update');
        Route::delete('/production/{daily_production}', [DailyProductionController::class, 'destroy'])->name('daily-production.destroy');
        Route::get('/consumption/{daily_consumption}/edit', [DailyConsumptionController::class, 'edit'])->name('daily-consumption.edit');
        Route::put('/consumption/{daily_consumption}', [DailyConsumptionController::class, 'update'])->name('daily-consumption.update');
        Route::delete('/consumption/{daily_consumption}', [DailyConsumptionController::class, 'destroy'])->name('daily-consumption.destroy');
    });

    // stock
    Route::prefix('stock')->group(function() {
        Route::get('/', [DailyProductionController::class, 'index'])->name('stock.index');
        Route::get('/producs', [StockController::class, 'producs'])->name('stock.producs');
        Route::get('/feeds', [StockController::class, 'feeds'])->name('stock.feeds');
        Route::get('/other', [StockController::class, 'other'])->name('stock.other');

    });

    // user
    Route::prefix('user')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/logs', [UserController::class, 'logs'])->name('user.logs');

    });
    // employee
    Route::prefix('employees')->group(function() {
        Route::get('/', [EmployeeController::class, 'index'])->name('user.employees');
        Route::post('/store', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/{user}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/{user}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/{user}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    });

    // tools
    Route::prefix('tools')->group(function() {
        Route::get('/', [ToolController::class, 'index'])->name('tools.index');
        Route::post('/store', [ToolController::class, 'store'])->name('tools.store');
        Route::get('/{user}/edit', [ToolController::class, 'edit'])->name('tools.edit');
        Route::put('/{user}', [ToolController::class, 'update'])->name('tools.update');
        Route::delete('/{user}', [ToolController::class, 'destroy'])->name('tools.destroy');

        Route::get('/schedule', [ToolController::class, 'schedule'])->name('tools.schedule');
    });
    // clients
    Route::prefix('clients')->group(function() {
        Route::get('/', [BuyersController::class, 'index'])->name('clients.index');
        Route::post('/store', [BuyersController::class, 'store'])->name('clients.store');
        Route::get('/{user}/edit', [BuyersController::class, 'edit'])->name('clients.edit');
        Route::put('/{user}', [BuyersController::class, 'update'])->name('clients.update');
        Route::delete('/{user}', [BuyersController::class, 'destroy'])->name('clients.destroy');
        Route::get('/{buyers}/totalAmount', [BuyersController::class, 'totalAmount'])->name('clients.totalAmount');
        Route::get('/{buyers}/totalRemaining', [BuyersController::class, 'totalRemaining'])->name('clients.totalRemaining');
    });
    // suppliers
    Route::prefix('suppliers')->group(function() {
        Route::get('/', [SupplierController::class, 'index'])->name('clients.suppliers');
        Route::post('/store', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::get('/{user}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::put('/{user}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::delete('/{user}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
        Route::get('/{supplier}/totalAmount', [SupplierController::class, 'totalAmount'])->name('suppliers.totalAmount');
        Route::get('/{supplier}/totalRemaining', [SupplierController::class, 'totalRemaining'])->name('suppliers.totalRemaining');

    });
    //buffalo
    Route::prefix('buffalo')->group(function() {
        Route::get('/', function () {return view('buffalo.index');})->name('buffalo.index');
        Route::get('/calf', [AnimalController::class, 'buffaloCalf'])->name('buffalo.calf');
        Route::get('/pregnant', [AnimalController::class, 'buffaloPregnant'])->name('buffalo.pregnant');
        Route::get('/dairy', [AnimalController::class, 'buffaloDairy'])->name('buffalo.dairy');
        Route::get('/dairy-milk', [AnimalController::class, 'buffaloDairyMilk'])->name('milk.index');
        Route::get('/fattening', [AnimalController::class, 'buffaloFattening'])->name('buffalo.fattening');
    });
    //cow
    Route::prefix('cow')->group(function() {
        Route::get('/', function () {return view('cow.index');})->name('cow.index');
        Route::get('/calf', [AnimalController::class, 'cowCalf'])->name('cow.calf');
        Route::get('/pregnant', [AnimalController::class, 'cowPregnant'])->name('cow.pregnant');
        Route::get('/dairy', [AnimalController::class, 'cowDairy'])->name('cow.dairy');
        Route::get('/fattening', [AnimalController::class, 'cowFattening'])->name('cow.fattening');
        Route::get('/dairy-milk', [AnimalController::class, 'cowDairyMilk'])->name('Cowmilk.index');
    });
    //Reports
    Route::prefix('reports')->group(function() {
        Route::get('/production', [ReportController::class, 'production'])->name('reports.production');
        Route::get('/production/export', [ReportController::class, 'exportProductionReport'])->name('reports.production.export');
        Route::get('/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/sales/export', [ReportController::class, 'exportSalesReport'])->name('reports.sales.export');
        Route::get('/financial', [ReportController::class, 'financial'])->name('reports.financial');
        Route::get('/sales/daily-details', [ReportController::class, 'getDailySalesDetailsByCategory'])->name('reports.sales.daily.details');

    });

});

require __DIR__.'/auth.php';
