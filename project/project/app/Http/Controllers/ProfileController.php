<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function profileDescription($profile_url){
        $data = DB::table('users')
            ->join('departaments', 'users.department_id', '=', 'departaments.id')
            ->select('users.id as id', 'users.profile_photo as profile_photo', 'users.name as name', 'users.phone as phone', 'users.email as email',
                'departaments.name as department','users.facebook as facebook','users.presentation as presentation')
            ->where('profile_url', '=', $profile_url)
            ->first();
        $id = $data->id;
        return view('user.profile', compact('data', 'id'));
    }
}
