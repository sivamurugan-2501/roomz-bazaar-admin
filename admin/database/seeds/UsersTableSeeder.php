<?php 
	class UsersTableSeeder extends Seeder{
			public function run(){
				//DB::table("users");
				DB::table('users')->insert(
					array(
						"name" : "admin",
						"email" : "admin@myportal.com",
						"password" : Hash::make("admin123")
					)
				);
			}
	}