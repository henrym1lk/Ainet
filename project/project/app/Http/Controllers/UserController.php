<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }

    protected function save(Request $data)
    {

        $validator = Validator::make($data, [
            'name' => 'regex:/^[a-zA-Z ]+$/',
            'phone' => 'nullable|digits:9',
            'profile_url' => [
                'nullable',
                Rule::unique('users')->ignore(Auth::user()->id)
            ],
            'email' => [
                'required',
                Rule::unique('users')->ignore(Auth::user()->id)
            ],
        ]);

        $validator->validate();

        $user = Auth::user();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];

        if (!is_null($data['profile_url'])) {
            $user->profile_url = $data['profile_url'];
        }

        $user->save();

        /*
        if (!is_null($data['profile_url'])) {
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['name' => $data['name'], 'email' => $data['email'],'phone' => $data['phone'], 'profile_url' => $data['profile_url']]);
        }else{
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['name' => $data['name'], 'email' => $data['email'],'phone' => $data['phone']]);
        }
        */

        return redirect()->route('requests');
    }

    public function edit()
    {
        return view('user.edit');
    }
}
