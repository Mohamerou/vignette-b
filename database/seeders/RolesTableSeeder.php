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
        	'name' => 'Reporteur'
        ]);

        Role::create([
        	'name' => 'superviseur'
        ]);

        Role::create([
            'name' => 'agent_vente'
        ]);      

        Role::create([
            'name' => 'agent_enroll'
        ]);      

        Role::create([
            'name' => 'user'
        ]);
    }
}
