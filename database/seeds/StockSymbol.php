<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class StockSymbolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'hen',
            'email' => 'tanakit.sr21@gmail.com',
            'password' => bcrypt('henhenhen'),
        ]);
    }
}
