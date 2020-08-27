<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\User;
use Carbon\Carbon;
use Helper;
use Auth;
use Hash;

class AdminController extends Controller{

	public function index(){
		return view("admin.indextest");
	}

	public function accounts(){
		$agents = User::where('user_type_id', 1)->get();

        return view('admin.agent.index', compact('agents'));

	}

	public function listings(Request $request)
    {
    	$neighbourhood = Neighborhood::all();
        $apartmentList = Apartment::where('user_id', Auth::user()->id)->get();

        return view('admin.agent.listings', compact('apartmentList', 'neighbourhood'));
    }

    public function userlistings(Request $request)
    {
    	$neighbourhood = Neighborhood::all();
        $apartmentList = Apartment::where('user_id', '!=', Auth::user()->id)
        					->join('users', 'apartments.user_id', '=', 'users.id')
        					->get();

        return view('admin.agent.userlistings', compact('apartmentList', 'neighbourhood'));
    }
}


?>