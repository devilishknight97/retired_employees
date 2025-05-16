<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceFieldsToEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->date('daily_wage_appointment_date')->nullable();
            $table->date('contract_appointment_date')->nullable();
            $table->date('official_appointment_date')->nullable();
            $table->string('grade_at_appointment')->nullable();
            $table->string('grade_at_retirement')->nullable();
            $table->date('grade_received_date')->nullable();
            $table->date('port_transfer_date')->nullable();
            $table->string('previous_department')->nullable();
            $table->date('service_termination_date')->nullable();
            $table->string('termination_reason')->nullable();
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
        });
    }
}
