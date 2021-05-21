<?php

namespace App\Models\Cargo;

use Illuminate\Database\Eloquent\Model;

class ShipperRate extends Model
{

    protected $fillable = ['shipper_id', 'user_id', 'value', 'status', 'rate_id'];

    public $timestamps = false;

    public function shipper() {
        return $this->belongsTo('App\Models\Cargo\Shipper');
    }

    public function rate() {
        return $this->belongsTo('App\Models\Cargo\ShipperRate');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User')->withDefault(function ($data) {
            foreach ($data->getFillable() as $dt) {
                $data[$dt] = __('Deleted');
            }
        });
    }


}
