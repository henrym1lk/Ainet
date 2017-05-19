<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'admin', 'blocked', 'phone', 'profile_photo',
        'profile_url', 'presentation', 'print_evals', 'print_counts', 'department_id', 'facebook', 'confirmation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function departamentToString($department_id)
    {
        $nameDepartament = DB::table('users')
            ->join('departaments', 'users.department_id', 'departaments.id')
            ->select('departaments.name as name')
            ->where('departaments.id', $department_id)->first();
        return $nameDepartament->name;
    }
}
