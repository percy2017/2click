<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class RolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'nombre' => 'Cliente',
            'descripcion' => 'Usuario Cliente de Pedidos 2 Click.',
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('roles')->insert([
            'nombre' => 'Administrador',
            'descripcion' => 'Rol de Administrador del Proyecto',
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('roles')->insert([
            'nombre' => 'Proveedor',
            'descripcion' => 'Usuarios administrador de los negocios y productos ofrecidos al publico.',
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('roles')->insert([
            'nombre' => 'Operador',
            'descripcion' => 'Responsable de las operaciones logisticas y administracion de los pedidos.',
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('roles')->insert([
            'nombre' => 'Transportista',
            'descripcion' => 'Usuario responsable de traslado de los productos solicitados.',
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('roles')->insert([
            'nombre' => 'Marketing',
            'descripcion' => 'Usuario responsable de la mercadotecnia y estrategias de mercado.',
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
