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
            'email' => 'tanakit.sr21@gmail.com',
            'password' => bcrypt('henhenhen'),
            'cash' => 1000000,
            'port_value' => 1000000,
        ]);
    }
}
