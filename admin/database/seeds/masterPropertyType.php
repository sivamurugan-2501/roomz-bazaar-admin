<?php

use Illuminate\Database\Seeder;

class masterPropertyType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('master_property_type')->insert(
        	['name'=>'1RK']);


       DB::table('master_property_type')->insert(['name'=>'1BHK']);
       DB::table('master_property_type')->insert(['name'=>'2BHK']);
       DB::table('master_property_type')->insert(['name'=>'3BHK']);
       DB::table('master_property_type')->insert(['name'=>'Apartment Studio']);
    }
}
