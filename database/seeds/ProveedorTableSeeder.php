<?php

use Illuminate\Database\Seeder;

class ProveedorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proveedores')->insert([
            'nombre_comercial' => 'Mi Licoreria',
            'direccion' => 'Calle Hnos. del castillo casi esq. Tarope',
            'whatsapp' => '71130523',
            'user_id' => 1,
            'tipo_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('proveedores')->insert([
            'nombre_comercial' => 'Mi Restoran',
            'direccion' => 'Calle Hnos. del castillo casi esq. Tarope',
            'whatsapp' => '71130523',
            'user_id' => 1,
            'tipo_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
