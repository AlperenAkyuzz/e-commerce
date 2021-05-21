<aside class="col-left sidebar col-sm-3 col-xs-12 col-sm-pull-9 wow bounceInUp animated">
    <!-- BEGIN SIDE-NAV-CATEGORY -->
    <form id="catalogForm"
          action="{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}"
          method="GET">
        @if (!empty(request()->input('search')))
            <input type="hidden" name="search" value="{{ request()->input('search') }}">
        @endif
        @if (!empty(request()->input('sort')))
            <input type="hidden" name="sort" value="{{ request()->input('sort') }}">
        @endif
        <div class="side-nav-categories">
            <div class="block-title"> {{ __('front.categories') }}</div>
            <!--block-title-->
            <!-- BEGIN BOX-CATEGORY -->
            <div class="box-content box-category">
                <ul>
                    @foreach($categories as $element)
                        <li><a class="@if(!empty($cat) && $cat->id == $element->id && !empty($cat->subs)) active @endif"
                               href="{{route('front.category', $element->slug)}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}">{{$element->name}}</a>
                            @if(!empty($cat) && $cat->id == $element->id && !empty($cat->subs))
                                <span class="subDropdown minus"></span>
                            @endif
                            <ul class="sub-cat-menu"
                                @if(!empty($cat) && $cat->id == $element->id && !empty($cat->subs)) style="display:block" @endif>
                                @if(!empty($cat) && $cat->id == $element->id && !empty($cat->subs))
                                    @foreach ($cat->subs as $key => $subelement)
                                        <li>
                                            <a href="{{route('front.category', [$cat->slug, $subelement->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}"
                                               @if(!empty($subcat) && $subcat->id == $subelement->id) class="active" @endif> {{$subelement->name}}</a>
                                            @if(!empty($subcat) && $subcat->id == $subelement->id && !empty($subcat->childs))
                                                <span class="subDropdown minus"></span>
                                            @endif
                                            <ul class="child-cat-menu"
                                                @if(!empty($subcat) && $subcat->id == $subelement->id && !empty($subcat->childs)) style="display:block" @endif>
                                                @if(!empty($subcat) && $subcat->id == $subelement->id && !empty($subcat->childs))
                                                    @foreach ($subcat->childs as $key => $childelement)
                                                        <li>
                                                            <a href="{{route('front.category', [$cat->slug, $subcat->slug, $childelement->slug])}}{{!empty(request()->input('search')) ? '?search='.request()->input('search') : ''}}"
                                                               @if(!empty($childcat) && $childcat->id == $childelement->id) class="active" @endif>{{$childelement->name}}</a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                            <!--level2-->
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            <!--level1-->
                        </li>
                @endforeach
                <!--level 0-->


                </ul>
            </div>
            <div class="box-content box-category">
                <dl class="narrow-by-list">
                    <dt class="odd">Fiyat</dt>
                    <div class="price-range-block">
                        <div class="input-group mb-3">
                            <input type="number" min="0" name="min" id="min_price" class="form-control"
                                   placeholder="En az" inputmode="numeric">
                            <div class="range-contain-center">
                                -
                            </div>
                            <input type="number" min="0" name="max" id="max_price" class="form-control"
                                   placeholder="En çok" inputmode="numeric">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary filter-btn" type="submit">Uygula</button>
                            </div>
                        </div>

                    </div>
                </dl>
            </div>
            <!--box-content box-category-->
        </div>
        <!--side-nav-categories-->
        <div class="block block-layered-nav">
            <div class="block-title"> Mağaza</div>
            <div class="block-content">
                <form id="vendorForm"
                      action="{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}"
                      method="GET">
                    <ul class="filter">
                        <div class="single-filter">
                            @if(!empty($vendors))
                                @foreach($vendors as $vendor)
                                    @if($vendor->shop_name == 'Deleted')
                                        <div class="form-check ml-0 pl-0">
                                            <input name="vendorID[]" class="custom-control-input vendor-input" type="checkbox" id="vendorID0" value="0">
                                            <label class="custom-control-label" for="vendorID0"><span></span>{{ App\Models\Admin::find(1)->shop_name }}</label>
                                        </div>
                                    @else
                                        <div class="form-check ml-0 pl-0">
                                            <input name="vendorID[]" class="custom-control-input vendor-input" type="checkbox" id="vendorID{{ $vendor->id }}" value="{{ $vendor->id }}">
                                            <label class="custom-control-label" for="vendorID{{ $vendor->id }}"><span></span>{{ $vendor->shop_name }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                        </div>
                    </ul>
                </form>
            </div>
        </div>

        @if ((!empty($cat) && !empty(json_decode($cat->attributes, true))) || (!empty($subcat) && !empty(json_decode($subcat->attributes, true))) || (!empty($childcat) && !empty(json_decode($childcat->attributes, true))))
            <div class="block block-layered-nav">
                <div class="block-title"> Filtre</div>
                <div class="block-content">
                    <form id="attrForm" action="{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}" method="post">
                        <ul class="filter">
                            <div class="single-filter">
                                @if (!empty($cat) && !empty(json_decode($cat->attributes, true)))
                                    @foreach ($cat->attributes as $key => $attr)
                                        <div class="my-2 sub-title">
                                            <span><i class="fas fa-arrow-alt-circle-right"></i> {{$attr->name}}</span>
                                        </div>
                                        @if (!empty($attr->attribute_options))
                                            @foreach ($attr->attribute_options as $key => $option)
                                                <div class="form-check ml-0 pl-0">
                                                    <input name="{{$attr->input_name}}[]" class="custom-control-input attribute-input" type="checkbox" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
                                                    <label class="custom-control-label" for="{{$attr->input_name}}{{$option->id}}"><span></span>{{$option->name}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif

                                @if (!empty($subcat) && !empty(json_decode($subcat->attributes, true)))
                                    @foreach ($subcat->attributes as $key => $attr)
                                        <div class="my-2 sub-title">
                                            <span><i class="fas fa-arrow-alt-circle-right"></i> {{$attr->name}}</span>
                                        </div>
                                        @if (!empty($attr->attribute_options))
                                            @foreach ($attr->attribute_options as $key => $option)
                                                <div class="form-check  ml-0 pl-0">
                                                    <input name="{{$attr->input_name}}[]" class="custom-control-input attribute-input" type="checkbox" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
                                                    <label class="custom-control-label" for="{{$attr->input_name}}{{$option->id}}"><span></span>{{$option->name}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif

                                @if (!empty($childcat) && !empty(json_decode($childcat->attributes, true)))
                                    @foreach ($childcat->attributes as $key => $attr)
                                        <div class="my-2 sub-title">
                                            <span><i class="fas fa-arrow-alt-circle-right"></i> {{$attr->name}}</span>
                                        </div>
                                        @if (!empty($attr->attribute_options))
                                            @foreach ($attr->attribute_options as $key => $option)
                                                <div class="form-check  ml-0 pl-0">
                                                    <input name="{{$attr->input_name}}[]" class="form-check-input attribute-input" type="checkbox" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
                                                    <label class="form-check-label" for="{{$attr->input_name}}{{$option->id}}">{{$option->name}}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </ul>
                    </form>
                </div>
            </div>
        @endif
        <div class="block block-compare">
            <div class="block-content">
                <div class="ajax-checkout">
                    <button type="submit" title="Filtre" class="button button-compare filter-btn"><span>Filtrele</span>
                    </button>

                </div><!--ajax-checkout-->
            </div>
            <!--block-content-->
        </div>
        <!--block block-list block-compare-->
    </form>


</aside>