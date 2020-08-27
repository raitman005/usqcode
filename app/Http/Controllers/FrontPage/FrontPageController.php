<?php

namespace App\Http\Controllers\FrontPage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Neighborhood;
use App\Mail\SendContact;
use App\Mail\SendListing;
use App\Http\Requests\FrontPage\SendContactRequest;
use App\Http\Requests\FrontPage\SendListingRequest;
use GuzzleHttp\Client;
use Mail;

class FrontPageController extends Controller
{
    /**
     * Show the frontpage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $upperManhattan = Neighborhood::where('section', "Uptown Manhattan")->get();
        $midtownManhattan = Neighborhood::where('section', "Midtown Manhattan")->get();
        $downtownManhattan = Neighborhood::where('section', "Downtown Manhattan")->get();
        $neighborhoodIdPath = Neighborhood::all()->pluck('id', 'svg_path_id');
        $neighborhoodPathName = Neighborhood::all()->pluck('neighborhood', 'svg_path_id');
        $neighborhoodPathId = array_flip($neighborhoodIdPath->toArray());
        $passwordFormPopup = false;

        if (\Auth::user()) {
            if(session('set_pw') && \Auth::user()->password == "") {
                $passwordFormPopup = true;
            }
        }
        
        return view('frontpage/index', compact('upperManhattan', 'midtownManhattan', 'downtownManhattan', 'neighborhoodIdPath', 'neighborhoodPathId', 'neighborhoodPathName', 'passwordFormPopup'));
    }

    /**
     * Show the terms static page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function terms()
    {
        return view('frontpage/terms');
    }

    /**
     * Show the contact form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact()
    {
        return view('frontpage/contact');
    }

    /**
     * Handles the contact form submission.
     * 
     * @param SendContactRequest $request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contactSend(SendContactRequest $request)
    {
        if (!$request->post('g-recaptcha-response')) {
            $request->session()->flash('danger', "Captcha error");
            return redirect(route('contact'));
        } 

        $captcha = $request->post('g-recaptcha-response');
        $secret = '6Lfi8qIUAAAAAHQltFNvWHOnEP-6-PUNjc2dNVDo';
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR'];

        $client = new Client;
        $response = $client->request('GET', $url);
        $response = json_decode($response->getBody());

        if($response->success == false) {
            $request->session()->flash('danger', "Captcha error");
            return redirect(route('contact'));
        }
        
        Mail::send(new SendContact($request->all()));
        $request->session()->flash('success', 'Message successfully sent. Thank you!');
        return redirect(route('contact'));
    }

    /**
     * Show the submit-a-listing form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function listingCreate()
    {
        return view('frontpage/send-listing');
    }

    /**
     * Handles the submit-a-listing form submission.
     * 
     * @param SendListingRequest $request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function listingCreateSend(SendListingRequest $request)
    {
        if (!$request->post('g-recaptcha-response')) {
            $request->session()->flash('danger', "Captcha error");
            return redirect(route('listing.create'));
        } 
        $captcha = $request->post('g-recaptcha-response');
        $secret = '6Lfi8qIUAAAAAHQltFNvWHOnEP-6-PUNjc2dNVDo';
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR'];

        $client = new Client;
        $response = $client->request('GET', $url);
        $response = json_decode($response->getBody());
        
        if($response->success == false) {
            $request->session()->flash('danger', "Captcha error");
            return redirect(route('listing.create'));
        }
        
        Mail::send(new SendListing($request->all()));
        $request->session()->flash('success', 'Message successfully sent. Thank you!');
        return redirect(route('listing.create'));
    }
}
