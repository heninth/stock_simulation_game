<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockSymbolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_symbols', function (Blueprint $table) {
            $table->string('symbol')->primary();
            $table->decimal('close_price', 6, 2);
            $table->enum('market', ['SET', 'mai']);
            $table->boolean('is_suspended')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_symbols');
    }
}
