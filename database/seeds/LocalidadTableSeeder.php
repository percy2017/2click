<?php

use Illuminate\Database\Seeder;

class LocalidadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('localidades')->insert([
            'nombre' => 'Sin definir',
            'descripcion' => 'Localidad sin definir',
            'latitud' => 0,
            'longitud' =>0,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('localidades')->insert([
            'nombre' => 'Trinidad, Beni',
            'descripcion' => 'Localidad de trinidad capital del Beni.',
            'latitud' => -14.825832,
            'longitud' =>-64.900025,
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
