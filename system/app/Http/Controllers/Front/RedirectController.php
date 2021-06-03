<?php namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\ProductController;
use App\Models\Product;

/***
 * Class RedirectController
 * @package App\Http\Controllers\Frontend
 */
class RedirectController extends Controller
{
    /***
     * @param string $slug
     * @param false $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View|string
     */
    public function index(string $slug, $id = false){
        $checkProduct = Product::where('slug',$slug)->where('status', 1)->first();
        if($checkProduct){
            $controller = new ProductController();
            return $controller->show($checkProduct);
        }
        else {
            $controller = new FrontendController();
            return $controller->page($slug);
        }
        return view('theme::errors.404')->setStatusCode(404);
    }
}


