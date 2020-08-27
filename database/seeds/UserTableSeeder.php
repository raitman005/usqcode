<?php

use Illuminate\Database\Seeder;

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
        DB::table('users')->delete();
        DB::table('users')->insert([
        	[
        		'lastname' => 'Patriarca',
        		'firstname' => 'Teddy', 
        		'email' => 'tedpatriarca@gmail.com', 
        		'password' => bcrypt('test123'), 
        		'role_id' => 1, 
        	],
        ]);
    }
}
