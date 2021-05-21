<div class="top-cate">
    <div class="featured-pro container">
       <div class="row">
          <div class="slider-items-products">
             <div id="top-categories" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col4 products-grid">
                   @foreach ( $categories->where('is_featured', 0) as $category)
                  <!-- Item -->
                   <div class="item">
                     <a href="{{ route('front.category',$category->slug) }}">
                        <div class="pro-img">
                           <img src="{{ asset('assets/images/categories/'.$category->photo) ?? 'default.png' }}" alt="{{ $category->name}}">
                           <div class="pro-info">
                              <h3>{{ $category->name}}</h3>
                           </div>
                        </div>
                     </a>
                  </div>
                  <!-- End Item -->
                   @endforeach
                </div>
             </div>
          </div>
       </div>
    </div>
</div>