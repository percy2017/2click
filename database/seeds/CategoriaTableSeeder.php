<?php

use Illuminate\Database\Seeder;

class CategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
            'nombre' => 'Comidas o Platillas',
            'descripcion' => 'Categoria para los productos listos para debustar..',
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('categorias')->insert([
            'nombre' => 'Bebidas o Gaseosas',
            'descripcion' => 'Categoria para los productos bebibles en botella, lata y otros.',
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
