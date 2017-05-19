<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\RequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Console\Helper\Table;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(){
        return view('home.index', compact('errors'));
    }

    public function stats(){

        $totalImp = DB::table('requests')
            ->count();

        $percCor = DB::table('requests')
            ->where('colored', 1)
            ->count();

        $percCor = $percCor * 100 / $totalImp;
        $percPeB = 100 - $percCor;

        $percCor = round($percCor);
        $percPeB = round($percPeB);

        $totalHj = DB::table('requests')
            ->whereDate('open_date', Carbon::today())
            ->count();

        $mediaMes = DB::table('requests')
            ->whereMonth('open_date', Carbon::today()->month)
            ->count();

        $mediaMes = $mediaMes / Carbon::today()->daysInMonth;

        $mediaMes = round($mediaMes, 2);

        $deps = DB::table('requests')
            ->join('users', 'requests.owner_id', '=', 'users.id')
            ->join('departaments', 'users.department_id', '=', 'departaments.id')
            ->select(DB::raw('departaments.id as id, departaments.name as name, count(*) as total'))
            ->groupBy('departaments.id')
            ->get();

        return view('home.statistics', compact('totalImp', 'percCor', 'percPeB', 'totalHj', 'mediaMes', 'deps'));
    }

    public function statsDep($id){

        $totalImp = DB::table('requests')
            ->join('users', 'requests.owner_id', '=', 'users.id')
            ->join('departaments', 'users.department_id', '=', 'departaments.id')
            ->where('departaments.id', $id)
            ->count();

        $percCor = DB::table('requests')
            ->join('users', 'requests.owner_id', '=', 'users.id')
            ->join('departaments', 'users.department_id', '=', 'departaments.id')
            ->where('departaments.id', $id)
            ->where('requests.colored', 1)
            ->count();

        $percCor = $percCor * 100 / $totalImp;
        $percPeB = 100 - $percCor;

        $percCor = round($percCor);
        $percPeB = round($percPeB);

        $totalHj = DB::table('requests')
            ->join('users', 'requests.owner_id', '=', 'users.id')
            ->join('departaments', 'users.department_id', '=', 'departaments.id')
            ->where('departaments.id', $id)
            ->whereDate('requests.open_date', Carbon::today())
            ->count();

        $mediaMes = DB::table('requests')
            ->join('users', 'requests.owner_id', '=', 'users.id')
            ->join('departaments', 'users.department_id', '=', 'departaments.id')
            ->where('departaments.id', $id)
            ->whereMonth('requests.open_date', Carbon::today()->month)
            ->count();

        $mediaMes = $mediaMes / Carbon::today()->daysInMonth;

        $mediaMes = round($mediaMes, 2);

        return view('home.dep_statistics', compact('totalImp', 'percCor', 'percPeB', 'totalHj', 'mediaMes'));
    }

    public function contacts(){
        $users = User::all(['id', 'name', 'phone', 'email', 'profile_url']);
        return view('home.contacts', compact('users'));
    }

    public function contactsFilter(){
        if (is_null(Input::get('column')) || is_null(Input::get('order'))) {
            $users = DB::table('users')
                ->join('departaments', 'users.department_id', '=', 'departaments.id')
                ->select('users.id as id', 'users.name as name', 'phone', 'email', 'profile_url')
                ->where('users.name', 'like', is_null(Input::get('name')) ? '%' : '%' . Input::get('name') . '%')
                ->where('departaments.name', 'like', is_null(Input::get('department')) ? '%' : '%' . Input::get('department') . '%')
                ->get();
        }
        else{
            $users = DB::table('users')
                ->join('departaments', 'users.department_id', '=', 'departaments.id')
                ->select('users.id as id', 'users.name as name', 'phone', 'email', 'profile_url')
                ->where('users.name', 'like', is_null(Input::get('name')) ? '%' : '%' . Input::get('name') . '%')
                ->where('departaments.name', 'like', is_null(Input::get('department')) ? '%' : '%' . Input::get('department') . '%')
                ->orderBy(Input::get('column'), Input::get('order'))
                ->get();
        }
        return view('home.contacts', compact('users'));
    }
}
