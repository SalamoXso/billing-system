<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('serial_numbers', function (Blueprint $table) {
            // Only add these if they don't already exist
            if (!Schema::hasColumn('serial_numbers', 'product_id')) {
                $table->unsignedBigInteger('product_id')->nullable();
            }

            if (!Schema::hasColumn('serial_numbers', 'serial_number')) {
                $table->string('serial_number')->nullable();
            }

            // Add unique constraint only if it doesn't exist
            $table->unique(['product_id', 'serial_number']);
        });
    }

    public function down()
    {
        Schema::table('serial_numbers', function (Blueprint $table) {
            $table->dropUnique(['product_id', 'serial_number']);
            $table->dropColumn(['product_id', 'serial_number']);
        });
    }
};
