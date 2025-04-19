<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perforationprice extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function foldLength(){
        return $this->hasMany(perforation_diameter_price::class, 'perforation_id');
    }
}
