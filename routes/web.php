<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeImportController;
use App\Http\Controllers\EmployeesExportController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware('guestOnly');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::post('employees/export', [EmployeesExportController::class, 'store'])->name('export');
    Route::delete('exports/download/{export}', [EmployeesExportController::class, 'destroy'])->name('employees.export.delete');
    Route::post('employees/Import', EmployeeImportController::class)->name('import');
});

Route::get('test/log', function () {
    Log::info('This is a test log');
})->name('test');
