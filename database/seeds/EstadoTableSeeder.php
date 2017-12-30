<?php

use Illuminate\Database\Seeder;

class EstadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estados')->insert([
            'nombre' => 'Solicitado',
            'descripcion' => 'Estado inicio del pedido',
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
