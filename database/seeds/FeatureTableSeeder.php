<?php

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feature::query()->truncate();

        $features = [
            [ 'feature' => 'Doorman', 'icon' => '<i class="fas fa-door-closed"></i>'],
            [ 'feature' => 'Elevator', 'icon' => '<i class="fas fa-long-arrow-alt-up"></i><i class="fas fa-long-arrow-alt-down"></i>'],
            [ 'feature' => 'Gym', 'icon' => '<i class="fas fa-dumbbell"></i>'],
            [ 'feature' => 'Laundry (Building)', 'icon' => '<i class="fas fa-tshirt"></i>'],
            [ 'feature' => 'Laundy (in Unit)', 'icon' => '<i class="fas fa-tshirt"></i>'],
            [ 'feature' => 'Common Outdoor Space', 'icon' => '<i class="fas fa-cloud-sun"></i>'],
            [ 'feature' => 'Dogs Allowed', 'icon' => '<i class="fas fa-dog"></i>'],
            [ 'feature' => 'Cats Allowed', 'icon' => '<i class="fas fa-cat"></i>'],
            [ 'feature' => 'Pets Case-by-case', 'icon' => '<i class="fas fa-paw"></i>'],
            [ 'feature' => 'Private Balcony/Patio', 'icon' => '<i class="fas fa-warehouse"></i>'],
            [ 'feature' => 'Diswasher', 'icon' => '<i class="fas fa-spray-can"></i>'],
        ];
        
        foreach($features as $feature) {
            Feature::create(['feature' => $feature['feature'], 'icon' => $feature['icon']]);
        }
    }
}
