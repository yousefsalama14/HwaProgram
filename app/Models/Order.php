<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'status',
        'quantity',
        'totalprice',
        'customer_name',
        'customer_phone',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];
    public function orderdetailes(){
        return $this->hasMany(Orderdetailes::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
