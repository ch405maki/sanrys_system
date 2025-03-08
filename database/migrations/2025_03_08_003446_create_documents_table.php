<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link to the user
            $table->string('document_name'); // Name of the document
            $table->text('description')->nullable(); // Description of the document (optional)
            $table->string('document_type'); // Type of document (e.g., ID, Resume, Contract)
            $table->string('document_path'); // Path to the uploaded document
            $table->string('status')->default('pending'); // Status of the document (e.g., pending, approved, rejected)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
}