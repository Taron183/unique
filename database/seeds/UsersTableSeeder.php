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
            'name' => "user",
            'email' => 'user@gmail.com',
            'isAdmin' => 0,
            'password' => bcrypt('user123'),
        ]);

        DB::table('users')->insert([
            'name' => "admin",
            'email' => 'admin@gmail.com',
            'isAdmin' => 1,
            'password' => bcrypt('admin123'),
        ]);
    }
}
