<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'expireDate',
        'obs',
        'order_id',
    ];

    public function order(){
        return $this->hasOne(Order::class);
    }

}
