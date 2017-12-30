<?php

use Illuminate\Database\Seeder;

class PermisoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permisos')->insert([
            'nombre' => 'Panel de control (Dashboard)',
            'ruta' => 'admin',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('permisos')->insert([
            'nombre' => 'Usuarios',
            'ruta' => 'admin/usuarios',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('permisos')->insert([
            'nombre' => 'Roles',
            'ruta' => 'admin/roles',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('permisos')->insert([
            'nombre' => 'Permisos',
            'ruta' => 'admin/permisos',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('permisos')->insert([
            'nombre' => 'Notificaciones del Sistema',
            'ruta' => 'admin/notificaciones',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('permisos')->insert([
            'nombre' => 'Lugares de entrega',
            'ruta' => 'admin/lugares',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('permisos')->insert([
            'nombre' => 'Proveedores',
            'ruta' => 'admin/proveedores',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);

        DB::table('permisos')->insert([
            'nombre' => 'Categorias de Productos',
            'ruta' => 'admin/categorias',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('permisos')->insert([
            'nombre' => 'Metodos de Pago',
            'ruta' => 'admin/pagos',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('permisos')->insert([
            'nombre' => 'Estados de Pedidos',
            'ruta' => 'admin/estados',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('permisos')->insert([
            'nombre' => 'Cupones',
            'ruta' => 'admin/cupones',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('permisos')->insert([
            'nombre' => 'Localidades donde operamos',
            'ruta' => 'admin/localidades',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('permisos')->insert([
            'nombre' => 'Refencias de Lugares',
            'ruta' => 'admin/referencias',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('permisos')->insert([
            'nombre' => 'Tipos de Negocios',
            'ruta' => 'admin/tipos',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
        DB::table('permisos')->insert([
            'nombre' => 'Pedidos',
            'ruta' => 'admin/pedidos',
            'rol_id' => 2,
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
