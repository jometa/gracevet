<?php

use Illuminate\Database\Seeder;

class PemilikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('pemiliks')->insert([
          [ 'nama' => 'A', 'alamat' => 'asas', 'no_telp' => '0829391' ],
          [ 'nama' => 'B', 'alamat' => 'ssd', 'no_telp' => '0829391' ],
          [ 'nama' => 'C', 'alamat' => 'ssd', 'no_telp' => '0829391' ]
        ]);
    }
}
