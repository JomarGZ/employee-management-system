<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('employees', EmployeeController::class);
    Route::get('export', [EmployeeController::class, 'exportCSV'])->name('export');
    Route::delete('exports/download/{export}', [EmployeeController::class, 'exportCleanUp'])->name('employees.export.delete');
    Route::post('import', [EmployeeController::class, 'importCSV'])->name('import');
});
