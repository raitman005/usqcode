<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use App\Http\Requests\Auth\RegisterOrLoginRequest;
use App\Http\Requests\Auth\AccessTokenRequest;
use App\Http\Requests\Auth\LoginPasswordRequest;
use App\Models\User;
use App\Mail\SendLoginLink;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'loginByAccessToken');
    }

    /**
     * Authenticate the email and password. 
     *
     * @param LoginPasswordRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function login(LoginPasswordRequest $request) 
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->flash('toast_success', 'You are now logged in!');
            return response()->json(['result' => true, 'status' => 1]);
        }

        return response()->json(['result' => false, 'status' => 0]);
    }

    /**
     * Authenticate the email, if no account associate, create a user account. 
     *
     * @param RegisterOrLoginRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function registerlogin(RegisterOrLoginRequest $request) 
    {
        $email = $request->post('email');

        $authService = new AuthService($email);
        if ($authService->getUser() == false) {
            $authService->createUser();
            Auth::login($authService->getUser());
            $request->session()->flash('toast_success', 'You are now logged in!');
            return response()->json(['result' => true, 'status' => 1]);
        } else {
            if ($authService->hasPassword()) {
                Mail::send(new SendLoginLink($authService->getUser()));
                $viewString = view('auth._welcome_back_msg', ['email' => $email])->render();
                return response()->json(['result' => true, 'status' => 2, 'html' => $viewString]);
            } else {
                $viewString = view('auth._login_password', ['email' => $email])->render();
                return response()->json(['result' => true, 'status' => 3, 'html' => $viewString]);
            }
            // is confirmed?
            // show password form
        }

        return response()->json(['result' => false]);
    }

    /**
     * Authenticate using user id and access token. 
     *
     * @param AccessTokenRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function loginByAccessToken(AccessTokenRequest $request)
    {
        $userId = decrypt($request->get('uid'));
        $accessToken = $request->get('access_token');

        $user = User::where('id', $userId)->where('access_token', $accessToken)->first();

        if(!$user) {
            abort(404);
        }
        Auth::login($user);
        $request->session()->flash('toast_success', 'You are now logged in!');
        if ($request->get('set_pw')) {
            $request->session()->flash('set_pw', true);
        }
        return redirect(route('homepage'));
    }
}
