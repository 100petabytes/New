<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

use Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        // Update last login date
        $user->is_login = 1;
        $user->save();
}

    public function logout(Request $request)
    {
        // 
        $userId = Auth::id();
        // Update last login date
        $user = User::findOrFail($userId);
        $user->is_login = 0;
        $user->save();
        
        // logout user
        $this->guard()->logout();
        // invalidate session
        $request->session()->invalidate();
        // Redirect to login page
        return $this->loggedOut($request) ?: redirect('/login');
    }

}
