<?php

use Illuminate\Database\Seeder;

class TipeHasilLabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tipe_hasil_labs')->insert([
          [ 'nama' => 'Feses', 
            'struktur' => json_encode([
              [
                'name' => 'natif',
                'type' => 'string',
                'value' => '--'
              ],
              [
                'name' => 'centrifuse',
                'type' => 'number',
                'value' => 0
              ]
            ]) 
          ],
          [ 'nama' => 'Kulit', 
            'struktur' => json_encode([
              [
                'name' => 'kerokan',
                'type' => 'string',
                'value' => '--'
              ],
              [
                'name' => 'wood_lamp',
                'type' => 'string',
                'value' => ''
              ]
            ]) 
          ]
        ]);
    }
}
