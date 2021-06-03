<div>
    <div class="px-4 space-y-4 mt-8">
        <form method="get">
            <input class="search-bar-input"
                   type="text" placeholder="{{ __('front.search_product_category_vendor') }}"
                   wire:model="term"
                   wire:keydown.escape="restart"
                   wire:keydown.enter="searchEngine"
                   wire:click="enableInput"
                   x-data @click.away="@this.set('enabled', false)"
            />
        </form>
        {{--<div wire:loading>{{ __('searching_product') }}...</div>--}}

        @if ($term && $enabled)
        <div class="search-bar-results" wire:loading.remove>
            @if ($term == "")
               {{-- <div class="text-gray-500 text-sm">
                    {{ __('enter_search_for_product') }}
                </div>--}}
            @else

                @if(empty($results))
                    <div class="text-gray-500 text-sm">
                        {{ __('front.no_matching_result_was_found') }}
                    </div>
                @else
                    @if(!empty($results['products']))
                        <h4>Urunler</h4>
                        @foreach($results['products'] as $product)
                            <div>
                                <a style="display: flex" href="{{ url($product['slug']) }}">
                                    <img width="50px" style="padding: 5px;" src="{{ $product['photo'] ? asset('assets/images/products/'.$product['photo']):asset('assets/images/noimage.png') }}" />
                                    <h5 class="text-lg">{{$product['name']}}</h5>
                                </a>
                            </div>
                        @endforeach
                    @endif
                    @if(!empty($results['categories']))
                        <h3>Kategoriler</h3>
                        @foreach($results['categories'] as $category)
                            <div>
                                <a href="{{ route('front.category', $category['slug']) }}"><h5
                                            class="text-lg">{{$category['name']}}</h5></a>
                            </div>
                        @endforeach
                    @endif
                    @if(!empty($results['vendors']))
                        <h4>Magazalar</h4>
                        @foreach($results['vendors'] as $vendor)
                            <div>
                                <a style="display: flex" href="{{ route('front.vendor',str_replace(' ', '-', $vendor['shop_name'])) }}">
                                    <img width="50px" src="{{ $vendor['photo'] ? asset('assets/images/users/'.$vendor['photo']):asset('assets/images/noimage.png') }}" />
                                    <h5 class="text-lg">{{$vendor['shop_name']}}</h5></a>
                            </div>
                        @endforeach
                    @endif
                @endif
            @endif
        </div>
        @endif
    </div>
</div>
{{--

<div class="relative">
    <input
            type="text"
            class="form-input"
            placeholder="Search Contacts..."
            wire:model="query"
            wire:keydown.escape="restart"
            wire:keydown.tab="reset"
            wire:keydown.ArrowUp="decrementHighlight"
            wire:keydown.ArrowDown="incrementHighlight"
            wire:keydown.enter="selectContact"
    />

    <div wire:loading class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
        <div class="list-item">Searching...</div>
    </div>

    @if(!empty($query))
        <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="reset"></div>


        <div class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
            @if(!empty($products))
                @foreach($products as $i => $product)
                    <a
                            href="{{ url($product['slug']) }}"
                            class="list-item {{ $highlightIndex === $i ? 'highlight' : '' }}"
                    >{{ $product['name'] }}</a>
                @endforeach
            @else
                <div class="list-item">No results!</div>
            @endif
        </div>
    @endif
</div>
--}}
