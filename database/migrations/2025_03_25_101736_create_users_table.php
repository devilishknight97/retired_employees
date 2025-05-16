<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique(); // Username field
            $table->string('name'); // Full name
            $table->string('password'); // Password field
            $table->rememberToken(); // For authentication
            $table->timestamps(); // Created_at and Updated_at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
