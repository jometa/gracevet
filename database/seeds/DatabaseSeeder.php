<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(JenisHewanSeeder::class);
        $this->call(RasSeeder::class);
        $this->call(PemilikSeeder::class);
        $this->call(TipeHasilLabSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
