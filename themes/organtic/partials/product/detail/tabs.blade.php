<div class="product-collateral container">
    <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
      <li class="active"> <a href="#product_tabs_description" data-toggle="tab"> {{ __('front.product_description') }} </a>
      </li>
      <li> <a href="#reviews_tabs" data-toggle="tab">{{ __('front.reviews') }}</a> </li>
    </ul>
    <div id="productTabContent" class="tab-content">
      <div class="tab-pane fade in active" id="product_tabs_description">
        <div class="std">

          <p>{!! $product->details !!}</p>
        </div>
      </div>
      <div class="tab-pane fade in" id="reviews_tabs">
        <div class="woocommerce-Reviews">
          <div>
            <h2 class="woocommerce-Reviews-title">{!! __('front.review_product_total', ['product' => $product->name, 'count' => $product->ratings->count()])  !!}
            </h2>
            <ol class="commentlist">
              @foreach($product->ratings as $review)
              <li class="comment">
                <div>
                  <img alt="" src="{{ $review->user->photo ? asset('assets/images/users/'.$review->user->photo):asset('assets/images/noimage.png') }}" class="avatar avatar-60 photo">
                  <div class="comment-text">
                    <div class="ratings">
                      <div class="rating-box">
                        <div style="width:{{ (100 * $review->rating / 5) }}%" class="rating"></div>
                      </div>

                    </div>
                    <p class="meta">
                      <strong>{{ $review->user->name }}</strong>
                      <span>–</span> {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$review->review_date)->diffForHumans() }}
                    </p>
                    <div class="description">
                      <p>{{ $review->review }}</p>
                    </div>
                  </div>
                </div>
              </li><!-- #comment-## -->
              @endforeach
            </ol>
          </div>
          @if(Auth::guard('web')->check())
          <div>
            <div>
              <div class="comment-respond">
                <span class="comment-reply-title">Add a review </span>
                <form action="#" method="post" class="comment-form" novalidate>
                  {{ csrf_field() }}
                  <p class="comment-notes"><span id="email-notes">{{ __('front.publish_before_approve') }}</p>
                  <div class="comment-form-rating">
                    <label id="rating">{{ __('front.review_rating_label') }}</label>
                    <p class="stars">
                      <span>
                        <a class="star-1" href="#">1</a>
                        <a class="star-2" href="#">2</a>
                        <a class="star-3" href="#">3</a>
                        <a class="star-4" href="#">4</a>
                        <a class="star-5" href="#">5</a>
                      </span>
                    </p>
                  </div>
                  <p class="comment-form-comment">
                    <label>{{ __('front.review_input_label') }}<span class="required">*</span></label>
                    <textarea id="comment" name="comment" cols="45" rows="8" required></textarea>
                  </p>
                  <p class="form-submit">
                    <input name="submit" type="submit" id="submit" class="submit" value="{{ __('front.send') }}">
                  </p>
                </form>
              </div><!-- #respond -->
            </div>
          </div>
          @else
            {!! __('front.review_before_login',[ 'url' => route('front.login') ]) !!}
          @endif
          <div class="clear"></div>
        </div>
      </div>
    </div>
  </div>