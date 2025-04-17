<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ordinance_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('ordinances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('ordinance_categories');
            $table->string('title');
            $table->text('content');
            $table->string('ordinance_number')->unique();
            $table->date('date_approved');
            $table->string('file_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordinances');
        Schema::dropIfExists('ordinance_categories');
    }
};