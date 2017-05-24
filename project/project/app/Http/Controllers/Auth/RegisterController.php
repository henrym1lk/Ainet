<?php

namespace App\Http\Controllers\Auth;

use App\Mail\Confirmation;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/requests';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(Request $data)
    {
        $this->validate($data, [
            'name' => 'required|regex:/^[a-zA-Z ]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|digits:9',
            'profile_url' => 'nullable|unique:users,profile_url',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg',
            'facebook' => 'nullable',
            'presentation' => 'nullable'
        ]);


        $user = new User();
        $user->fill($data->all());
        $user->password = Hash::make($data['password']);
        $user['admin'] = 0;
        $user['blocked'] = 1;
        $user['print_evals'] = 0;
        $user['print_counts'] = 0;
        $user['department_id'] = 2;

        if (is_null($data['profile_url'])) {

            $url['url'] = str_random(32);

            do {
                $validator = Validator::make($url, [
                    'url' => 'unique:users,profile_url'
                ]);
            } while ($validator->fails());

            $user['profile_url'] = $url['url'];

        }

        if ($data->hasFile('photo')) {
            $file = $data->file('photo');

            $fileName = $user['profile_url'].".".$file->getClientOriginalExtension();

            $path = public_path('profile_pictures/'.$fileName);
            Image::make($file->getRealPath())->resize(288, 288)->save($path);

            $user['profile_photo'] = "http://project.ainet/profile_pictures/".$fileName;
        }

        $confirmation['confirmation'] = str_random(32);

        do {
            $validator = Validator::make($confirmation, [
                'confirmation' => 'unique:users,confirmation'
            ]);
        } while ($validator->fails());

        $user['confirmation'] = $confirmation['confirmation'];

        Mail::to($user)->send(new Confirmation($user['confirmation']));

        $user->save();

        return redirect()->route('index');
    }

    public function register()
    {
        return view('user.register');
    }

    public function confirm($confirmation)
    {
        DB::table('users')
            ->where('confirmation', $confirmation)
            ->update(['blocked' => 0]);

        return view('home.index');
    }

    public function recover()
    {
        return view('home.recover');
    }

    public function recoverSubmit(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email'
        ]);

        DB::table('users')
            ->where('email', $request['email'])
            ->update(['blocked' => 1]);

        $confirmation['confirmation'] = str_random(32);

        do {
            $validator = Validator::make($confirmation, [
                'confirmation' => 'unique:password_resets,token'
            ]);
        } while ($validator->fails());

        DB::table('password_resets')
            ->where('email', $request['email'])
            ->delete();

        DB::table('password_resets')
            ->insert(['email' => $request['email'], 'token' => $confirmation['confirmation']]
            );

        return redirect()->route('index');
    }
    public function recoverConfirm($confirmation)
    {
        $reset = DB::table('password_resets')
            ->where('token', $confirmation)
            ->first();

        DB::table('password_resets')
            ->where('email', $reset->email)
            ->delete();

        DB::table('users')
            ->where('email', $reset->email)
            ->update(['blocked' => 0]);

        return view('home.index');
    }

    public function testRender(){
        return view('test');
    }

    /*
    public function test(Request $request){
        $file = $request->file('image');

        //Display File Name
        echo 'File Name: '.$file->getClientOriginalName();
        echo '<br>';

        //Display File Extension
        echo 'File Extension: '.$file->getClientOriginalExtension();
        echo '<br>';

        //Display File Real Path
        echo 'File Real Path: '.$file->getRealPath();
        echo '<br>';

        //Display File Size
        echo 'File Size: '.$file->getSize();
        echo '<br>';

        //Display File Mime Type
        echo 'File Mime Type: '.$file->getMimeType();
    }
    */

}
