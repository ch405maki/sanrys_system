<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('educational_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to users table
            $table->string('college')->nullable();
            $table->string('college_course')->nullable();
            $table->string('college_school_year')->nullable();
            $table->string('secondary')->nullable();
            $table->string('secondary_course')->nullable();
            $table->string('secondary_school_year')->nullable();
            $table->string('elementary')->nullable();
            $table->string('elementary_course')->nullable();
            $table->string('elementary_school_year')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('educational_backgrounds');
    }
};
