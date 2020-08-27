<?php

use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->truncate();

        $userType = new UserType;
        $userType->user_type = 'customer';
        $userType->save();

        $userType = new UserType;
        $userType->user_type = 'agent';
        $userType->save();
    }
}
