<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::get('app/', fn() => view('app'));

Route::group(['prefix' => 'app'], function() {

    Route::get('', fn() => view('app')); // This deployes you vuejs app don't touch it

});

/**
 * These are your api routes, define the api routes you need here, you fucked up some laravel configuration the routes are doubled for both web and api everytime
 * you define them in /routes/api.php, just use the one here instead
 */
Route::group(['prefix' => 'api'], function() {

    Route::get('/employees', [EmployeeController::class, 'getEmployees']);
    Route::get('/employees/{employee_number}', [EmployeeController::class, 'getEmployee']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::put('/employees/{employee_number}', [EmployeeController::class, 'update']); // ✅ PUT route
    Route::delete('/employees/{employee_number}', [EmployeeController::class, 'destroy']);
});
/**
 * End of api routes
 */