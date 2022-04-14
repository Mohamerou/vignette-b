<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Guichet;
use App\Models\TownHall;
use App\Models\AgentRef;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Roles
        $superAdminRole         = Role::where('name', 'superadmin')->first();
        $eluRole                = Role::where('name', 'elu')->first();
        $reporteurRole          = Role::where('name', 'reporteur')->first();
        $superviseurRole 		= Role::where('name', 'superviseur')->first();
        $agent_venteRole 		= Role::where('name', 'agent_vente')->first();
        $agent_enrollRole 		= Role::where('name', 'agent_enroll')->first();
        $userRole               = Role::where('name', 'user')->first();

        //
        $townhall = TownHall::create([
        	'name' => 'Mairie du District',
        	'ref' => 'bko',
        ]);


        // Guichets

        $guichet_enroll1 = Guichet::create([
            'type'          => 'enroll',
            'number'        => '01',
            'townHallRef'   => 'bko',
        ]);

        $guichet_enroll1->ref = $guichet_enroll1->type.$guichet_enroll1->number;
        $guichet_enroll1->save();
        
        $guichet_vente1 = Guichet::create([
            'type'          => 'vente',
            'number'        => '01',
            'townHallRef'   => 'bko',
        ]);

        $guichet_vente1->ref = $guichet_vente1->type.$guichet_vente1->number;
        $guichet_vente1->save();
        



        // System Users
        $superAdmin = User::create([
        	'lastname' 	=> 'Admin',
        	'firstname' => 'Super',
        	'gender' 	=> 1,
        	'avatar' 	=> 'male.png',
        	'address' 	=> 'Daoudabougou',
            'isverified'         => 1,
            'administration'     => 'bko',
        	'phone' 	=> '66651762',
        	'password' 	=> Hash::make('password_secret##')
        ]);


        $elu = User::create([
        	'lastname' 	         => 'Elu(e)',
        	'firstname'          => 'Mr/Mme',
        	'gender' 	         => 1,
        	'avatar' 	         => 'male.png',
        	'address' 	         => 'Sotuba ACI',
            'isverified'         => 1,
            'administration'     => 'bko',
        	'phone' 	         => '70707070',
        	'password' 	         => Hash::make('password')
        ]);

        $reporteur = User::create([
        	'lastname' 	=> 'Reporteur General',
        	'firstname' => 'Mr le',
        	'gender' 	=> 1,
        	'avatar' 	=> 'male.png',
        	'address' 	=> 'Daoudabougou',
            'isverified'         => 1,
            'administration'     => 'bko',
        	'phone' 	=> '71717171',
        	'password' 	=> Hash::make('password')
        ]);


        $superviseur = User::create([
        	'lastname' 	         => 'Superviseur General',
        	'firstname'          => 'Mr le',
        	'gender' 	         => 1,
        	'avatar' 	         => 'male.png',
        	'address' 	         => 'Sotuba ACI',
            'isverified'         => 1,
            'administration'     => 'bko',
        	'phone' 	         => '72727272',
        	'password' 	         => Hash::make('password')
        ]);

        $agent1_vente = User::create([
        	'lastname' 	=> 'Vente',
        	'firstname' => 'Agent',
        	'gender' 	=> 1,
        	'avatar' 	=> 'male.png',
        	'address' 	=> 'Daoudabougou',
            'isverified'         => 1,
            'administration'     => $superviseur->administration,
        	'phone' 	=> '61616161',
        	'password' 	=> Hash::make('password')
        ]);


        $agent1_enroll = User::create([
        	'lastname' 	         => 'Enroll',
        	'firstname'          => 'Agent',
        	'gender' 	         => 1,
        	'avatar' 	         => 'male.png',
        	'address' 	         => 'Sotuba ACI',
            'isverified'         => 1,
            'administration'     => $superviseur->administration,
        	'phone' 	         => '62626262',
        	'password' 	         => Hash::make('password')
        ]);

        $usager = User::create([
        	'lastname' 	=> 'Usager',
        	'firstname' => 'Mr',
        	'gender' 	=> 1,
        	'avatar' 	=> 'male.png',
        	'address' 	=> 'Daoudabougou',
            'isverified'=> 1,
        	'phone' 	=> '60690343',
        	'password' 	=> Hash::make('password')
        ]);


        // Agent References

        $agent_enroll1_ref  = AgentRef::create([
            'townHallref'       => $superviseur->administration,
            'guichetRef'        => $guichet_enroll1->ref,
            'agentId'           => $agent1_enroll->id,
        ]);

        $agent_vente1_ref   = AgentRef::create([
            'townHallref'       => $superviseur->administration,
            'guichetRef'        => $guichet_vente1->ref,
            'agentId'           => $agent1_vente->id,
        ]);


        


        $superAdmin->roles()->attach($superAdminRole);
        $elu->roles()->attach($eluRole);

        $reporteur->roles()->attach($reporteurRole);
        $superviseur->roles()->attach($superviseurRole);

        $agent1_enroll->roles()->attach($agent_enrollRole);
        $agent1_vente->roles()->attach($agent_venteRole);

        $usager->roles()->attach($userRole);
    }
}
