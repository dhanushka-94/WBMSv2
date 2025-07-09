<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GuarantorController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\WaterMeterController;
use App\Http\Controllers\MeterReadingController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// Redirect root to login for admin access
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', UserController::class);
    
    // Settings routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        
        // Division routes
        Route::post('/divisions', [SettingsController::class, 'storeDivision'])->name('divisions.store');
        Route::put('/divisions/{division}', [SettingsController::class, 'updateDivision'])->name('divisions.update');
        Route::delete('/divisions/{division}', [SettingsController::class, 'destroyDivision'])->name('divisions.destroy');
        
        // Customer Type routes
        Route::post('/customer-types', [SettingsController::class, 'storeCustomerType'])->name('customer-types.store');
        Route::put('/customer-types/{customerType}', [SettingsController::class, 'updateCustomerType'])->name('customer-types.update');
        Route::delete('/customer-types/{customerType}', [SettingsController::class, 'destroyCustomerType'])->name('customer-types.destroy');
    });
    
    // Customer Management
    Route::resource('customers', CustomerController::class);
    Route::get('customers/{customer}/meters', [CustomerController::class, 'meters'])->name('customers.meters');
    Route::get('customers/{customer}/bills', [CustomerController::class, 'bills'])->name('customers.bills');
    
    // Guarantor Management
    Route::resource('guarantors', GuarantorController::class);
    
    // Rate Management
    Route::resource('rates', RateController::class);
    Route::post('rates/{rate}/activate', [RateController::class, 'activate'])->name('rates.activate');
    Route::post('rates/{rate}/deactivate', [RateController::class, 'deactivate'])->name('rates.deactivate');
    
    // Water Meter Management
    Route::resource('water-meters', WaterMeterController::class)->names('meters');
    Route::get('meters/map-view', [WaterMeterController::class, 'mapView'])->name('meters.map');
    Route::post('meters/{meter}/maintenance', [WaterMeterController::class, 'recordMaintenance'])->name('meters.maintenance');
    
    // Meter Reading Management
    Route::resource('meter-readings', MeterReadingController::class)->names('readings');
    Route::post('readings/{reading}/verify', [MeterReadingController::class, 'verify'])->name('readings.verify');
    Route::get('readings/bulk-entry', [MeterReadingController::class, 'bulkEntry'])->name('readings.bulk');
    Route::post('readings/bulk-store', [MeterReadingController::class, 'bulkStore'])->name('readings.bulk.store');
    
    // Bill Management
    Route::resource('bills', BillController::class);
    Route::post('bills/generate', [BillController::class, 'generate'])->name('bills.generate');
    Route::post('bills/{bill}/send', [BillController::class, 'send'])->name('bills.send');
    Route::post('bills/{bill}/payment', [BillController::class, 'recordPayment'])->name('bills.payment');
    Route::get('bills/{bill}/print', [BillController::class, 'print'])->name('bills.print');
    
    // Reports
    Route::get('reports/consumption', [DashboardController::class, 'consumptionReport'])->name('reports.consumption');
    Route::get('reports/revenue', [DashboardController::class, 'revenueReport'])->name('reports.revenue');
    Route::get('reports/overdue', [DashboardController::class, 'overdueReport'])->name('reports.overdue');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
