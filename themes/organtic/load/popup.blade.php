<div style="display:none">
    <img src="{{asset('assets/images/'.$gs->popup_background)}}">
</div>

<!--  Starting of subscribe-pre-loader Area   -->
<div class="subscribe-preloader-wrap" id="subscriptionForm" style="display: none;">
    <div class="subscribePreloader__thumb"
         style="background-image: url({{asset('assets/images/'.$gs->popup_background)}});">
        <span class="preload-close"><i class="fas fa-times"></i></span>
        <div class="subscribePreloader__text text-center">
            <h1>{{$gs->popup_title}}</h1>
            <p>{{$gs->popup_text}}</p>
            <form action="{{route('front.subscribe')}}" id="subscribeform" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <input type="email" name="email" placeholder="{{ $langg->lang741 }}" required="">
                    <button id="sub-btn" type="submit">{{ $langg->lang742 }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  Ending of subscribe-pre-loader Area   -->