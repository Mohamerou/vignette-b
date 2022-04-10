<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TownHall;
use App\Models\Agent;
use App\Models\AgentRef;
use App\Models\Guichet;
use App\Models\Role;
use DB;

class TownHallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $townhall = TownHall::create([
        // 	'name' => 'Mairie du District',
        // 	'ref' => 'bko',
        // ]);


        // $guichet_enroll = Guichet::create([
        // 	'type' => 'enroll',
        // 	'number' => '1',
        //     'ref' => 'enroll1',
        //     'townHallRef' => $townhall->ref,
        // ]);

        // $guichet_sales = Guichet::create([
        // 	'type' => 'sales',
        // 	'number' => '1',
        //     'ref' => 'sales1',
        //     'townHallRef' => $townhall->ref,
        // ]);

        // //
        // $Enroll1 = User::create([
        // 	'lastname' => 'Enroll1',
        // 	'firstname' => 'Agent',
        //     'avatar' => 'avatar.png',
        //     'address' => 'adresse',
        //     'phone' => '61616161',
        //     'isverified' => 1,
        //     'password' => Hash::make('password'),
        // ]);
        // //
        // $Sales1 = User::create([
        // 	'lastname' => 'Vente1',
        // 	'firstname' => 'Agent',
        //     'avatar' => 'avatar.png',
        //     'address' => 'adresse',
        //     'phone' => '62626262',
        //     'isverified' => 1,
        //     'password' => Hash::make('password'),
        // ]);
        // //

        
        // $enrollAgentRef = AgentRef::create([
        //     'townHallRef' => $townhall->ref,
        //     'guichetRef' => $guichet_enroll->ref,
        //     'agentId' => $Enroll1->id,
        // ]);


        // //
        // $salesAgentRef = AgentRef::create([
        //     'townHallRef' => $townhall->ref,
        //     'guichetRef' => $guichet_enroll->ref,
        //     'agentId' => $Sales1->id,
        // ]);

        // $role = Role::select('id')->where('name', 'agent')->first();

        // $Enroll1->roles()->attach($role);
        // $Enroll1->save();

        // $Sales1->roles()->attach($role);
        // $Sales1->save();

    }
}
