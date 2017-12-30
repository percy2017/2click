<?php

use Illuminate\Database\Seeder;

class ReferenciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('referencias')->insert([
            'nombre' => 'Casa o Hogar',
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('referencias')->insert([
            'nombre' => 'Oficina o Trabajo',
            'created_at' => \Carbon\Carbon::now()
        ]);

    }
}
