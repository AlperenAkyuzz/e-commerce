<!--product-collateral-->
<div class="box-additional">
  <!-- BEGIN RELATED PRODUCTS -->
  <div class="related-pro container">
    <div class="slider-items-products">
      <div class="new_title center">
        <h2>{{ __('front.releated_products') }}</h2>
      </div>
      @if(count($product->releatedProducts) > 0)
      <div id="related-slider" class="product-flexslider hidden-buttons">
        <div class="slider-items slider-width-col4 products-grid">
          @foreach($product->releatedProducts as $product)
            <div class="item">
            <div class="item-inner">
              <div class="item-img">
                <div class="item-img-info">
                  <a href="{{ url($product->slug) }}"
                     title="Fresh Organic Mustard Leaves " class="product-image"><img
                            src="{{ asset('assets/images/thumbnails/'.$product->thumbnail) }}" alt="{{ $product->name }}"></a>
                </div>
                <div class="add_cart">
                  <button class="button btn-cart add-to-cart" type="button"
                          data-href="{{ route('product.cart.add',$product->id) }}">
                    <span>Sepete Ekle</span>
                  </button>
                </div>
              </div>
              <div class="item-info">
                <div class="info-inner">
                  <div class="item-title"><a href="{{ url($product->slug) }}"
                                             title="{{ $product->name }} ">{{ $product->name }} </a> </div>
                  <div class="item-content">
                    <div class="rating">
                      <div class="ratings">
                        <div class="rating-box">
                          @php
                            $rate = ceil($product->ratings->avg('rating'));
                          @endphp
                          <div class="rating" style="width:{{ (100 * $rate / 5) }}%"></div>
                        </div>
                      </div>
                    </div>
                    <div class="item-price">
                      <div class="price-box">
                        <span class="regular-price">
                          <span class="price">
                            {{ $product->vendorPrice() }} TL
                          </span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach

        </div>
      </div>
      @else
        <h4>Bu kategoride başka ürün bulunamadı.</h4>
      @endif
    </div>
  </div>
  <!-- end related product -->
</div>
<!-- end related product -->