<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Listing\CreateApartmentRequest;
use App\Http\Requests\Listing\UpdateApartmentRequest;
use App\Http\Controllers\Controller;
use App\Models\Neighborhood;
use App\Models\ApartmentPhoto;
use App\Models\Feature;
use App\Models\Apartment;
use Carbon\Carbon;
use Helper;
use Auth;
use Hash;

class ListingController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function listings(Request $request)
    {
        $apartmentsAll = Apartment::where('user_id', Auth::user()->id)->withTrashed();
        $apartmentsActive = Apartment::where('user_id', Auth::user()->id)->whereNull('rented_at');
        $apartmentsRented = Apartment::where('user_id', Auth::user()->id)->whereNotNull('rented_at');
        $apartmentsArchived = Apartment::where('user_id', Auth::user()->id)->onlyTrashed();
        $neighbourhood = Neighborhood::all();
        $list = $request->get('list');
        if ($request->get('list') == 'all') {
            $apartmentRec = $apartmentsAll->orderBy('created_at', 'desc');
            $apartmentsNoPaginateCount = $apartmentRec->count();
        } elseif ($request->get('list') == 'rented') {
            $apartmentRec = $apartmentsRented->orderBy('created_at', 'desc');
            $apartmentsNoPaginateCount = $apartmentRec->count();
        } elseif ($request->get('list') == 'archived') {
            $apartmentRec = $apartmentsArchived->orderBy('created_at', 'desc');
            $apartmentsNoPaginateCount = $apartmentRec->count();
        } else {
            $list = 'active';
            $apartmentRec = $apartmentsActive->orderBy('created_at', 'desc');
            $apartmentsNoPaginateCount = $apartmentRec->count();
        }
        $apartmentGrid = $apartmentRec->paginate(8);
        $apartmentList = Apartment::all();

        return view('agent.listings', compact('apartmentGrid', 'apartmentList', 'neighbourhood', 'apartmentsAll', 'apartmentsActive', 'apartmentsRented', 'apartmentsArchived', 'apartmentsNoPaginateCount', 'list'));
    }

    /**
     * Show new listing page form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function new(Request $request)
    {
        $request->session()->forget('apartment_photo_temp');
        $request->session()->forget('apartment_photo_delete');

        $neighborhoodRecord = Neighborhood::orderBy('section')->get();
        $features = Feature::all();
        $neighborhoods = [];

        foreach ($neighborhoodRecord as $neighborhood) {
            $section = str_replace(" ", "_", $neighborhood->section);
            if (!array_key_exists($section, $neighborhoods)) {
                $i = 0;
                $neighborhoods[$section] = [];
            }
            $neighborhoods[$section][$i]['id'] = $neighborhood->id;
            $neighborhoods[$section][$i]['neighborhood'] = $neighborhood->neighborhood;
            $i++;
        }

        $user = Auth::user();
        return view('agent.new', compact('user', 'neighborhoods', 'features'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(CreateApartmentRequest $request)
    {

        echo $request->post('street')."<br /> Price: ".$request->post('price')."<br /> Latitude: ".$request->post('latitude')."<br /> Longitude: ".$request->post('longitude');
        $apartment = new Apartment();
        $apartment->price = $request->post('price');
        $apartment->bedrooms = $request->post('bedrooms');
        $apartment->bathrooms = $request->post('bathrooms');
        $apartment->street = $request->post('street');
        $apartment->available_date = $request->post('date');
        $apartment->apartment_number = $request->post('apartment_number');
        $apartment->description = $request->post('description');
        $apartment->latitude = $request->post('latitude');
        $apartment->longitude = $request->post('longitude');
        $apartment->neighborhood_id = $request->post('neighborhood_id');
        $apartment->zip_code = $request->post('zip_code');
        $apartment->state_id = Helper::getState("New York");
        $apartment->user_id = Auth::user()->id;
        $apartment->save();

        // feature
        if ($request->post('features')) {
            foreach ($request->post('features') as $key => $value) {
                if (!is_null($value)) {
                    $feature = Feature::find($key);
                    $apartment->features()->attach($feature);
                }
            }
        }

        if (session('apartment_photo_temp')) {
            $i=1;
            foreach (session('apartment_photo_temp') as $tempPhoto) {
                $filename = basename($tempPhoto);
                $sourceFile = public_path('img/apartment/photos/'.$tempPhoto);
                $destinationFileRelative = 'img/apartment/photos/' . $apartment->id . "/" . $filename;
                $destinationFile = public_path($destinationFileRelative);

                $folder = public_path('img/apartment/photos/' . $apartment->id);
                if(!is_dir($folder)) {
                    mkdir($folder, 0755);
                }

                rename($sourceFile, $destinationFile);

                $apartmentPhoto = new ApartmentPhoto;
                $apartmentPhoto->apartment_id = $apartment->id;
                $apartmentPhoto->photo = asset($destinationFileRelative);
                $apartmentPhoto->order = $i;
                $apartmentPhoto->save();
                $i++;
            }
        }

        if (session('apartment_photo_delete')) {
            foreach (session('apartment_photo_delete') as $tempPhotoDelete) {
                $filename = basename($tempPhotoDelete);
                $guessFile1 = public_path('img/apartment/photos/'.$apartment->id."/".$filename);
                $guessFile2 = public_path('img/apartment/photos/tmp/'.$filename);
                if (file_exists($guessFile1)) {
                    unlink($guessFile1);
                } else if (file_exists($guessFile2)) {
                    unlink($guessFile2);
                }
            }
        }

        $request->session()->forget('apartment_photo_temp');
        $request->session()->forget('apartment_photo_delete');
        $request->session()->flash('success', 'Apartment was successfully added!');
        return redirect()->route("agent.listings");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Apartment $apartment
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment, Request $request)
    {
        $request->session()->forget('apartment_photo_temp');
        $request->session()->forget('apartment_photo_delete');

        $features = Feature::all();
        $apartmentFeatures = $apartment->features()->pluck('id');
        $neighborhoodRecord = Neighborhood::orderBy('neighborhood')->get();
        $neighborhoods = [];

        foreach ($neighborhoodRecord as $neighborhood) {
            $section = str_replace(" ", "_", $neighborhood->section);
            if (!array_key_exists($section, $neighborhoods)) {
                $i = 0;
                $neighborhoods[$section] = [];
            }
            $neighborhoods[$section][$i]['id'] = $neighborhood->id;
            $neighborhoods[$section][$i]['neighborhood'] = $neighborhood->neighborhood;
            $i++;
        }

        $photos = [];
        $config = [];
        foreach ($apartment->apartmentPhotos as $photo) {
            $photos[] = $photo->photo;
            $filename = basename($photo->photo);
            $sourceFile = public_path('img/apartment/photos/'.$apartment->id."/".$filename);
            $config[] = [
                    'key' => $photo->photo,
                    'caption' => basename($photo->photo),
                    'downloadUrl' => asset('img/apartment/photos/'.$photo->photo), 
                    'url' => route('agent.listings.photos.delete', ['file' => $photo->photo]), // server api to delete the file based on key
                ];
        }

        session(['apartment_photo_temp' => $photos]);

        return view('agent.edit', compact('apartment', 'neighborhoods', 'features',
        'apartmentFeatures', 'streets', 'photos', 'config'));
    }

    /**
     * Fully Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApartmentRequest $request)
    {
        $apartment = Apartment::where('id', $request->id)->where('user_id', \Auth::user()->id)->first();
        if (!$apartment) {
            return response()->json([
                'return' => false,
                'msg' => 'Apartment not found'
            ], 404);
        }

        // apartment
        $apartment->price = $request->post('price');
        $apartment->bedrooms = $request->post('bedrooms');
        $apartment->bathrooms = $request->post('bathrooms');
        $apartment->street = $request->post('street');
        $apartment->available_date = $request->post('date');
        $apartment->apartment_number = $request->post('apartment_number');
        $apartment->description = $request->post('description');
        $apartment->latitude = $request->post('latitude');
        $apartment->longitude = $request->post('longitude');
        $apartment->neighborhood_id = $request->post('neighborhood_id');
        $apartment->zip_code = $request->post('zip_code');
        $apartment->save();

        // feature
        $features = [];
        if ($request->post('features')) {
            foreach ($request->post('features') as $key => $value) {
                $features[] = $key;
            }
        }  
        $apartment->features()->sync($features);

        //photo
        if (session('apartment_photo_temp')) {
            $i=0;
            foreach (session('apartment_photo_temp') as $tempPhoto) {
                $filename = basename($tempPhoto);
                $sourceFile = public_path('img/apartment/photos/'.$tempPhoto);
                $destinationFileRelative = 'img/apartment/photos/' . $apartment->id . "/" . $filename;
                $destinationFile = public_path($destinationFileRelative);
                $storedFilename = asset($destinationFileRelative);

                $exisitingPhoto = ApartmentPhoto::where('photo', $tempPhoto)->where('apartment_id', $apartment->id)->first();

                if (!$exisitingPhoto) {
                    $folder = public_path('img/apartment/photos/' . $apartment->id);
                    if(!is_dir($folder)) {
                        mkdir($folder, 0755);
                    }
                    rename($sourceFile, $destinationFile);
                    $exisitingPhoto = new ApartmentPhoto;
                    $exisitingPhoto->apartment_id = $apartment->id;
                    $exisitingPhoto->photo = $storedFilename;
                    $exisitingPhoto->order = $i;
                    $exisitingPhoto->save();
                } else { // update ordering
                    $exisitingPhoto->order = $i;
                    $exisitingPhoto->save();
                } 
                $i++;
            }
        }
        if (session('apartment_photo_delete')) {
            foreach (session('apartment_photo_delete') as $tempPhotoDelete) {
                $filename = basename($tempPhotoDelete);
                $fileStoredInApartment = public_path('img/apartment/photos/'.$apartment->id."/".$filename);
                $fileStoredTemp = public_path('img/apartment/photos/tmp/'.$filename);
                $exisitingPhoto = ApartmentPhoto::where('photo', $tempPhotoDelete)->where('apartment_id', $apartment->id)->delete();
                if (file_exists($fileStoredInApartment)) {
                    unlink($fileStoredInApartment);
                } else if (file_exists($fileStoredTemp)) {
                    unlink($fileStoredTemp);
                }
            }
        }

        $data = [
            'price' => '$ ' . number_format($request->price),
            'bedrooms' => $request->bedrooms,
            'street' => $request->street,
            'remarks' => $request->remarks,
            'date' => $request->date,
            'apartment_number' => $request->apartment_number,
        ];

        $request->session()->flash('success', 'Apartment was successfully updated!');
        return redirect()->route('agent.listings');
    }

    /**
     * Upload the photo via ajax and save in temporary folder
     * 
     * @param int $id the apartment id
     * 
     * @return \Illuminate\Http\Response
     */
    public function uploadPhoto(Request $request) 
    {
        $i = 1;
        $initialPreview = [];
        $tmpFiles = [];

        if (session('apartment_photo_temp')) {
            $tmpFiles = session('apartment_photo_temp');
        }

        $config = [];
        if ($request->file('photos')) {
            foreach($request->file('photos') as $photo) {
                $storedFile = $photo->store("tmp", ['disk' => 'apartment_photos']);
                $i++;
                $initialPreview[] = asset('img/apartment/photos/'.$storedFile);
                $tmpFiles[] = $storedFile;
                $config[] = [
                    'key' => $storedFile,
                    'caption' => $storedFile,
                    'size' => $photo->getSize(),
                    'downloadUrl' => asset('img/apartment/photos/'.$storedFile), 
                    'url' => route('agent.listings.photos.delete', ['file' => $storedFile]), // server api to delete the file based on key
                ];
            }
        }
        session(['apartment_photo_temp' => $tmpFiles]);

        return response()->json(['initialPreview' => $initialPreview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true]);
    }

    /**
     * Update the photo via ajax and save in temporary folder
     * 
     * @param int $id the apartment id
     * 
     * @return \Illuminate\Http\Response
     */
    public function reorder(Request $request) 
    {
        if ($request->post('stack') == false) {
            return response()->json(['result' => false]);
        }
        $request->session()->forget('apartment_photo_temp');
        $tmpFiles = [];
        foreach ($request->post('stack') as $item) {
            $tmpFiles[] = $item['key'];
        }
        session(['apartment_photo_temp' => $tmpFiles]);

        return response()->json(['result' => true]);
    }

    /**
     * Delete a Photo
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */

    public function deletePhoto(Request $request) 
    {
        if (!$request->post('key')) {
            return response()->json(['result' => false]); 
        }

        $deleteApartments = session('apartment_photo_delete') ? session('apartment_photo_delete') : [];
        $deleteApartments[] = $request->post('key');

        $tmpFiles = session('apartment_photo_temp') ? session('apartment_photo_temp') : [];
        $tmpFiles = array_diff($tmpFiles, [$request->post('key')]);

        session(['apartment_photo_delete' => $deleteApartments]);
        session(['apartment_photo_temp' => $tmpFiles]);

        return response()->json(['result' => true]);
    }

    /**
     * Show the application dashboard.
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function setStatus($id, Request $request)
    {
        $apartment = Apartment::where('id', $id)->withTrashed()->first();
      
        if (!$apartment || $apartment->user->id != Auth::user()->id || $request->get('set') == false) {
            abort(404);
        }

        $set = $request->get('set');
        $message = "";
        if ($set == 'rent' ) {
            $message = "$apartment->street - # $apartment->apartment_number successfully marked as rented";
            $apartment->rented_at = Carbon::now();
            $apartment->save();
        } elseif ($set == 'archive' ) {
            $message = "$apartment->street - # $apartment->apartment_number successfully archived. This will NOT appear in the search results anymore.";
            $apartment->delete();
        } elseif ($set == 'available' ) {
            $apartment->rented_at = null;
            $apartment->save();
            $message = "$apartment->street - # $apartment->apartment_number successfully marked as available";
        } elseif ($set == 'restore' ) {
            $apartment->restore();
            $message = "$apartment->street - # $apartment->apartment_number successfully restored. . This will now appear in the search results.";
        } else {
            abort(404);
        }

        $request->session()->flash('success', $message);
        return redirect()->route("agent.listings");
    }



    public function updateStatus(Request $request){
    	$apartment = $request->input('apt');
    	
    	$set = $request->input('action');
    	$message = "";
    	if($set == 'Rented'){
    		foreach($apartment as $apt){
    			$aptstatus = Apartment::where('id', $apt)->withTrashed()->first();
    			$message = "$aptstatus->street - # $aptstatus->apartment_number successfully marked as rented";
	            $aptstatus->rented_at = Carbon::now();
	            $aptstatus->save();
    		}
    	}elseif($set == 'Archived'){
    		foreach($apartment as $apt){
    			$aptstatus = Apartment::where('id', $apt)->withTrashed()->first();
    			$message = "$aptstatus->street - # $aptstatus->apartment_number successfully archived. This will NOT appear in the search results anymore.";
            	$aptstatus->delete();
    		}
    	}elseif($set == 'Saved'){
            // echo "me";
    		$data = $request->data;
            // var_dump($data);
            foreach($request->data as $key => $value){
            	if($value['area'] == NULL){
            		$ar = $value['area1'];
            	}else{
            		$ar = $value['area'];
            	}
            	$aptupdate = Apartment::where('id', $value['id'])->withTrashed()->first();
            	$aptupdate->price = str_replace( ',', '', $value['price']);
            	$aptupdate->bedrooms = $value['bedrooms'];
            	$aptupdate->bathrooms = $value['bathrooms'];
            	$aptupdate->apartment_number = $value['aptnumber'];
            	$aptupdate->street = $value['street'];
            	$aptupdate->neighborhood_id = $ar;
            	$aptupdate->save();
            }
            // $id = $request->input('id');
            // $street = $request->input('street');
            // $aptnumber = $request->input('aptnumber');
            // $price = $request->input('price');
            // $bathrooms = $request->input('bathrooms');
            // $bedrooms = $request->input('bedrooms');
            // $date = $request->input('date');
            // $area = $request->input('area');

            // var_dump($id);
            // var_dump($street);
        }
    	$request->session()->flash('info', $message);
     	return redirect()->route("agent.listings");
    }

    public function photoTest()
    {
        dd(session('apartment_photo_delete'));
        return view('apartment.phototest');
    }

    public function test(){
        return view('agent.testadd');
    }

}
