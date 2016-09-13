<?php

use Illuminate\Database\Seeder;

class SettingsTabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            ['key' => 'fee', 'value' => 0.2],
            ['key' => 'tax', 'value' => 7],
        ]);
    }
}
