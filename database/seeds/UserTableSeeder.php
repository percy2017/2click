<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@pedidos2click.com',
            'password' => bcrypt('123456'),
            'rol_id' => 2,
            'localidad_id' => 1,
            'created_at' => \Carbon\Carbon::now()
        ]);

       // factory(App\User::class)->create([
       // 	'name' => 'admin',
       // 	'email' => 'admin@pedidos2click.com',
       // 	'password' => bcrypt('123456'),
       //  'rol_id' => 1

       // ]);

       // factory(App\User::class,19)->create();
    }
}
