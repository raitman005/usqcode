<?php

use Illuminate\Database\Seeder;
use App\Models\Neighborhood;

class NeighborhoodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Neighborhood::query()->truncate();
        $manhattanNeighborhoods = [
            // ['neighborhood' => 'Battery Park City', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'Bowery', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'Chinatown', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'Civic Center', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'East Village', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'Financial District', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'Greenwich Village', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'Little Italy', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'Lower East Side', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'NoHo', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'NoLita', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'SoHo', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'Tribeca', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'Two Bridges', 'section' => 'Downtown Manhattan'],
            // ['neighborhood' => 'West Village', 'section' => 'Downtown Manhattan'],

            // ['neighborhood' => 'Chelsea', 'section' => 'Midtown Manhattan'],
            // ['neighborhood' => 'Flatiron District', 'section' => 'Midtown Manhattan'],
            // ['neighborhood' => 'Garment District', 'section' => 'Midtown Manhattan'],
            // ['neighborhood' => 'Gramercy Park', 'section' => 'Midtown Manhattan'],
            // ['neighborhood' => "Hell's Kitchen", 'section' => 'Midtown Manhattan'],
            // ['neighborhood' => 'Kips Bay', 'section' => 'Midtown Manhattan'],
            // ['neighborhood' => 'Koreatown', 'section' => 'Midtown Manhattan'],
            // ['neighborhood' => 'Midtown East', 'section' => 'Midtown Manhattan'],
            // ['neighborhood' => 'Murray Hill', 'section' => 'Midtown Manhattan'],
            // ['neighborhood' => 'NoMad', 'section' => 'Midtown Manhattan'],
            // ['neighborhood' => 'Stuyvesant Town - Peter Cooper Village', 'section' => 'Midtown Manhattan'],
            // ['neighborhood' => 'Theater District', 'section' => 'Midtown Manhattan'],

            // ['neighborhood' => 'Central Harlem', 'section' => 'Upper Manhattan'],
            // ['neighborhood' => 'Central Park', 'section' => 'Upper Manhattan'],
            // ['neighborhood' => 'East Harlem', 'section' => 'Upper Manhattan'],
            // ['neighborhood' => 'Inwood', 'section' => 'Upper Manhattan'],
            // ['neighborhood' => 'Upper East Side', 'section' => 'Upper Manhattan'],
            // ['neighborhood' => 'Upper West Side', 'section' => 'Upper Manhattan'],
            // ['neighborhood' => 'Washington Heights', 'section' => 'Upper Manhattan'],
            // ['neighborhood' => 'West Harlem', 'section' => 'Upper Manhattan'],

            ['neighborhood' => 'Upper West Side', 'section' => 'Uptown Manhattan', 'svg_path_id' => 'path4182'],
            ['neighborhood' => 'Upper East Side', 'section' => 'Uptown Manhattan', 'svg_path_id' => 'path4232'],
            
            ['neighborhood' => 'Midtown West', 'section' => 'Midtown Manhattan', 'svg_path_id' => 'path4188'],
            ['neighborhood' => 'Midtown East', 'section' => 'Midtown Manhattan', 'svg_path_id' => 'path4210'],

            ['neighborhood' => 'Greenwich Village ', 'section' => 'Downtown Manhattan', 'svg_path_id' => 'path4212'],
            ['neighborhood' => 'East Village', 'section' => 'Downtown Manhattan', 'svg_path_id' => 'path4222'],
            ['neighborhood' => 'SoHo', 'section' => 'Downtown Manhattan', 'svg_path_id' => 'path4224'],
            ['neighborhood' => 'Lower East Side', 'section' => 'Downtown Manhattan', 'svg_path_id' => 'path4230'],
            ['neighborhood' => 'Financial District', 'section' => 'Downtown Manhattan', 'svg_path_id' => 'path4228'],
            
        ];

        foreach ($manhattanNeighborhoods as $manhattanNeighborhood) {
            Neighborhood::create($manhattanNeighborhood);
        }
    }
}




