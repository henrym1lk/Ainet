<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        if(Auth::user()['admin']==0){
            redirect()->route('requests');
        }
    }

    public function printRequest(Request $request, $id){
        DB::table('requests')
            ->where('id', $id)
            ->update(['status' => 1, 'printer_id' => intval($request['printer'])]);

        return redirect()->route('requests.details', $id);
    }

    public function refuseRequest(Request $request, $id){
        DB::table('requests')
            ->where('id', $id)
            ->update(['refused_reason' => $request['reason']]);

        return redirect()->route('requests.details', $id);
    }

    public function blockUser($id){
        DB::table('users')
            ->where('id', $id)
            ->update(['blocked' => 1]);

        return redirect()->back();
    }

    public function unblockUser($id){
        DB::table('users')
            ->where('id', $id)
            ->update(['blocked' => 0]);

        return redirect()->back();
    }

    public function revoke($id){
        DB::table('users')
            ->where('id', $id)
            ->update(['admin' => 0]);

        return redirect()->back();
    }

    public function concede($id){
        DB::table('users')
            ->where('id', $id)
            ->update(['admin' => 1]);

        return redirect()->back();
    }

    public function unblockComment($id){
        DB::table('comments')
            ->where('id', $id)
            ->update(['blocked' => 0]);

        return redirect()->back();
    }

    public function manage(){
        $blockedUsers = DB::table('users')
            ->join('departaments', 'users.department_id', '=', 'departaments.id')
            ->select('users.id as id', 'departaments.name as dep', 'users.name as name')
            ->where('users.blocked', 1)
            ->get();

        $adminOrNotUsers = DB::table('users')
            ->join('departaments', 'users.department_id', '=', 'departaments.id')
            ->select('users.id as id', 'departaments.name as dep', 'users.name as name', 'users.admin as admin')
            ->get();

        $comments = DB::table('comments')
            ->select('id', 'comment')
            ->where('blocked', 1)
            ->get();

        return view('admin.manage', compact('blockedUsers', 'adminOrNotUsers', 'comments'));
    }
}