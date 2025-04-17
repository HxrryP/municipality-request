<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->unsignedBigInteger('service_id');
            $table->string('tracking_number')->unique();
            $table->enum('status', ['pending', 'processing', 'payment_required', 'ready_for_pickup', 'completed', 'rejected'])->default('pending');
            $table->text('remarks')->nullable();
            $table->json('form_data')->nullable();
            $table->json('document_urls')->nullable();
            $table->boolean('is_renewal')->default(false);
            $table->unsignedBigInteger('previous_request_id')->nullable();
            $table->timestamps();
            
            // Add foreign key constraints after all tables are created
            // These will be added in a separate migration
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
};