<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MarqueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('marques')->insert([
        	'name' => 'BMW',
        ]);
        DB::table('marques')->insert([
        	'name' => 'BOXER',
        ]);
        DB::table('marques')->insert([
        	'name' => 'DUCATI',
        ]);
        DB::table('marques')->insert([
        	'name' => 'HAOJUE',
        ]);
        DB::table('marques')->insert([
        	'name' => 'HONDA',
        ]);
        DB::table('marques')->insert([
        	'name' => 'KAWASAKI',
        ]);
        DB::table('marques')->insert([
        	'name' => 'KTM',
        ]);
        DB::table('marques')->insert([
        	'name' => 'PEUGEOT',
        ]);
        DB::table('marques')->insert([
        	'name' => 'ROYAL',
        ]);
        DB::table('marques')->insert([
        	'name' => 'SUZUKI',
        ]);
        DB::table('marques')->insert([
        	'name' => 'TVS',
        ]);
        DB::table('marques')->insert([
        	'name' => 'YAMAHA',
        ]);
        DB::table('marques')->insert([
        	'name' => '_AUTRE',
        ]);
    }
}
