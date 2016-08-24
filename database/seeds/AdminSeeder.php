<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new \App\Role;
        $admin->name         = 'admin';
        $admin->display_name = 'Administrador'; // optional
        $admin->description  = 'Administrador de permisos del sitio'; // optional
        $admin->save();

        $driver = new \App\Role;
        $driver->name         = 'driver';
        $driver->display_name = 'Conductor'; // optional
        $driver->description  = 'Conductor de las unidades'; // optional
        $driver->save();

        $accountant = new \App\Role;
        $accountant->name         = 'accountant';
        $accountant->display_name = 'Contador'; // optional
        $accountant->description  = 'Encargado de la autorización de los viajes'; // optional
        $accountant->save();

        $user = \App\User::create([
            'username' => 'adminadhl',
            'name' => 'Administrador',
            'password' => bcrypt('123456'),
            'email'=>'correo@c.com'
        ]);

        $user2 = \App\User::create([
            'username' => 'chofer1',
            'name' => 'Chofer #1',
            'password' => bcrypt('123456'),
            'email'=>'correo@c1.com'
        ]);

        $user3 = \App\User::create([
            'username' => 'contador1',
            'name' => 'Contador #1',
            'password' => bcrypt('123456'),
            'email'=>'correo@c2.com'
        ]);

        $user->attachRole($admin);
    }
}
