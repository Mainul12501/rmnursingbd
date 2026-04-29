@extends('frontend.master')
@section('title', $service->name ?? 'service title')

@section('body')
    <section class="pb-5">
        <div class="bg-primary py-5">
            <h3 class="text-center text-white">{{ $service->name ?? '' }}</h3>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="card card-body border-0">

                        @if($service->page_main_image)
                            <div class="main-img-div">
                                <img src="{{ asset($service->page_main_image) }}" alt="" class="img-fluid w-100">
                            </div>
                        @endif

                        <div class="content-div">
                            <div>
                                <h2>{{ $service->content_title }} </h2>
                                <div>
                                    {!! $service->page_content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <h3 class="text-center">Our Other Services</h3>
                    <div>
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
