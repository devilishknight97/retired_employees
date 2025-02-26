<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/employees', [EmployeeController::class, 'getEmployees']);
Route::get('/employees/{employee_number}', [EmployeeController::class, 'getEmployee']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::put('/employees/{employee_number}', [EmployeeController::class, 'update']); // ✅ PUT route
Route::delete('/employees/{employee_number}', [EmployeeController::class, 'destroy']);
