<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductClick;
use Carbon\Carbon;
use Session;

class ProductController extends Controller {

    public function show(Product $product) {

        $product->views+=1;
        $product->update();

        // If currency selected from user
        if (Session::has('currency'))
        {
            $curr = Currency::find(Session::get('currency'));
        }
        else
        {
            $curr = Currency::where('is_default','=',1)->first();
        }

        // Add Product Click
        $product_click =  new ProductClick;
        $product_click->product_id = $product->id;
        $product_click->date = Carbon::now()->format('Y-m-d');
        $product_click->save();

        return view('theme::pages.product.detail',compact('product', 'curr'));
    }
}
