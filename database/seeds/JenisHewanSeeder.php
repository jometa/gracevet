<?php

use Illuminate\Database\Seeder;

class JenisHewanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('jenis_hewans')->insert([
          ['nama' => 'Anjing'],
          ['nama' => 'Kucing'],
          ['nama' => 'Kuda'],
          ['nama' => 'Hamster']
        ]);
    }
}
