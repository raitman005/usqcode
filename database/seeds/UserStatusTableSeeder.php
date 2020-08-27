<?php

use Illuminate\Database\Seeder;
use App\Models\UserStatus;

class UserStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_statuses')->delete();

        $userStatus = new UserStatus;
        $userStatus->status = 'registered';
        $userStatus->save();

        $userStatus = new UserStatus;
        $userStatus->status = 'confirmed';
        $userStatus->save();

        $userStatus = new UserStatus;
        $userStatus->status = 'deactivated';
        $userStatus->save();
    }
}
