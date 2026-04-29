@extends('frontend.master')
@section('title', 'News Category')

@section('body')
    <section class="pb-5">
        <div class="bg-primary py-5">
            <h3 class="text-center text-white">News & Events</h3>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div>
                        <div class="row mt-3">
                            @foreach($newsEvents as $newsEvent)
                                <div class="col-md-4">
                                    <div class="card">
                                        <img src="{{ asset($newsEvent->main_image ?? '') }}" alt="" class="card-img-top w-100 img-fluid"  style="height: 240px"/>
                                        <div class="card-body">
                                            <h3>{{ $newsEvent->title ?? '' }}</h3>
                                            <div>
                                                {!! str()->words($newsEvent->main_content, 30, '....') !!}
                                            </div>
                                            <div class="text-center mt-2">
                                                <a href="{{ route('service-details', ['companyServiceSlug' => $newsEvent->slug]) }}" class="btn btn-secondary">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

{{--                            <div class="col-md-4">--}}
{{--                                <div class="card">--}}
{{--                                    <img src="https://static.vecteezy.com/system/resources/thumbnails/049/855/347/small/nature-background-high-resolution-wallpaper-for-a-serene-and-stunning-view-photo.jpg" alt="" class="card-img-top w-100 img-fluid" />--}}
{{--                                    <div class="card-body">--}}
{{--                                        <h3>Content Title</h3>--}}
{{--                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore itaque necessitatibus nihil possimus! Alias aperiam atque deserunt dolore doloribus eaque enim ipsa magnam nemo numquam odit optio quos, sapiente vel?</p>--}}
{{--                                        <div class="text-center mt-2">--}}
{{--                                            <a href="" class="btn btn-secondary">Read More</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <h3 class="text-center">Our Other Services</h3>
                        <nav class="nav flex-column">
                            @foreach($services as $service)
                                <a class="nav-link" href="{{ route('service-details', ['companyServiceSlug' => $service->slug]) }}">{{ $service->name }}</a>
                            @endforeach
{{--                            <a class="nav-link" href="#">Link</a>--}}
{{--                            <a class="nav-link disabled" aria-disabled="true">Disabled</a>--}}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')

@endpush

@push('script')

@endpush
