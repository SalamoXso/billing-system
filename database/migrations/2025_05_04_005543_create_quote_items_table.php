<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained('quotes'); // Assuming the quote_items table is related to the quotes table
            $table->foreignId('product_id')->constrained('products'); // Assuming there's a products table
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('quote_items');
    }
    
};
