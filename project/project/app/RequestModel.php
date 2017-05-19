<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'owner_id', 'status', 'open_date', 'due_date', 'description', 'quantity', 'colored', 'stapled', 'paper_size', 'paper_type',
        'file', 'printer_id', 'closed_date', 'closed_user_id', 'refused_reason', 'satisfaction_grade', 'front_back'
    ];

    public static function userName($owner_id)
    {
        return User::where('id', '=',  $owner_id)->first()->name;
    }
    public static function departamentoUser($owner_id)
    {
        return User::where('id', '=',  $owner_id)->first()->department_id;
    }

    public static function statusToString($status){
        if($status == 1){
            return "Finished";
        }
        elseif ($status == 0){
            return "Pendent";
        }
    }

    public static function booleanToString($boolean){
        if($boolean == 1){
            return "Yes";
        }
        elseif ($boolean == 0){
            return "No";
        }
    }

    public static function coloredToString($data)
    {
        if ($data == 1) {
            return "Cores";
        } elseif ($data == 0) {
            return "Black/White";
        }
    }

    public static function stapledToString($data)
    {
        if ($data == 1) {
            return "Stapled";
        } elseif ($data == 0) {
            return "Non Stapled";
        }
    }

    public static function paperSizeToString($data)
    {
        if ($data == 1) {
            return "A3";
        } elseif ($data == 0) {
            return "A4";
        }
    }

    public static function paperTypeToString($data)
    {
        if ($data == 1) {
            return "Draft";
        } elseif ($data == 2) {
            return "Normal";
        } elseif ($data == 3) {
            return "Photo";
        }
    }
}
