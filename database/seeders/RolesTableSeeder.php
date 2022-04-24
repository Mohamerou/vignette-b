<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
        	'name' => 'superadmin'
        ]);

        Role::create([
        	'name' => 'elu'
        ]);

        Role::create([
        	'name' => 'ordonateur'
        ]);

        Role::create([
        	'name' => 'controle-gestion'
        ]);

        Role::create([
        	'name' => 'dfm'
        ]);

        Role::create([
        	'name' => 'comptable-public'
        ]);

        Role::create([
        	'name' => 'superviseur'
        ]);

        Role::create([
        	'name' => 'regisseur-public'
        ]);

        Role::create([
            'name' => 'guichet'
        ]);   

        Role::create([
            'name' => 'user'
        ]);
    }
}
