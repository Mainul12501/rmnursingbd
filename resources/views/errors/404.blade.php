@extends('frontend.master')

@section('title', '404 - Page not found')

@push('style')
    <link rel="stylesheet" href="{{ asset('errors/404.css') }}">
@endpush

@section('body')

    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-11  text-center mx-auto">
                    <div class="">
                        <div class="four_zero_four_bg"></div>
                        <div class="contant_box_404 card card-body border-0 py-0">
{{--                            <div class="text-center"><img src="https://cdn.pixabay.com/animation/2023/03/27/01/48/01-48-55-810_512.gif" alt=""></div>--}}
                            <h1 class="text-center mt-3 f-s-36 py-0">404</h1>
                            <h3 class="h2">
                                Sorry!! We couldn't find what you were looking for.
                            </h3>

                            <p>Unfortunately the page you were looking for could not be found. It may be temporarily unavailable, moved or no longer exist.</p>
                            <p>Check the URL you entered for any mistakes and try again. Alternatively, search for whatever is missing or take a look around the rest of our site.</p>

                            <a href="{{ route('home') }}" class="link_404">Go to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
