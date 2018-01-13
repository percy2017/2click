<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolTableSeeder::class);
        $this->call(LocalidadTableSeeder::class);
        $this->call(PermisoTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TipoTableSeeder::class);
        $this->call(ProveedorTableSeeder::class);
        $this->call(CategoriaTableSeeder::class);
        $this->call(ReferenciaTableSeeder::class);
        $this->call(PagoTableSeeder::class);
        $this->call(EstadoTableSeeder::class);
        $this->call(CuponTableSeeder::class);
        $this->call(VehiculoTableSeeder::class);
        
      
    }
}
