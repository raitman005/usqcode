<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class DefaultUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'firstname' => 'Tonya',
            'lastname' => 'Singh',
            'email' => 'agent@123nofee.com',
            'phone_number' => '(516) 256-9422',
            'real_estate_license_number' => '248fd8f4373',
            'company' => 'Union Square Property Management',
            'password' => bcrypt('usqpropagent123')
        ];

        User::create($user);
    }
}
