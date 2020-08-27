<?php

namespace App\Http\Controllers\Frontpage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Neighborhood;
use App\Models\Lead;
use App\Mail\SendMessage;
use App\Http\Requests\Listing\SendMessageRequest;
use Mail;
use Auth;
use Helper;

class ListingController extends Controller
{
    /**
     * Renders the searching UI.
     * 
     * @param
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function searchView(Request $request)
    {
        $minPrice = $request->get('min_price') ? abs((int) $request->get('min_price')) : 0;  
        $maxPrice = $request->get('max_price') ? abs((int) $request->get('max_price')) : 0;  
        $rooms = $request->get('rooms') ? strtolower($request->get('rooms')) : [];  
        $neighborhoodIds = $request->get('neighborhood_id') ? $request->get('neighborhood_id') : [];
        $neighborhoodIds = is_array($neighborhoodIds) ? $neighborhoodIds : [];

        if ($rooms == 'all') {
            $rooms = ['1', '2', '3', '4', '5+', 'studio', 'studio/1'];
        } else {
            $rooms = [$rooms];
        }

        $filter = [
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'rooms' => $rooms,
            'neighborhood_ids' => $neighborhoodIds,
        ];

        $apartments = Apartment::orderBy('created_at', 'DESC')->orderBy('id', 'DESC');

        if ($minPrice > $maxPrice) {
            $minPrice = 0;
        }

        if ($minPrice != 0 || $maxPrice != 0) {
            $apartments->whereBetween('price', [$minPrice, $maxPrice]);
        }  
        
        if (count($neighborhoodIds) > 0) {
            $apartments->whereIn('neighborhood_id', $neighborhoodIds);
        }

        $apartments->whereIn('bedrooms', $rooms);
        //$apartments->orWhereIn('bathrooms', $rooms);

        $apartmentCnt = $apartments->count();
        $apartments = $apartments->paginate(8);

        $neighborhoods = Neighborhood::whereIn('id', $neighborhoodIds)->get();
        $neighborhoodlist = Neighborhood::all();
        return view('frontpage.search', compact('apartments', 'filter', 'neighborhoods', 'neighborhoodlist', 'apartmentCnt', 'neighborhoodIds'));
    }

    /**
     * Perform searching and display the result.
     * 
     * @param
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function performSearch(Request $request)
    {
        $minPrice = $request->get('min_price') ? abs((int) $request->get('min_price')) : 0;  
        $maxPrice = $request->get('max_price') ? abs((int) $request->get('max_price')) : 0;  
        $rooms = $request->get('rooms') ? $request->get('rooms') : [];  
        $neighborhoodIds = $request->get('neighborhood_ids') ? $request->get('neighborhood_ids') : [];
        $neighborhoodIds = is_array($neighborhoodIds) ? $neighborhoodIds : [];
        $apartments = Apartment::orderBy('created_at', 'DESC')->orderBy('id', 'DESC');
        $page = $request->get('page') ? $request->get('page') : 1;

        if ($minPrice > $maxPrice) {
            $minPrice = 0;
        }

        if ($minPrice != 0 || $maxPrice != 0) {
            $apartments->whereBetween('price', [$minPrice, $maxPrice]);
        }  
        
        if (count($neighborhoodIds) > 0) {
            $apartments->whereIn('neighborhood_id', $neighborhoodIds);
        } else {
            $apartments->whereNotNull('neighborhood_id');
        }
        $apartments->whereIn('bedrooms', $rooms);

        $apartmentCnt = $apartments->count();
        $apartments = $apartments->paginate(8);
        $paginateApartmentCnt = $apartments->count();
        $html = view('frontpage._search', compact('apartments', 'page'))->render();
        return response()->json(['html' => $html, 'page' => $page, 'apartment_cnt' => $apartmentCnt, 'paginateApartmentCnt' => $paginateApartmentCnt, 'pagination' => (string) $apartments->appends(request()->except('page'))->links()]);
    }

    /**
     * The listing details.
     * 
     * @param \App\Models\Apartment $apartment
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function listing(Apartment $apartment) 
    {
        $neighborhoodId = $apartment->neighborhood_id;
        $neighbedrooms = $apartment->bedrooms;
        if ($neighborhoodId) {
            $nearbyApartments = Apartment::where('neighborhood_id', $apartment->neighborhood_id)
                                        ->where('id', '<>', $apartment->id)
                                        ->where('bedrooms', '=', $neighbedrooms)
                                        ->inRandomOrder()
                                        ->take(4)
                                        ->get();
        } else {
            $nearbyApartments = [];
        }
        
        return view('frontpage/listing', compact('apartment', 'nearbyApartments'));
    }

    /**
     * Process the inquiry
     * 
     * @param Request $request
     * 
     * @return redirect
     */

    public function sendInquiry(SendMessageRequest $request) 
    {
        $id = decrypt($request->post('id'));
        $name =  $request->post('name');
        $email =  $request->post('email');
        $phone =  $request->post('phone');
        $body =  $request->post('body');

        $apartment = Apartment::findOrFail($id);
        $user = Auth::user();

        if ($user && $user->id == $apartment->user_id) {
            $request->session()->flash('danger', 'You cannot send a message to your own listing!');
            return redirect(route('listing', $id));
        }

        if (trim($body) == "") {
            $body = "Hello, I am interested in " . $apartment->street . "-" . $apartment->apartment_number;
        }

        $lead = new Lead();
        $lead->name =  $name ;
        $lead->email = $email;
        $lead->phone = $phone;
        $lead->body =  $body ;
        $lead->apartment_id =  $id;

        if ($user) {
            if ($user->user_type_id == Helper::getUserType('customer')->id) {
                $nameArr = explode(" ", $name);
                $firstName = $nameArr[0] ?? '';
                $lastName = $nameArr[1] ?? '';
                $user->firstname = trim($firstName);
                $user->lastname = trim($lastName);
                $user->phone_number = $phone;
                $user->save();
            }
        }

        //$lead->save();
        Mail::send(new SendMessage($lead, $apartment));
        $request->session()->flash('success', 'Message successfully sent!');
        return redirect(route('listing', $id));
    }
     
}
