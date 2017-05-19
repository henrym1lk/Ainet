<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function login(Request $request){
        $this->validate($request, ['email' => 'required|email',
            'password' => 'required|min:8']);
        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password'], 'blocked' => 0])){
            Auth::login($request->user());
            return redirect()->route('requests');
        }

        return redirect()->back();
    }

    use AuthenticatesUsers;

    protected function redirectTo(){
        return redirect(route('requests'));
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(Auth::check()){
            return redirect()->route('requests');
        }
    }
}
