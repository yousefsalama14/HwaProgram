<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rolleingname extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table="rollingnames";
    public $timestamps = true;
    public function rolleingdetailes(){
        return $this->hasMany(rolleingdetaile::class,'rolling_id');
    }
}
