<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrinterModel extends Model
{
    protected $table = 'printers';

    protected $fillable = [
        'name'
    ];
}
