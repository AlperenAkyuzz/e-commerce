<?php

namespace App\Models\Cargo;

use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = ['rate_start', 'rate_end', 'status'];

    public $timestamps = false;

    public function shipperRate()
    {
        return $this->hasMany('App\Models\Cargo\ShipperRate');
    }

}
