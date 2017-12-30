<?php

use Illuminate\Database\Seeder;

class PagoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pagos')->insert([
            'nombre' => 'Post Entrega',
            'descripcion' => 'Metodo de pago post entrega.',
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
