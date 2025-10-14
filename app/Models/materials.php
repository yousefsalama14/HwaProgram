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
        'min_thickness',
        'max_thickness',
        'category',
        'wholesale_price',
        'retail_price',
        'updated_by'
    ];
    public $timestamps = true;

}
