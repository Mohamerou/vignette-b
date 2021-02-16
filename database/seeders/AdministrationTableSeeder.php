<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Administration;
use DB;

class AdministrationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('administrations')->insert([
        	'name' => 'Mairie du District de Bamako',
        	'code' => 'bko',
        ]);

        DB::table('administrations')->insert([
        	'name' => 'Mairie centrale de Kayes',
        	'code' => 'kayes',
        ]);

        DB::table('administrations')->insert([
        	'name' => 'Mairie centrale de Koulikoro',
        	'code' => 'koulikoro',
        ]);

        DB::table('administrations')->insert([
        	'name' => 'Mairie centrale de Sikasso',
        	'code' => 'sikasso',
        ]);

        DB::table('administrations')->insert([
        	'name' => 'Mairie centrale de Segou',
        	'code' => 'segou',
        ]);

        DB::table('administrations')->insert([
        	'name' => 'Mairie centrale de Mopti',
        	'code' => 'mopti',
        ]);

        DB::table('administrations')->insert([
        	'name' => 'Mairie centrale de Tombouctou',
        	'code' => 'tombouctou',
        ]);

        DB::table('administrations')->insert([
        	'name' => 'Mairie centrale de Gao',
        	'code' => 'gao',
        ]);

        DB::table('administrations')->insert([
        	'name' => 'Mairie centrale de Kidal',
        	'code' => 'kidal',
        ]);
    }
}
