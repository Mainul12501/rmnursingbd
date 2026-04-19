@extends('frontend.master')
@section('title', $page->page_title ?? 'page title')

@section('body')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="card card-body border-0">
                        @if(isset($page->main_image))
                            <div class="main-img-div">
                                <img src="{{ asset($page->main_image) }}" alt="" class="img-fluid w-100">
                            </div>
                        @endif

                        <div class="content-div">
                            <div>
                                <h2>{{ $page->page_title }} </h2>
                                <div>
                                    {!! $page->page_content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <h4 class="text-center fw-bolder">Our Other Services</h4>
                    </div>
                    <div>
                        <nav class="nav flex-column">
                            @foreach($services as $service)
                                <a class="nav-link" href="{{ route('service-details', ['companyServiceSlug' => $service->slug]) }}">{{ $service->name }}</a>
                            @endforeach

{{--                            <a class="nav-link" href="#">Link</a>--}}
{{--                            <a class="nav-link" href="#">Link</a>--}}
{{--                            <a class="nav-link disabled" aria-disabled="true">Disabled</a>--}}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

{{--    appointment booking section--}}
    <section class="py-5 ">
        <div class="container">
            <div class="row">
                <div class="col-md-11 mx-auto">
                    <div class="card bg-dark text-white p-b-70 p-t-70" >
                        <div class="d-flex flex-column flex-md-row align-items-center align-items-md-center mx-auto">
                            <h2 class="text-white fw-bolder mb-3 mb-md-0 f-s-42 footer-book-appointment" >
                                Book an Appointment
                            </h2>
                            <a href="{{ route('contact-us') }}" class="btn btn-primary ms-md-5">
                                Appointment Now
                            </a>
                        </div>
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
