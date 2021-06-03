<div class="container">
    <div class="row our-features-box">
        @foreach($services->chunk(4) as $chunk)
        <ul>
           @foreach($chunk as $service)
            <li>
                <div class="feature-box">
                    <div class="icon">
                        <img src="{{ asset('assets/images/services/'.$service->photo) }}">
                    </div>
                    <h4 class="title">{{ $service->title }}</h4>
                    <p class="text">
                        {!! $service->details !!}
                    </p>
                </div>
            </li>
            @endforeach
        </ul>
        @endforeach
    </div>
</div>
<!-- For version 1,2,3,4,6 -->