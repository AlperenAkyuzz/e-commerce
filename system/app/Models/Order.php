<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    const status = [
        'pending' => 'Bekliyor',
        'processing' => 'İşleniyor',
        'completed' => 'Tamamlandı',
        'declined' => 'İptal',
        'on delivery' => 'Yolda'
    ];

    const method = [
        'creditcard' => 'Kredi Kartı',
        '3d' => '3D',
        'bank' => 'Banka Havale/EFT',
        'Cash On Delivery' => 'Kapıda Ödeme'
    ];

	protected $fillable = ['user_id', 'cart', 'method','shipping', 'pickup_location', 'totalQty', 'pay_amount', 'txnid', 'charge_id', 'order_number', 'payment_status', 'customer_email', 'customer_name', 'customer_phone', 'customer_address', 'customer_city', 'customer_zip','shipping_name', 'shipping_email', 'shipping_phone', 'shipping_address', 'shipping_city', 'shipping_zip', 'order_note', 'status'];

    public function vendororders()
    {
        return $this->hasMany('App\Models\VendorOrder');
    }

    public function tracks()
    {
        return $this->hasMany('App\Models\OrderTrack','order_id');
    }

    public function ordered_at() {
        return Carbon::parse($this->created_at)->timezone('Europe/Istanbul')->formatLocalized('%d %B %A %Y');
    }

}
