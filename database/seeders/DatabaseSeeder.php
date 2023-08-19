<?php

namespace Database\Seeders;

use App\User;
use App\Models\MetodoPago;
use App\Models\Tipopago;
use App\Models\Vianda;
use Illuminate\Database\Seeder;
use DB;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(RoleSeeder::class);

        
        /*DB::table('users')->insert([
            'name' => 'Avila David',
            'username' => 'mavila',
            'email' => 'manudva22@gmail.com',
            'password' => bcrypt('33456282'),
            'tipouser_id' => 1
            
        ])->syncRoles('superadmin');*/

        User::create([
            'name' => 'Avila David',
            'username' => 'mavila',
            'email' => 'manudva22@gmail.com',
            'password' => bcrypt('33456282'),
        ])->assignRole('Desarrollador');

        User::create([
            'name' => 'Administrador',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            
        ])->assignRole('Admin');

        User::create([
            'name' => 'Veronica Benitez',
            'username' => 'vbenitez',
            'email' => 'vbenitez@admin.com',
            'password' => bcrypt('123456'),
            
        ])->assignRole('Administrativo');



        /*DB::table('dias')->insert([
            'descripcion' => 'Lunes',
            'activo' => 1
        ]);

        DB::table('dias')->insert([
            'descripcion' => 'Martes',
            'activo' => 1
        ]);

        DB::table('dias')->insert([
            'descripcion' => 'Miercoles',
            'activo' => 1
        ]);


        DB::table('dias')->insert([
            'descripcion' => 'Jueves',
            'activo' => 1
        ]);


        DB::table('dias')->insert([
            'descripcion' => 'Viernes',
            'activo' => 1
        ]);

        DB::table('dias')->insert([
            'descripcion' => 'Sabado',
            'activo' => 0
        ]);

        DB::table('dias')->insert([
            'descripcion' => 'Domingo',
            'activo' => 0
        ]);*/

        MetodoPago::create([
            'descripcion' => 'Otros',
            'dias' => 0,
            'aviso' => 0,
            'activo' => true,
            
        ]);

        Vianda::create([
            'descripcion' => 'Otros',
            'precio' => 0,
            'activo' => true,
            
        ]);

        Tipopago::create([
            'descripcion' => 'Efectivo',
            'activo' => true,
            
        ]);
    
    }


}
