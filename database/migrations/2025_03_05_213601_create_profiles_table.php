<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table

            // Personal Information
            $table->string('position')->nullable(); // Position
            $table->string('branch')->nullable(); // Branch
            $table->integer('age')->nullable(); // Age
            $table->string('contact_number')->nullable(); // Contact Number
            $table->string('sex')->nullable(); // Sex
            $table->string('civil_status')->nullable(); // Civil Status
            $table->string('citizenship')->nullable(); // Citizenship
            $table->string('religion')->nullable(); // Religion
            $table->decimal('weight', 5, 2)->nullable(); // Weight (e.g., 70.5 kg)
            $table->decimal('height', 5, 2)->nullable(); // Height (e.g., 175.0 cm)

            // Birth Information
            $table->date('date_of_birth')->nullable(); // Date of Birth
            $table->string('place_of_birth')->nullable(); // Place of Birth

            // Address Information
            $table->string('present_address')->nullable(); // Present Address
            $table->string('permanent_address')->nullable(); // Permanent Address

            // Profile Picture
            $table->string('profile_picture')->nullable(); 

            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles'); // Drop the table if it exists
    }
};