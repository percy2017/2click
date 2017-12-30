<?php

use Illuminate\Database\Seeder;

class CuponTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cupones')->insert([
        	'codigo' => '000001',
            'nombre' => 'Cupon Default',
            'descripcion' => 'Cupon Default',
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
