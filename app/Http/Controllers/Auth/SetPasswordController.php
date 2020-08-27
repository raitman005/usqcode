<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Auth;
use Mail;
use Hash;

class SetPasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Set the password. 
     *
     * @param SetPasswordRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function setpassword(SetPasswordRequest $request)
    {
        $errorBag = new MessageBag();

        $user = \Auth::user();
        if ($user->password) {
            $errorBag->add('password', 'Password already set!');
            return response()->json(session()->get('errors', new ViewErrorBag)->put('default', $errorBag), 422);
        }
        $user->password = Hash::make($request->post('password'));
        $user->save();
        $request->session()->flash('toast_success', 'Password successfully set!');
        return response()->json(['result' => true]);
    }
}
