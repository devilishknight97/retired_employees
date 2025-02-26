<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // Explicitly specify the table name (optional if it follows Laravel's conventions)
    protected $table = 'employees';

     // If it's not auto-incrementing, adjust this:
     public $incrementing = false; // Set to true if it's auto-incrementing

    // Since our table doesn’t have created_at/updated_at columns
    public $timestamps = false;

    // Specify which fields are mass assignable
    protected $fillable = [
        'employee_number',
        'full_name',
        'workplace',
        'start_work_date',
        'birthdate'
    ];
}
