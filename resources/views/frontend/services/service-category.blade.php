@extends('frontend.master')
@section('title', 'Our Services')

@section('body')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div>
                        <h3>Page Title like Our Service <br> What we offer to you</h3>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="https://static.vecteezy.com/system/resources/thumbnails/049/855/347/small/nature-background-high-resolution-wallpaper-for-a-serene-and-stunning-view-photo.jpg" alt="" class="card-img-top w-100 img-fluid" />
                                    <div class="card-body">
                                        <h3>Content Title</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore itaque necessitatibus nihil possimus! Alias aperiam atque deserunt dolore doloribus eaque enim ipsa magnam nemo numquam odit optio quos, sapiente vel?</p>
                                        <div class="text-center mt-2">
                                            <a href="" class="btn btn-secondary">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="https://static.vecteezy.com/system/resources/thumbnails/049/855/347/small/nature-background-high-resolution-wallpaper-for-a-serene-and-stunning-view-photo.jpg" alt="" class="card-img-top w-100 img-fluid" />
                                    <div class="card-body">
                                        <h3>Content Title</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore itaque necessitatibus nihil possimus! Alias aperiam atque deserunt dolore doloribus eaque enim ipsa magnam nemo numquam odit optio quos, sapiente vel?</p>
                                        <div class="text-center mt-2">
                                            <a href="" class="btn btn-secondary">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
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
@endsection

@push('style')

@endpush

@push('script')

@endpush
