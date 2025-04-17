<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // First, drop any existing foreign keys to avoid duplicates
        $this->dropForeignKeys();
        
        Schema::table('requests', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('previous_request_id')->references('id')->on('requests')->onDelete('set null');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['request_id']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['request_id']);
        });

        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['service_id']);
            $table->dropForeign(['previous_request_id']);
        });
    }
    
    private function dropForeignKeys()
    {
        // Drop foreign keys if they exist
        $tables = ['payments', 'requests', 'notifications'];
        
        foreach ($tables as $table) {
            // Get all foreign keys for this table
            $foreignKeys = $this->getForeignKeys($table);
            
            if (!empty($foreignKeys)) {
                Schema::table($table, function (Blueprint $table) use ($foreignKeys) {
                    foreach ($foreignKeys as $key) {
                        $table->dropForeign($key);
                    }
                });
            }
        }
    }
    
    private function getForeignKeys($tableName)
    {
        $database = config('database.connections.mysql.database');
        
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE CONSTRAINT_TYPE = 'FOREIGN KEY'
            AND TABLE_SCHEMA = '{$database}'
            AND TABLE_NAME = '{$tableName}'
        ");
        
        return array_map(function($key) {
            return $key->CONSTRAINT_NAME;
        }, $foreignKeys);
    }
};