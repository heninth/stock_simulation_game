<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
            'password' => bcrypt('henhenhen'),
            'cash' => 1000000,
            'port_value' => 1000000,
        ]);
    }
}
