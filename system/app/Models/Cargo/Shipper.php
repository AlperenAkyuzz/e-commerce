<?php

namespace App\Models\Cargo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Shipper extends Model
{
    protected $fillable = ['shipper', 'status'];

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function shipperRate()
    {
        return $this->hasMany('App\Models\Cargo\ShipperRate');
    }

    static public function getDefinedShippers() {
        $gs = cache()->remember('generalsettings', now()->addDay(), function () {
            return DB::table('generalsettings')->first();
        });

        $query = DB::table('shippers as s')
            ->join('shipper_rates as sr', 'sr.shipper_id', '=', 's.id' );

        // if user allow set cargo prices
        if($gs->allow_vendor_cargo === 1) {
            $query->where('sr.user_id', Auth::id());
        }
        //$shipper_rates->where('user')
        $result = $query->groupBy('shipper_id')
            ->get();

        return $result;
    }
}
