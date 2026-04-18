@extends('frontend.master')
@section('title', 'page title')

@section('body')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="card card-body border-0">
                        <div class="main-img-div">
                            <img src="https://static.vecteezy.com/system/resources/thumbnails/049/855/347/small/nature-background-high-resolution-wallpaper-for-a-serene-and-stunning-view-photo.jpg" alt="" class="img-fluid w-100">
                        </div>
                        <div class="content-div">
                            <div>
                                <h2>heading heading heading heading heading </h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, nulla, officiis! Ad nemo odio omnis sapiente veniam. Beatae ipsa iste magnam minus nihil, officia perferendis, quas qui quod ratione vitae!</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, nulla, officiis! Ad nemo odio omnis sapiente veniam. Beatae ipsa iste magnam minus nihil, officia perferendis, quas qui quod ratione vitae!</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, nulla, officiis! Ad nemo odio omnis sapiente veniam. Beatae ipsa iste magnam minus nihil, officia perferendis, quas qui quod ratione vitae!</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, nulla, officiis! Ad nemo odio omnis sapiente veniam. Beatae ipsa iste magnam minus nihil, officia perferendis, quas qui quod ratione vitae!</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, nulla, officiis! Ad nemo odio omnis sapiente veniam. Beatae ipsa iste magnam minus nihil, officia perferendis, quas qui quod ratione vitae!</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, nulla, officiis! Ad nemo odio omnis sapiente veniam. Beatae ipsa iste magnam minus nihil, officia perferendis, quas qui quod ratione vitae!</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, nulla, officiis! Ad nemo odio omnis sapiente veniam. Beatae ipsa iste magnam minus nihil, officia perferendis, quas qui quod ratione vitae!</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, nulla, officiis! Ad nemo odio omnis sapiente veniam. Beatae ipsa iste magnam minus nihil, officia perferendis, quas qui quod ratione vitae!</p>
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
                            <a class="nav-link active" aria-current="page" href="#">Active</a>
                            <a class="nav-link" href="#">Link</a>
                            <a class="nav-link" href="#">Link</a>
                            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
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
