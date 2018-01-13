<?php

use Illuminate\Database\Seeder;

class VehiculoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehiculos')->insert([
            'nombre' => 'Motocicleta',
            'ruedas' => '2 Ruedas',
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
