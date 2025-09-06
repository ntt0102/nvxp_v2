<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            [
                'member_id' => 15,
                'username' => 'tho',
                'password' => Hash::make('1'),
                'email' => 'ntt0102@gmail.com',
                'role' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'member_id' => 13,
                'username' => 'hiep',
                'password' => Hash::make('1'),
                'email' => 'ndhiep1966@gmail.com',
                'role' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
