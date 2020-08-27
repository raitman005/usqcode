<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LeadTag;
use App\Models\Apartment;
use App\Models\LeadApartment;
use App\Models\ApartmentPhoto;
use App\Models\Neighborhood;
use App\Models\Feature;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;

class FetchApartment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apartment:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Opens an IMAP connection to emails and save the content to DB.
     *
     * @return void
     */
    public function handle()
    {
        $state = State::where('state_name', 'New York')->first();
        $tag = LeadTag::where('name', 'No Fee - Landlord Paying')->first();
        // $apartments = LeadApartment::whereNull('synched_at_123nofee')
        // ->join('apartment_tag', 'apartments.id', '=', 'apartment_tag.apartment_id')
        // ->get();
        $apartments = $tag->apartments()->whereNull('synched_at_123nofee')->get();
        $user = User::where('email', 'agent@123nofee.com')->first();

        if (!$user) {
            return "No default user set";
        }

        foreach($apartments as $apartment) {
            $neighborhood = null;
            if (isset($apartment->neighborhood->neighborhood)) {
                $neighborhood = Neighborhood::where('neighborhood',$apartment->neighborhood->neighborhood)->first();
            }

            $syncApartment = Apartment::where('source_apartment_id', $apartment->id)->first();
            if (!$syncApartment) {
                $syncApartment = new Apartment;
            }

            $syncApartment->user_id = $user->id;
            $syncApartment->price = $apartment->price;
            $syncApartment->bedrooms = $apartment->bedrooms;
            $syncApartment->bathrooms = $apartment->bathrooms ? $apartment->bathrooms : 0;
            $syncApartment->description = $apartment->description;
            $syncApartment->street = $apartment->street;
            $syncApartment->available_date = $apartment->date;
            $syncApartment->landlord = $apartment->landlord->name;
            $syncApartment->apartment_number = $apartment->apartment_number;
            $syncApartment->latitude = $apartment->latitude;
            $syncApartment->longitude = $apartment->longitude;
            $syncApartment->state_id = $apartment->id;
            $syncApartment->neighborhood_id = $neighborhood->id ?? null;
            $syncApartment->source_apartment_id = $apartment->id ?? '';
            $syncApartment->save();

            //photo
            ApartmentPhoto::where('apartment_id', $syncApartment->id)->delete();
            $i=0;
            foreach ($apartment->apartmentPhotos as $apartmentPhoto) {
                $apartmentPhotoRecord = new ApartmentPhoto;
                $apartmentPhotoRecord->apartment_id = $syncApartment->id;
                $apartmentPhotoRecord->photo = $apartmentPhoto->photo;
                $apartmentPhotoRecord->order = $i;
                $apartmentPhotoRecord->save();
                $i++;
            }

            // features
            $features = $apartment->features ?? [];

            if ($features->count() > 0) {
                $features = $features->pluck('feature');
                $featureIds = Feature::whereIn('feature', $features)->pluck('id');
                $syncApartment->features()->sync($featureIds);
            }
                
             $apartment->synched_at_123nofee = Carbon::now();
             $apartment->save();
        }

    }
}
