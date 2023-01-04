<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'methodPayment',
        'client_id',
        'seller_id',
        'value',
        'parceled',
    ];

    public function client(){
        return $this->belongsTo(User::class, 'client_id');
    }

    public function seller(){
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function parcels(){
        return $this->hasMany(Parcel::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }

}
