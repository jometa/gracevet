<?php

use Illuminate\Database\Seeder;

class RasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('ras')->insert([
          ['nama' => 'Ras 1'],
          ['nama' => 'Ras 2'],
          ['nama' => 'Ras 3'],
          ['nama' => 'Ras 4'],
          ['nama' => 'Ras 5'],
          ['nama' => 'Ras 6'],
          ['nama' => 'Ras 7'],
          ['nama' => 'Ras 8']
        ]);
    }
}
