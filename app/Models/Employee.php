<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'employee_number',
        'full_name',
        'workplace',
        'start_work_date',
        'birthdate'
    ];
}
