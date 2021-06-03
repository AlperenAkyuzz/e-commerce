<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;

class SearchProducts extends Component
{

    public $term = "";
    public $enabled = false;

    public function restart()
    {
        $this->term = '';
    }

    public function mount() {
        $this->term = request()->input('search');
    }

    public function enableInput() {
        $this->enabled = true;
    }

    public function render()
    {

        if(Str::length($this->term) >= 3)  {

            $results = [];
            $term = '%' . $this->term . '%';
            $products = Product::select(['name', 'photo', 'slug'])->where('name','like', $term)->get()->toArray();
            $categories = Category::select(['name', 'slug'])->where('name','like', $term)->get()->toArray();
            $vendors = User::select(['shop_name', 'photo'])->where('shop_name','like', $term)->where(['is_vendor' => 2])->get()->toArray();

            if(count($products) > 0) {
                $results['products'] = $products;
            }

            if(count($categories) > 0) {
                $results['categories'] = $categories;
            }

            if(count($vendors) > 0) {
                $results['vendors'] = $vendors;
            }

            $data = [
                'results' => $results
            ];


            return view('theme::livewire.search-products', $data);
        }

        return view('theme::livewire.search-products');

    }

    public function searchEngine()
    {
        $data = [
            'search' => $this->term
        ];
        if (!empty(request()->input('sort'))) $data['sort'] = request()->input('sort');
        if (!empty(request()->input('minprice'))) $data['minprice'] = request()->input('minprice');
        if (!empty(request()->input('maxprice'))) $data['maxprice'] = request()->input('maxprice');
        return redirect()->route('front.category', $data);
    }
/*
    public $query;
    public $products;
    public $highlightIndex;


    public function mount()
    {
        $this->restart();
    }

    public function restart()
    {
        $this->query = '';
        $this->products = [];
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->products) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->products) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function selectContact()
    {
        $contact = $this->products[$this->highlightIndex] ?? null;
        if ($contact) {
            $this->redirect(route('show-contact', $contact['id']));
        }
    }

    public function updatedQuery()
    {
        $this->products = Product::where('name', 'like', '%' . $this->query . '%')
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('theme::livewire.search-products');
    }*/
}
