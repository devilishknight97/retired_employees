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
        'birthdate',
        'daily_wage_appointment_date',
        'contract_appointment_date',
        'official_appointment_date',
        'grade_at_appointment',
        'grade_at_retirement',
        'grade_received_date',
        'port_transfer_date',
        'previous_department',
        'service_termination_date',
        'termination_reason',
    ];
}
