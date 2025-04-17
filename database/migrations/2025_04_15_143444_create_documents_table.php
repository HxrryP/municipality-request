<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('request_id'); // Foreign key to the requests table
            $table->string('file_url'); // Path to the uploaded file
            $table->string('hash', 64)->unique(); // File hash to prevent duplication
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
