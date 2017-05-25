<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

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

        $this->validate($data, [
            'name' => 'required|regex:/^[a-zA-Z ]+$/',
            'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::user()->id)],
            'phone' => 'nullable|digits:9',
            'profile_url' => ['required', Rule::unique('users')->ignore(Auth::user()->id)],
            'photo' => 'nullable|image|mimes:jpg,png,jpeg',
            'facebook' => 'nullable',
            'presentation' => 'nullable',
        ]);

        $user = Auth::user();

        $user->fill(($data->all()));

        if ($data->hasFile('photo')) {
            $file = $data->file('photo');

            $fileName = $user['profile_url'].".".$file->getClientOriginalExtension();

            $path = public_path('profile_pictures/'.$fileName);
            Image::make($file->getRealPath())->resize(288, 288)->save($path);

            $user['profile_photo'] = "http://project.ainet/profile_pictures/".$fileName;
        }
        else{
            $user['profile_photo'] = Auth::user()->profile_photo;
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
