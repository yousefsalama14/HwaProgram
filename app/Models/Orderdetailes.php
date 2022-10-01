<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderdetailes extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = true;
    public function operationdetailes(){
        return $this->belongsTo(Operationdetailes::class);
    }
    public function operation(){
        return $this->belongsTo(Operation::class);
    }
}
