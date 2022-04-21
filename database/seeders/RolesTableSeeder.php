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
        	'name' => 'comptable'
        ]);

        Role::create([
        	'name' => 'direction'
        ]);

        Role::create([
        	'name' => 'regisseur'
        ]);

        Role::create([
        	'name' => 'superviseur'
        ]);

        Role::create([
            'name' => 'agent'
        ]);      

        // Role::create([
        //     'name' => 'agent_enroll'
        // ]);      

        Role::create([
            'name' => 'user'
        ]);
    }
}
