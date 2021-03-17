<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
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
        //
        $superAdminRole = Role::where('name', 'superadmin')->first();
        $adminRole 		= Role::where('name', 'admin')->first();

        $superAdmin = User::create([
        	'lastname' 	=> Crypt::encryptString('Admin'),
        	'firstname' => Crypt::encryptString('Super'),
        	'gender' 	=> 1,
        	'avatar' 	=> Crypt::encryptString('male.png'),
        	'address' 	=> Crypt::encryptString('Daoudabougou'),
        	'phone' 	=> Crypt::encryptString('66651762'),
        	'password' 	=> Hash::make('password')
        ]);


        $admin = User::create([
        	'lastname' 	         => Crypt::encryptString('Admin'),
        	'firstname'          => Crypt::encryptString('Admin'),
        	'gender' 	         => 1,
        	'avatar' 	         => Crypt::encryptString('male.png'),
        	'address' 	         => Crypt::encryptString('Sotuba ACI'),
            'isverified'         => 1,
            'administration'     => Crypt::encryptString('bko'),
        	'phone' 	         => Crypt::encryptString('71044846'),
        	'password' 	         => Hash::make('password')
        ]);


        $superAdmin->roles()->attach($superAdminRole);
        $admin->roles()->attach($adminRole);
    }
}
