<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materials extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'id',
        'name',
        'size',
        'wholesale_price',
        'retail_price'
    ];
    public $timestamps = false;

}
