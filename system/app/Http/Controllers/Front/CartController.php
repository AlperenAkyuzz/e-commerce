<?php

namespace App\Http\Controllers\Front;

use App\Models\Cargo\ProductShipper;
use App\Models\Cargo\ShipperRate;
use App\Models\Cargo\ShippingRate;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Coupon;
use App\Models\Generalsetting;
use Session;

class CartController extends Controller
{

    public function cart()
    {
        $this->code_image();
        if (!Session::has('cart')) {
            return view('theme::pages.cart');
        }
        if (Session::has('already')) {
            Session::forget('already');
        }
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        if (Session::has('coupon_total')) {
            Session::forget('coupon_total');
        }
        if (Session::has('coupon_total1')) {
            Session::forget('coupon_total1');
        }
        if (Session::has('coupon_percentage')) {
            Session::forget('coupon_percentage');
        }

        $gs = Generalsetting::findOrFail(1);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $products = $cart->items;
        $totalPrice = $cart->totalPrice;
        //$mainTotal = $totalPrice;
        $tx = $gs->tax;
        if ($tx != 0) {
            $tax = ($totalPrice / 100) * $tx;
            $mainTotal = $totalPrice + $tax;
        }

        //dd(round($totalPrice,1));
        //dd($products);

        // Kargo Hesaplama
        $cargoPrice = CartController::getCargoPrice();
        $subTotal = round($totalPrice,1);
        $mainTotal = $subTotal + $cargoPrice;

        //dd($subTotal);


        //return view('front.cart', compact('products','totalPrice','mainTotal','tx'));
        return view('theme::pages.cart', compact('products', 'totalPrice', 'subTotal','mainTotal', 'tx', 'cargoPrice'));
    }

    public function cartview()
    {
        return view('theme::load.cart');
    }

    static public function getCargoPrice() {

        $gs = Generalsetting::findOrFail(1);


        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $products = $cart->items;
        $shippingArray = array(); // ürünlerin kargo firmalarına göre ücretlerini gruplamak ve saklamak için boş bir dizi tanımladık
        //$shippingArray[1] = 5;
        $cargoPrice = 0; // dizideki bütün kargo firmalarına ait kargo ücreti toplamlarını saklamak için bir değişken tanımlıyoruz.
        foreach($products as $product) { // sepetteki ürünleri döngüye sokuyoruz
            if($product['item']->free_shipping != 1) { //eğer ürün ücretsiz kargo değil ise
                $shipperID = $product['item']->shipper_id;
                $totalWeight = $product['qty'] * $product['item']->weight;
                //dd($totalWeight);
                $shippingRate = ShippingRate::select('id')->where('rate_start', '<=', round($totalWeight, 2))
                    ->where('rate_end', '>=', round($totalWeight, 2))
                    ->first();
                if(!$shippingRate) {
                    $shippingRateID = ShippingRate::select('id')->max('rate_end');
                } else {
                    $shippingRateID = $shippingRate->id;
                }
                $data = [
                    'sID' => $shipperID,
                    'sRate' => $shippingRate
                ];
                //dd($data);

                $getRate = ShipperRate::select('value')->where(['shipper_id' => $shipperID, 'rate_id' => $shippingRateID])->first(); // Ürüne ait tanımlı kargonun desi ücretini al

                if($getRate) {
                    $checkShippingArray = $shippingArray[$shipperID] ?? 0;
                    $shippingArray[$shipperID] = $checkShippingArray + $getRate->value; // Dizinin kargo firması anahtarına kargo ücretini ekledik.
                }
            }
        }
        foreach($shippingArray as $value) { // diziyi döngüye sokuyoruz.
            $cargoPrice += $value; // Dizideki değerleri topluyoruz.
        }

        //dd($cart->totalPrice);
        if($cart->totalPrice >= $gs->free_cargo_price) {
            $cargoPrice = 0;
        }

        return $cargoPrice;

    }

    public function addtocart($id)
    {
        $prod = Product::where('id', '=', $id)->first(['id', 'user_id', 'slug', 'name', 'photo', 'size', 'size_qty', 'size_price', 'color', 'price', 'stock', 'type', 'file', 'link', 'license', 'license_qty', 'measure', 'whole_sell_qty', 'whole_sell_discount', 'attributes', 'weight', 'free_shipping', 'shipper_id', 'tax', 'tax']);

        // Set Attrubutes

        if (Session::has('language')) {
            $data = \DB::table('languages')->find(Session::get('language'));
            $data_results = file_get_contents(public_path() . '/assets/languages/' . $data->file);
            $lang = json_decode($data_results);
        } else {
            $data = \DB::table('languages')->where('is_default', '=', 1)->first();
            $data_results = file_get_contents(public_path() . '/assets/languages/' . $data->file);
            $lang = json_decode($data_results);
        }

        $keys = '';
        $values = '';
        if (!empty($prod->license_qty)) {
            $lcheck = 1;
            foreach ($prod->license_qty as $ttl => $dtl) {
                if ($dtl < 1) {
                    $lcheck = 0;
                } else {
                    $lcheck = 1;
                    break;
                }
            }
            if ($lcheck == 0) {
                return redirect()->route('front.cart')->with('unsuccess', $lang->out_stock);
            }
        }

        // Set Size

        $size = '';
        if (!empty($prod->size)) {
            $size = trim($prod->size[0]);
        }
        $size = str_replace(' ', '-', $size);

        // Set Color

        $color = '';
        if (!empty($prod->color)) {
            $color = $prod->color[0];
            $color = str_replace('#', '', $color);
        }

        if ($prod->user_id != 0) {
            $gs = Generalsetting::findOrFail(1);
            $vendor = User::find($prod->user_id);
            $prc = $prod->price + ($prod->price / 100) * $vendor->vendor_commission; //$prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
            $prod->price = round($prc, 2);
        }

        $prod->price = round($prod->price + ($prod->price * $prod->tax) / 100, 1);



        // Set Attribute

        if (!empty($prod->attributes)) {
            $attrArr = json_decode($prod->attributes, true);

            $count = count($attrArr);
            $i = 0;
            $j = 0;
            if (!empty($attrArr)) {
                foreach ($attrArr as $attrKey => $attrVal) {

                    if (is_array($attrVal) && array_key_exists("details_status", $attrVal) && $attrVal['details_status'] == 1) {
                        if ($j == $count - 1) {
                            $keys .= $attrKey;
                        } else {
                            $keys .= $attrKey . ',';
                        }
                        $j++;

                        foreach ($attrVal['values'] as $optionKey => $optionVal) {

                            $values .= $optionVal . ',';

                            $prod->price += $attrVal['prices'][$optionKey];
                            break;

                        }
                    }
                }
            }
        }
        $keys = rtrim($keys, ',');
        $values = rtrim($values, ',');


        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        $cart->add($prod, $prod->id, $size, $color, $keys, $values);
        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['dp'] == 1) {
            return redirect()->route('front.cart')->with('unsuccess', $lang->already_cart);
        }
        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['stock'] < 0) {
            return redirect()->route('front.cart')->with('unsuccess', $lang->out_stock);
        }

        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['size_qty']) {
            if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'] > $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['size_qty']) {
                return redirect()->route('front.cart')->with('unsuccess', $lang->out_stock);
            }
        }

        $cart->totalPrice = 0;
        foreach ($cart->items as $data)
            $cart->totalPrice += $data['price'];
        Session::put('cart', $cart);
        return redirect()->route('front.cart');
    }

    public function addcart($id)
    {
        $prod = Product::where('id', '=', $id)->first(['id', 'user_id', 'slug', 'name', 'photo', 'size', 'size_qty', 'size_price', 'color', 'price', 'stock', 'type', 'file', 'link', 'license', 'license_qty', 'measure', 'whole_sell_qty', 'whole_sell_discount', 'attributes','weight', 'free_shipping', 'shipper_id', 'tax']);


        // Set Attrubutes

        $keys = '';
        $values = '';
        if (!empty($prod->license_qty)) {
            $lcheck = 1;
            foreach ($prod->license_qty as $ttl => $dtl) {
                if ($dtl < 1) {
                    $lcheck = 0;
                } else {
                    $lcheck = 1;
                    break;
                }
            }
            if ($lcheck == 0) {
                return 0;
            }
        }

        // Set Size

        $size = '';
        if (!empty($prod->size)) {
            $size = trim($prod->size[0]);
        }
        $size = str_replace(' ', '-', $size);

        // Set Color

        $color = '';
        if (!empty($prod->color)) {
            $color = $prod->color[0];
            $color = str_replace('#', '', $color);
        }

        // Vendor Comission

        if ($prod->user_id != 0) {
            $gs = Generalsetting::findOrFail(1);
            $vendor = User::find($prod->user_id);
            $prc = $prod->price + ($prod->price / 100) * $vendor->vendor_commission;
            $prod->price = round($prc, 2);
        }

        $prod->price = round($prod->price + ($prod->price * $prod->tax) / 100, 2);


        // Set Attribute

        if (!empty($prod->attributes)) {
            $attrArr = json_decode($prod->attributes, true);

            $count = count($attrArr);
            $i = 0;
            $j = 0;
            if (!empty($attrArr)) {
                foreach ($attrArr as $attrKey => $attrVal) {

                    if (is_array($attrVal) && array_key_exists("details_status", $attrVal) && $attrVal['details_status'] == 1) {
                        if ($j == $count - 1) {
                            $keys .= $attrKey;
                        } else {
                            $keys .= $attrKey . ',';
                        }
                        $j++;

                        foreach ($attrVal['values'] as $optionKey => $optionVal) {

                            $values .= $optionVal . ',';

                            $prod->price += $attrVal['prices'][$optionKey];
                            break;


                        }

                    }
                }

            }

        }
        $keys = rtrim($keys, ',');
        $values = rtrim($values, ',');


        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        $cart->add($prod, $prod->id, $size, $color, $keys, $values);
        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['dp'] == 1) {
            return 'digital';
        }
        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['stock'] < 0) {
            return 0;
        }

        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['size_qty']) {
            if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'] > $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['size_qty']) {
                return 0;
            }
        }
        $cart->totalPrice = 0;
        foreach ($cart->items as $data)
            $cart->totalPrice += $data['price'];
        Session::put('cart', $cart);
        $data[0] = count($cart->items);
        return response()->json($data);
    }

    public function addnumcart()
    {
        $id = $_POST['id'];
        $qty = $_POST['qty'];
        $size = str_replace(' ', '-', $_POST['size']);
        $color = $_POST['color'];
        $size_qty = $_POST['size_qty'];
        $size_price = (double)$_POST['size_price'];
        $size_key = $_POST['size_key'];
        $keys = $_POST['keys'];
        $values = $_POST['values'];
        $prices = $_POST['prices'];
        $keys = $keys == "" ? '' : implode(',', $keys);
        $values = $values == "" ? '' : implode(',', $values);
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        } else {
            $curr = Currency::where('is_default', '=', 1)->first();
        }

        $size_price = ($size_price / $curr->value);
        $prod = Product::where('id', '=', $id)->first(['id', 'user_id', 'slug', 'name', 'photo', 'size', 'size_qty', 'size_price', 'color', 'price', 'stock', 'type', 'file', 'link', 'license', 'license_qty', 'measure', 'whole_sell_qty', 'whole_sell_discount', 'attributes','weight', 'free_shipping', 'shipper_id', 'tax', 'tax']);


        if ($prod->user_id != 0) {
            $gs = Generalsetting::findOrFail(1);
            $vendor = User::find($prod->user_id);
            $prc = $prod->price + ($prod->price / 100) * $vendor->vendor_commission;
            //$prc = $prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
            $prod->price = round($prc, 2);
        }

        $prod->price = round($prod->price + ($prod->price * $prod->tax) / 100, 2);

        if (!empty($prices)) {
            foreach ($prices as $data) {
                $prod->price += ($data / $curr->value);
            }

        }

        if (!empty($prod->license_qty)) {
            $lcheck = 1;
            foreach ($prod->license_qty as $ttl => $dtl) {
                if ($dtl < 1) {
                    $lcheck = 0;
                } else {
                    $lcheck = 1;
                    break;
                }
            }
            if ($lcheck == 0) {
                return 0;
            }
        }
        if (empty($size)) {
            if (!empty($prod->size)) {
                $size = trim($prod->size[0]);
            }
            $size = str_replace(' ', '-', $size);
        }

        if (empty($color)) {
            if (!empty($prod->color)) {
                $color = $prod->color[0];

            }
        }
        $color = str_replace('#', '', $color);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->addnum($prod, $prod->id, $qty, $size, $color, $size_qty, $size_price, $size_key, $keys, $values);
        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['dp'] == 1) {
            return 'digital';
        }
        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['stock'] < 0) {
            return 0;
        }

        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['size_qty']) {
            if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'] > $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['size_qty']) {
                return 0;
            }
        }

        $cart->totalPrice = 0;
        foreach ($cart->items as $data)
            $cart->totalPrice += $data['price'];
        Session::put('cart', $cart);
        $data[0] = count($cart->items);
        return response()->json($data);
    }

    public function addtonumcart()
    {
        $id = $_GET['id'];
        $qty = $_GET['qty'];
        $size = str_replace(' ', '-', $_GET['size']);
        $color = $_GET['color'];
        $size_qty = $_GET['size_qty'];
        $size_price = (double)$_GET['size_price'];
        $size_key = $_GET['size_key'];
        $keys = $_GET['keys'];
        $keys = explode(",", $keys);
        $values = $_GET['values'];
        $values = explode(",", $values);
        $prices = $_GET['prices'];
        $prices = explode(",", $prices);
        $keys = $keys == "" ? '' : implode(',', $keys);

        $values = $values == "" ? '' : implode(',', $values);
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        } else {
            $curr = Currency::where('is_default', '=', 1)->first();
        }

        $size_price = ($size_price / $curr->value);
        $prod = Product::where('id', '=', $id)->first(['id', 'user_id', 'slug', 'name', 'photo', 'size', 'size_qty', 'size_price', 'color', 'price', 'stock', 'type', 'file', 'link', 'license', 'license_qty', 'measure', 'whole_sell_qty', 'whole_sell_discount', 'attributes', 'weight', 'free_shipping', 'shipper_id', 'tax']);

        if (Session::has('language')) {
            $data = \DB::table('languages')->find(Session::get('language'));
            $data_results = file_get_contents(public_path() . '/assets/languages/' . $data->file);
            $lang = json_decode($data_results);

        } else {
            $data = \DB::table('languages')->where('is_default', '=', 1)->first();
            $data_results = file_get_contents(public_path() . '/assets/languages/' . $data->file);
            $lang = json_decode($data_results);

        }

        if ($prod->user_id != 0) {
            $gs = Generalsetting::findOrFail(1);
            $vendor = User::find($prod->user_id);
            $prc = $prod->price + ($prod->price / 100) * $vendor->vendor_commission;//$prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
            $prod->price = round($prc, 2);
        }
        $prod->price = round($prod->price + ($prod->price * $prod->tax) / 100, 1);

        if (!empty($prices)) {
            if (!empty($prices[0])) {
                foreach ($prices as $data) {
                    $prod->price += ($data / $curr->value);
                }
            }
        }

        if (!empty($prod->license_qty)) {
            $lcheck = 1;
            foreach ($prod->license_qty as $ttl => $dtl) {
                if ($dtl < 1) {
                    $lcheck = 0;
                } else {
                    $lcheck = 1;
                    break;
                }
            }
            if ($lcheck == 0) {
                return redirect()->route('front.cart')->with('unsuccess', $lang->out_stock);
            }
        }
        if (empty($size)) {
            if (!empty($prod->size)) {
                $size = trim($prod->size[0]);
            }
            $size = str_replace(' ', '-', $size);
        }

        if (empty($color)) {
            if (!empty($prod->color)) {
                $color = $prod->color[0];

            }
        }
        $color = str_replace('#', '', $color);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->addnum($prod, $prod->id, $qty, $size, $color, $size_qty, $size_price, $size_key, $keys, $values);
        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['dp'] == 1) {
            return redirect()->route('front.cart')->with('unsuccess', $lang->already_cart);
        }
        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['stock'] < 0) {
            return redirect()->route('front.cart')->with('unsuccess', $lang->out_stock);
        }

        if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['size_qty']) {
            if ($cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['qty'] > $cart->items[$id . $size . $color . str_replace(str_split(' ,'), '', $values)]['size_qty']) {
                return redirect()->route('front.cart')->with('unsuccess', $lang->out_stock);
            }
        }

        $cart->totalPrice = 0;
        foreach ($cart->items as $data)
            $cart->totalPrice += $data['price'];
        Session::put('cart', $cart);
        return redirect()->route('front.cart');
    }

    public function addbyone()
    {
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        $gs = Generalsetting::findOrFail(1);
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        } else {
            $curr = Currency::where('is_default', '=', 1)->first();
        }
        $id = $_POST['id'];
        $itemid = $_POST['itemid'];
        $size_qty = $_POST['size_qty'];
        $size_price = $_POST['size_price'];
        $prod = Product::where('id', '=', $id)->first(['id', 'user_id', 'slug', 'name', 'photo', 'size', 'size_qty', 'size_price', 'color', 'price', 'stock', 'type', 'file', 'link', 'license', 'license_qty', 'measure', 'whole_sell_qty', 'whole_sell_discount', 'attributes', 'weight', 'free_shipping', 'shipper_id', 'tax']);

        if ($prod->user_id != 0) {
            $gs = Generalsetting::findOrFail(1);
            $vendor = User::find($prod->user_id);
            $prc = $prod->price + ($prod->price / 100) * $vendor->vendor_commission;//$prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
            //$prc = $prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
            $prod->price = round($prc, 2);
        }

        $prod->price = round($prod->price + ($prod->price * $prod->tax) / 100, 1);

        if (!empty($prod->attributes)) {
            $attrArr = json_decode($prod->attributes, true);
            $count = count($attrArr);
            $j = 0;
            if (!empty($attrArr)) {
                foreach ($attrArr as $attrKey => $attrVal) {

                    if (is_array($attrVal) && array_key_exists("details_status", $attrVal) && $attrVal['details_status'] == 1) {

                        foreach ($attrVal['values'] as $optionKey => $optionVal) {
                            $prod->price += $attrVal['prices'][$optionKey];
                            break;
                        }
                    }
                }

            }
        }

        if (!empty($prod->license_qty)) {
            $lcheck = 1;
            foreach ($prod->license_qty as $ttl => $dtl) {
                if ($dtl < 1) {
                    $lcheck = 0;
                } else {
                    $lcheck = 1;
                    break;
                }
            }
            if ($lcheck == 0) {
                return 0;
            }
        }
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->adding($prod, $itemid, $size_qty, $size_price);
        if ($cart->items[$itemid]['stock'] < 0) {
            return 0;
        }
        if (!empty($size_qty)) {
            if ($cart->items[$itemid]['qty'] > $cart->items[$itemid]['size_qty']) {
                return 0;
            }
        }


        $cart->totalPrice = 0;
        foreach ($cart->items as $data)
            $cart->totalPrice += $data['price'];
        Session::put('cart', $cart);
        $data[0] = $cart->totalPrice;

        $data[3] = $data[0];
        $tx = $gs->tax;
        if ($tx != 0) {
            $tax = ($data[0] / 100) * $tx;
            $data[3] = $data[0] + $tax;
        }

        $cargoPrice = CartController::getCargoPrice();

        $data[1] = $cart->items[$itemid]['qty'];
        $data[2] = $cart->items[$itemid]['price'];
        $data[4] = $cart->items[$itemid]['item_price'];
        $data[0] = round($data[0] * $curr->value, 1);
        $data[2] = round($data[2] * $curr->value, 1);
        $data[3] = round($data[3] * $curr->value, 1);
        $data[4] = round($data[4] * $curr->value, 1);
        $data[5] = round($data[3] + $cargoPrice, 1);
        $data[6] = round($cargoPrice, 2);
        if ($gs->currency_format == 0) {
            $data[0] = $curr->sign . $data[0];
            $data[2] = $curr->sign . $data[2];
            $data[3] = $curr->sign . $data[3];
            $data[4] = $curr->sign . $data[4];
            $data[5] = $curr->sign . $data[5];

        } else {
            $data[0] = $data[0] . $curr->sign;
            $data[2] = $data[2] . $curr->sign;
            $data[3] = $data[3] . $curr->sign;
            $data[4] = $data[4] . $curr->sign;
            $data[5] = $data[5] . $curr->sign;
        }
        return response()->json($data);
    }

    public function reducebyone()
    {
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        $gs = Generalsetting::findOrFail(1);
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        } else {
            $curr = Currency::where('is_default', '=', 1)->first();
        }
        $id = $_POST['id'];
        $itemid = $_POST['itemid'];
        $size_qty = $_POST['size_qty'];
        $size_price = $_POST['size_price'];
        $prod = Product::where('id', '=', $id)->first(['id', 'user_id', 'slug', 'name', 'photo', 'size', 'size_qty', 'size_price', 'color', 'price', 'stock', 'type', 'file', 'link', 'license', 'license_qty', 'measure', 'whole_sell_qty', 'whole_sell_discount', 'attributes', 'weight', 'free_shipping', 'tax']);
        if ($prod->user_id != 0) {
            $gs = Generalsetting::findOrFail(1);
            $vendor = User::find($prod->user_id);
            $prc = $prod->price + ($prod->price / 100) * $vendor->vendor_commission;//$prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
            //$prc = $prod->price + $gs->fixed_commission + ($prod->price/100) * $gs->percentage_commission ;
            $prod->price = round($prc, 2);
        }

        $prod->price = round($prod->price + ($prod->price * $prod->tax) / 100, 1);

        if (!empty($prod->attributes)) {
            $attrArr = json_decode($prod->attributes, true);
            $count = count($attrArr);
            $j = 0;
            if (!empty($attrArr)) {
                foreach ($attrArr as $attrKey => $attrVal) {
                    if (is_array($attrVal) && array_key_exists("details_status", $attrVal) && $attrVal['details_status'] == 1) {

                        foreach ($attrVal['values'] as $optionKey => $optionVal) {
                            $prod->price += $attrVal['prices'][$optionKey];
                            break;
                        }

                    }
                }

            }
        }

        if (!empty($prod->license_qty)) {
            $lcheck = 1;
            foreach ($prod->license_qty as $ttl => $dtl) {
                if ($dtl < 1) {
                    $lcheck = 0;
                } else {
                    $lcheck = 1;
                    break;
                }
            }
            if ($lcheck == 0) {
                return 0;
            }
        }
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reducing($prod, $itemid, $size_qty, $size_price);
        $cart->totalPrice = 0;
        foreach ($cart->items as $data)
            $cart->totalPrice += $data['price'];

        Session::put('cart', $cart);
        $data[0] = $cart->totalPrice;

        $data[3] = $data[0];
        $tx = $gs->tax;
        if ($tx != 0) {
            $tax = ($data[0] / 100) * $tx;
            $data[3] = $data[0] + $tax;
        }

        $cargoPrice = CartController::getCargoPrice();

        $data[1] = $cart->items[$itemid]['qty'];
        $data[2] = $cart->items[$itemid]['price'];
        $data[4] = $cart->items[$itemid]['item_price'];
        $data[0] = round($data[0] * $curr->value, 1);
        $data[2] = round($data[2] * $curr->value, 1);
        $data[3] = round($data[3] * $curr->value, 1);
        $data[4] = round($data[4] * $curr->value, 1);
        $data[5] = round($data[3] + $cargoPrice, 1);
        $data[6] = round($cargoPrice, 2);
        if ($gs->currency_format == 0) {
            $data[0] = $curr->sign . $data[0];
            $data[2] = $curr->sign . $data[2];
            $data[3] = $curr->sign . $data[3];
            $data[4] = $curr->sign . $data[4];
            $data[5] = $curr->sign . $data[5];
        } else {
            $data[0] = $data[0] . $curr->sign;
            $data[2] = $data[2] . $curr->sign;
            $data[3] = $data[3] . $curr->sign;
            $data[4] = $data[4] . $curr->sign;
            $data[5] = $data[5] . $curr->sign;
        }
        return response()->json($data);
    }

    public function upcolor()
    {
        $id = $_GET['id'];
        $color = $_GET['color'];
        $prod = Product::where('id', '=', $id)->first(['id', 'user_id', 'slug', 'name', 'photo', 'size', 'size_qty', 'size_price', 'color', 'price', 'stock', 'type', 'file', 'link', 'license', 'license_qty', 'measure', 'whole_sell_qty', 'whole_sell_discount', 'attributes', 'weight', 'free_shipping']);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->updateColor($prod, $id, $color);
        Session::put('cart', $cart);
    }


    public function removecart($id)
    {
        $gs = Generalsetting::findOrFail(1);
        if (Session::has('currency')) {
            $curr = Currency::find(Session::get('currency'));
        } else {
            $curr = Currency::where('is_default', '=', 1)->first();
        }
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
            $data[0] = $cart->totalPrice;
            $data[3] = $data[0];
            $tx = $gs->tax;
            if ($tx != 0) {
                $tax = ($data[0] / 100) * $tx;
                $data[3] = $data[0] + $tax;
            }

            $cargoPrice = CartController::getCargoPrice();
            $data[5] = round($data[3] + $cargoPrice, 1);
            $data[6] = round($cargoPrice, 2);
            if ($gs->currency_format == 0) {
                $data[0] = $curr->sign . round($data[0] * $curr->value, 1);
                $data[3] = $curr->sign . round($data[3] * $curr->value, 1);
                $data[5] = $curr->sign . $data[5];

            } else {
                $data[0] = round($data[0] * $curr->value, 1) . $curr->sign;
                $data[3] = round($data[3] * $curr->value, 1) . $curr->sign;
            }

            $data[1] = count($cart->items);
            return response()->json($data);
        } else {
            Session::forget('cart');
            Session::forget('already');
            Session::forget('coupon');
            Session::forget('coupon_total');
            Session::forget('coupon_total1');
            Session::forget('coupon_percentage');

            $data = 0;
            return response()->json($data);
        }
    }

    public function coupon()
    {
        $gs = Generalsetting::findOrFail(1);
        $code = $_GET['code'];
        $total = (float)preg_replace('/[^0-9\.]/ui', '', $_GET['total']);;
        $fnd = Coupon::where('code', '=', $code)->get()->count();
        if ($fnd < 1) {
            return response()->json(0);
        } else {
            $coupon = Coupon::where('code', '=', $code)->first();
            if (Session::has('currency')) {
                $curr = Currency::find(Session::get('currency'));
            } else {
                $curr = Currency::where('is_default', '=', 1)->first();
            }
            if ($coupon->times != null) {
                if ($coupon->times == "0") {
                    return response()->json(0);
                }
            }
            $today = date('Y-m-d');
            $from = date('Y-m-d', strtotime($coupon->start_date));
            $to = date('Y-m-d', strtotime($coupon->end_date));
            if ($from <= $today && $to >= $today) {
                if ($coupon->status == 1) {
                    $oldCart = Session::has('cart') ? Session::get('cart') : null;
                    $val = Session::has('already') ? Session::get('already') : null;
                    if ($val == $code) {
                        return response()->json(2);
                    }
                    $cart = new Cart($oldCart);
                    if ($coupon->type == 0) {
                        Session::put('already', $code);
                        $coupon->price = (int)$coupon->price;
                        $val = $total / 100;
                        $sub = $val * $coupon->price;
                        $total = $total - $sub;
                        $data[0] = round($total, 2);
                        if ($gs->currency_format == 0) {
                            $data[0] = $curr->sign . $data[0];
                        } else {
                            $data[0] = $data[0] . $curr->sign;
                        }
                        $data[1] = $code;
                        $data[2] = round($sub, 2);
                        Session::put('coupon', $data[2]);
                        Session::put('coupon_code', $code);
                        Session::put('coupon_id', $coupon->id);
                        Session::put('coupon_total', $data[0]);
                        $data[3] = $coupon->id;
                        $data[4] = $coupon->price . "%";
                        $data[5] = 1;

                        Session::put('coupon_percentage', $data[4]);

                        return response()->json($data);
                    } else {
                        Session::put('already', $code);
                        $total = $total - round($coupon->price * $curr->value, 2);
                        $data[0] = round($total, 2);
                        $data[1] = $code;
                        $data[2] = round($coupon->price * $curr->value, 2);
                        Session::put('coupon', $data[2]);
                        Session::put('coupon_code', $code);
                        Session::put('coupon_id', $coupon->id);
                        Session::put('coupon_total', $data[0]);
                        $data[3] = $coupon->id;
                        if ($gs->currency_format == 0) {
                            $data[4] = $curr->sign . $data[2];
                            $data[0] = $curr->sign . $data[0];
                        } else {
                            $data[4] = $data[2] . $curr->sign;
                            $data[0] = $data[0] . $curr->sign;
                        }

                        Session::put('coupon_percentage', 0);

                        $data[5] = 1;
                        return response()->json($data);
                    }
                } else {
                    return response()->json(0);
                }
            } else {
                return response()->json(0);
            }
        }
    }

    public function couponcheck()
    {
        $gs = Generalsetting::findOrFail(1);
        $code = $_GET['code'];
        $total = (float)preg_replace('/[^0-9\.]/ui', '', $_GET['total']);
        $fnd = Coupon::where('code', '=', $code)->get()->count();
        if ($fnd < 1) {
            return response()->json(0);
        } else {
            $coupon = Coupon::where('code', '=', $code)->first();
            if (Session::has('currency')) {
                $curr = Currency::find(Session::get('currency'));
            } else {
                $curr = Currency::where('is_default', '=', 1)->first();
            }
            if ($coupon->times != null) {
                if ($coupon->times == "0") {
                    return response()->json(0);
                }
            }
            $today = date('Y-m-d');
            $from = date('Y-m-d', strtotime($coupon->start_date));
            $to = date('Y-m-d', strtotime($coupon->end_date));
            if ($from <= $today && $to >= $today) {
                if ($coupon->status == 1) {
                    $oldCart = Session::has('cart') ? Session::get('cart') : null;
                    $val = Session::has('already') ? Session::get('already') : null;
                    if ($val == $code) {
                        return response()->json(2);
                    }
                    $cart = new Cart($oldCart);
                    if ($coupon->type == 0) {
                        Session::put('already', $code);
                        $coupon->price = (int)$coupon->price;

                        $oldCart = Session::get('cart');
                        $cart = new Cart($oldCart);

                        $total = $total - $_GET['shipping_cost'];

                        $val = $total / 100;
                        $sub = $val * $coupon->price;
                        $total = $total - $sub;
                        $total = $total + $_GET['shipping_cost'];
                        $data[0] = round($total, 2);
                        $data[1] = $code;
                        $data[2] = round($sub, 2);
                        if ($gs->currency_format == 0) {
                            $data[0] = $curr->sign . $data[0];
                        } else {
                            $data[0] = $data[0] . $curr->sign;
                        }
                        Session::put('coupon', $data[2]);
                        Session::put('coupon_code', $code);
                        Session::put('coupon_id', $coupon->id);
                        Session::put('coupon_total1', $data[0]);
                        Session::forget('coupon_total');
                        $data[0] = round($total, 2);
                        $data[1] = $code;
                        $data[2] = round($sub, 2);
                        $data[3] = $coupon->id;
                        $data[4] = $coupon->price . "%";
                        $data[5] = 1;

                        Session::put('coupon_percentage', $data[4]);


                        return response()->json($data);
                    } else {
                        Session::put('already', $code);
                        $total = $total - round($coupon->price * $curr->value, 2);
                        $data[0] = round($total, 2);
                        $data[1] = $code;
                        $data[2] = round($coupon->price * $curr->value, 2);
                        $data[3] = $coupon->id;
                        if ($gs->currency_format == 0) {
                            $data[4] = 0;
                            $data[0] = $curr->sign . $data[0];
                        } else {
                            $data[4] = 0;
                            $data[0] = $data[0] . $curr->sign;
                        }
                        Session::put('coupon', $data[2]);
                        Session::put('coupon_code', $code);
                        Session::put('coupon_id', $coupon->id);
                        Session::put('coupon_total1', $data[0]);
                        Session::forget('coupon_total');
                        $data[0] = round($total, 2);
                        $data[1] = $code;
                        $data[2] = round($coupon->price * $curr->value, 2);
                        $data[3] = $coupon->id;
                        $data[5] = 1;

                        Session::put('coupon_percentage', $data[4]);

                        return response()->json($data);
                    }
                } else {
                    return response()->json(0);
                }
            } else {
                return response()->json(0);
            }
        }
    }

    // Capcha Code Image
    private function code_image()
    {
        $actual_path = str_replace('system', '', base_path());
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, 200, 50, $background_color);

        $pixel = imagecolorallocate($image, 0, 0, 255);
        for ($i = 0; $i < 500; $i++) {
            imagesetpixel($image, rand() % 200, rand() % 50, $pixel);
        }

        $font = $actual_path . 'assets/front/fonts/NotoSans-Bold.ttf';
        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length - 1)];
        $word = '';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length = 6;// No. of character in image
        for ($i = 0; $i < $cap_length; $i++) {
            $letter = $allowed_letters[rand(0, $length - 1)];
            imagettftext($image, 25, 1, 35 + ($i * 25), 35, $text_color, $font, $letter);
            $word .= $letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for ($i = 0; $i < 500; $i++) {
            imagesetpixel($image, rand() % 200, rand() % 50, $pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path . "assets/images/capcha_code.png");
    }

}
