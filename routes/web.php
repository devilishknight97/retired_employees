<?php


use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');