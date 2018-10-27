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
        //
        DB::table('users')->insert([
          'name' => 'Super Admin',
          'email' => 'super-admin@gmail.com',
          'password' => bcrypt('something')
        ]);
    }
}
