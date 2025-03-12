<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('government_benefits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('sss_no')->nullable();
            $table->string('pag_ibig_no')->nullable();
            $table->string('philhealth_no')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('employee_no')->nullable();
            $table->date('date_employed')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('government_benefits');
    }
};
