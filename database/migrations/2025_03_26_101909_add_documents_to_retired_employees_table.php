<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {  // ← Change table name here
            $table->string('documents')->nullable()->after('employee_number');
        });
    }
    
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {  // ← Change table name here
            $table->dropColumn('documents');
        });
    }
};
