<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile_number')->nullable()->after('email');
            $table->string('address')->nullable()->after('mobile_number');
            $table->date('birthdate')->nullable()->after('address');
            $table->enum('role', ['user', 'admin', 'staff'])->default('user')->after('birthdate');
            $table->string('profile_photo')->nullable()->after('role');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mobile_number', 'address', 'birthdate', 'role', 'profile_photo']);
        });
    }
};