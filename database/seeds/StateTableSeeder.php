<?php

use Illuminate\Database\Seeder;
use App\Models\State;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = public_path() . "/import/states.csv";
        
        $handle = fopen($filePath, "r");
        $header = true;
        $cnt = 0;
        while ($state = fgetcsv($handle, 0, ",")) {
            if ($header) {
                $header = false;
            } else {
                State::create(['state_name' => $state[0], 'state_code' => $state[1]]);
            }
        }

        
    }
}
