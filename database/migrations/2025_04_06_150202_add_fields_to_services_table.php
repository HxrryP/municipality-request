<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('payment_required')->default(true)->after('requires_approval');
            $table->string('payment_description')->nullable()->after('payment_required');
        });

        // Update existing services to set payment_required based on fee
        DB::statement('UPDATE services SET payment_required = (fee > 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['payment_required', 'payment_description']);
        });
    }
};