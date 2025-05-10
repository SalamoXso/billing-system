<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerialNumbersTable extends Migration
{
    public function up()
    {
        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('serial');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('serial_numbers');
    }
}
