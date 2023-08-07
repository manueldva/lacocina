<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Desarrollador']);
        $role2 = Role::create(['name' => 'Admin']);
        $role3 = Role::create(['name' => 'Administrativo']);
        
        permission::create(['name' => 'home', 'description' => 'Solo Lectura', 'father' => 'Tablero'])->syncRoles([$role2,$role3]);

        
        permission::create(['name' => 'manageusers.index', 'description' => 'Solo Lectura', 'father' => 'Usuario'])->syncRoles([$role2]);
        permission::create(['name' => 'manageusers.show', 'description' => 'Detalle', 'father' => 'Usuario'])->syncRoles([$role2]);
        permission::create(['name' => 'manageusers.create', 'description' => 'Alta', 'father' => 'Usuario'])->syncRoles([$role2]);
        permission::create(['name' => 'manageusers.edit', 'description' => 'Modi', 'father' => 'Usuario'])->syncRoles([$role2]);
        permission::create(['name' => 'manageusers.destroy', 'description' => 'Baja', 'father' => 'Usuario'])->syncRoles([$role2]);

        permission::create(['name' => 'roles.index', 'description' => 'Solo Lectura', 'father' => 'Rol'])->syncRoles([$role2]);
        permission::create(['name' => 'roles.show', 'description' => 'Detalle', 'father' => 'Rol'])->syncRoles([$role2]);
        permission::create(['name' => 'roles.create', 'description' => 'Alta', 'father' => 'Rol'])->syncRoles([$role2]);
        permission::create(['name' => 'roles.edit', 'description' => 'Modi', 'father' => 'Rol'])->syncRoles([$role2]);
        permission::create(['name' => 'roles.destroy', 'description' => 'Baja', 'father' => 'Rol'])->syncRoles([$role2]);

        permission::create(['name' => 'clientes.index', 'description' => 'Solo Lectura', 'father' => 'Cliente'])->syncRoles([$role2,$role3]);
        permission::create(['name' => 'clientes.show', 'description' => 'Detalle', 'father' => 'Cliente'])->syncRoles([$role2,$role3]);
        permission::create(['name' => 'clientes.create', 'description' => 'Alta', 'father' => 'Cliente'])->syncRoles([$role2,$role3]);
        permission::create(['name' => 'clientes.edit', 'description' => 'Modi', 'father' => 'Cliente'])->syncRoles([$role2,$role3]);
        permission::create(['name' => 'clientes.destroy', 'description' => 'Baja', 'father' => 'Cliente'])->syncRoles([$role2,$role3]);

        permission::create(['name' => 'complementos.index', 'description' => 'Solo Lectura', 'father' => 'Complemento'])->syncRoles([$role2,$role3]);
        permission::create(['name' => 'complementos.show', 'description' => 'Detalle', 'father' => 'Complemento'])->syncRoles([$role2,$role3]);
        permission::create(['name' => 'complementos.create', 'description' => 'Alta', 'father' => 'Complemento'])->syncRoles([$role2,$role3]);
        permission::create(['name' => 'complementos.edit', 'description' => 'Modi', 'father' => 'Complemento'])->syncRoles([$role2,$role3]);
        permission::create(['name' => 'complementos.destroy', 'description' => 'Baja', 'father' => 'Complemento'])->syncRoles([$role2,$role3]);

        permission::create(['name' => 'viandas.index', 'description' => 'Solo Lectura', 'father' => 'Vianda'])->syncRoles([$role2,$role3]);
        permission::create(['name' => 'viandas.show', 'description' => 'Detalle', 'father' => 'Vianda'])->syncRoles([$role2,$role3]);
        permission::create(['name' => 'viandas.create', 'description' => 'Alta', 'father' => 'Vianda'])->syncRoles([$role2,$role3]);
        permission::create(['name' => 'viandas.edit', 'description' => 'Modi', 'father' => 'Vianda'])->syncRoles([$role2,$role3]);
        permission::create(['name' => 'viandas.destroy', 'description' => 'Baja', 'father' => 'Vianda'])->syncRoles([$role2,$role3]);
        /*
        permission::create(['name' => 'planes.index'])->syncRoles([$role1,$role2]);
        permission::create(['name' => 'planes.create'])->syncRoles([$role1,$role2]);
        permission::create(['name' => 'planes.edit'])->syncRoles([$role1,$role2]);
        permission::create(['name' => 'planes.destroy'])->syncRoles([$role1,$role2]);

        permission::create(['name' => 'tiporepeticiones.index'])->syncRoles([$role1,$role2]);
        permission::create(['name' => 'tiporepeticiones.create'])->syncRoles([$role1,$role2]);
        permission::create(['name' => 'tiporepeticiones.edit'])->syncRoles([$role1,$role2]);
        permission::create(['name' => 'tiporepeticiones.destroy'])->syncRoles([$role1,$role2]);

        permission::create(['name' => 'ejercicios.index'])->syncRoles([$role1,$role2]);
        permission::create(['name' => 'ejercicios.create'])->syncRoles([$role1,$role2]);
        permission::create(['name' => 'ejercicios.edit'])->syncRoles([$role1,$role2]);
        permission::create(['name' => 'ejercicios.destroy'])->syncRoles([$role1,$role2]);
        */

        permission::create(['name' => 'informes.index', 'description' => 'Solo Lectura', 'father' => 'Informe']);
        permission::create(['name' => 'informes.show', 'description' => 'Detalle', 'father' => 'Informe']);
    }
}
