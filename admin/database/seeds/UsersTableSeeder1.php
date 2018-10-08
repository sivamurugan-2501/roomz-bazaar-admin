<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder1 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table("users")->insert(
			array(
				"name" => "admin",
				"email" => "admin@myportal.com",
				"password" => Hash::make("admin123")
			)
		);
    }
}
