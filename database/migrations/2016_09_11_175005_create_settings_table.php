<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->char('key')->primary();
            $table->text('value')->nullable();
        });

        DB::table('settings')->insert([
            ['key' => 'fee', 'value' => '0.2'],
            ['key' => 'tax', 'value' => '7'],
            ['key' => 'use_time_restriction', 'value' => '1'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
