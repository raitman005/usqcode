<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Helper;
use Auth;
use Hash;

class UserController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Update the user.
     *
     * @param Request $request
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->firstname = $request->post('firstname');
        $user->lastname = $request->post('lastname');
        $user->company = $request->post('company');
        $user->phone_number = $request->post('phone_number');
        $user->real_estate_license_number = $request->post('real_estate_license_number');
        $user->save();

        $request->session()->flash('success', 'Profile successfully updated!');
        return redirect(route('user.profile'));
    }

    /**
     * Change the password
     * 
     * @param ChangePasswordRequest $request
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        if (!Hash::check($request->post('current_password'), $user->password)) {
            $bag = new MessageBag();
            $bag->add('current_password', 'Incorrect password');
            return redirect()->back()->with('errors', session()->get('errors', new ViewErrorBag)->put('default', $bag));
        } 

        $user->password = Hash::make($request->post('new_password'));;
        $user->save();

        $request->session()->flash('success', 'Password successfully changed!');
        return redirect(route('user.profile'));
    }

    /**
     * Update the user avatar
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();
        if (!$request->post('data')) {
            $request->session()->flash('danger', 'Error! Invalid data!');
            return response()->json(['result' => false, 'msg' => 'No data uploaded']);
        }
        
        $data = explode( ',', $request->post('data') );

        if (!isset($data[1])) {
            $request->session()->flash('danger', 'Error! Invalid data!');
            return response()->json(['result' => false, 'msg' => 'No data uploaded']);
        }

        if (Helper::checkIfBase64Image($data[1]) == false) {
            $request->session()->flash('danger', 'Error! Invalid data!');
            return response()->json(['result' => false]);
        }

        $avatarFilename = public_path("img/avatars/{$user->id}/{$user->avatar}");
        if (file_exists($avatarFilename)) {
            unlink($avatarFilename);
        }

        

        $pos  = strpos($request->post('data'), ';');
        $type = explode(':', substr($request->post('data'), 0, $pos))[1];
        $ext = '';

        if($type == 'image/bmp') {
            $ext = 'bmp';
        } elseif($type == 'image/gif') {
            $ext = 'gif';
        } elseif($type == 'image/jpeg') {
            $ext = 'jpg';
        } elseif($type == 'image/png') {
            $ext = 'png';
        } elseif($type == 'image/tiff') {
            $ext = 'tiff';
        }

        $ifp = fopen( public_path("img/avatars/{$user->id}/{$user->avatar}"), 'wb' ); 
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );
        fclose( $ifp );

        $user->avatar = "{$user->id}.{$ext}";
        $user->save();

        $request->session()->flash('success', 'Password successfully changed!');
        return response()->json(['result' => true]);

    }


}
