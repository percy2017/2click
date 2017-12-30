<?php

use Illuminate\Database\Seeder;

class TipoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos')->insert([
            'nombre' => 'Restorante',
            'descripcion' => 'Negocio local de expendio de comidas y bebidas.'
        ]);
        DB::table('tipos')->insert([
            'nombre' => 'Licoreria',
            'descripcion' => 'Negocio local de expendio de bebidas.'
        ]);
    }
}
