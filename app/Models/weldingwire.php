<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class weldingwire extends Model
{
    use HasFactory;
    protected $fillable = [
        'size',
        'price',
        'id',
        'name'
    ];
    public $timestamps = false;

}
