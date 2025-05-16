<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('app/', fn() => view('app'));



Route::group(['prefix' => 'app'], function () {
    Route::get('', fn() => view('app')); // Deploys VueJS app (don't touch)
    
});

/**
 * API routes
 */
Route::group(['prefix' => 'api'], function () {

    Route::get('/employees', [EmployeeController::class, 'getEmployees']);
    Route::get('/employees/{employee_number}', [EmployeeController::class, 'getEmployee']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::put('/employees/{employee_number}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{employee_number}', [EmployeeController::class, 'destroy']);

    Route::post('/employees/{employee_number}/upload', [EmployeeController::class, 'uploadFile']);
    Route::delete('/employees/{employee_number}/employee_documents/{filename}', [EmployeeController::class, 'deleteDocument'])->where('filename', '.*');

    Route::post('/employees/{employee_number}/picture', [EmployeeController::class, 'uploadPicture']);
    Route::post('/employees/{employee_number}/scan', [EmployeeController::class, 'scanDocument']);

    Route::get('app/employees/search', [EmployeeController::class, 'search']);
    Route::post('/app/login', [LoginController::class, 'login']);
});

// no more "upload/scanned/{employeeNumber}" route!
// no duplicate '/documents/upload'
