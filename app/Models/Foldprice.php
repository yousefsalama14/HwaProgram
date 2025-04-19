<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foldprice extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function foldLength(){
        return $this->hasMany(fold_length_price::class, 'fold_id');
    }
}
