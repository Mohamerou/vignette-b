<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $superAdminRole = Role::where('name', 'superadmin')->first();
        $adminRole 		= Role::where('name', 'admin')->first();

        $superAdmin = User::create([
        	'lastname' 	=> 'Admin',
        	'firstname' => 'Super',
        	'gender' 	=> '1',
        	'avatar' 	=> 'male.png',
        	'address' 	=> 'Daoudabougou',
        	'phone' 	=> '66651762',
        	'password' 	=> Hash::make('password')
        ]);


        $admin = User::create([
        	'lastname' 	         => 'Admin',
        	'firstname'          => 'Admin',
        	'gender' 	         => '1',
        	'avatar' 	         => 'male.png',
        	'address' 	         => 'Sotuba ACI',
            'isverified'         => 1,
            'administration'     => 'bko',
        	'phone' 	         => '71044846',
        	'password' 	         => Hash::make('password')
        ]);


        $superAdmin->roles()->attach($superAdminRole);
        $admin->roles()->attach($adminRole);
    }
}
