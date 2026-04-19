@extends('frontend.master')
@section('title', 'Contact Us')

@section('body')
    <section class="py-5">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <h2>Contact Us</h2>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="contact-form-box">
                        <h2>Feel Free to Send Us a Message</h2>
                        <form class="contact-form" method="post" action="{{ route('new-appointment') }}" novalidate>
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Your Name" value="{{ old('name') }}" data-label="Name" required>
                                    <div class="invalid-feedback">@error('name') {{ $message }} @enderror</div>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Your Email" value="{{ old('email') }}" data-label="Email address" required>
                                    <div class="invalid-feedback">@error('email') {{ $message }} @enderror</div>
                                </div>
                                <div class="col-md-6">
                                    <input type="tel" class="form-control @error('mobile') is-invalid @enderror" name="mobile" placeholder="Phone Number" value="{{ old('mobile') }}" data-label="Phone number" required>
                                    <div class="invalid-feedback">@error('mobile') {{ $message }} @enderror</div>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" placeholder="Subject" value="{{ old('subject') }}" data-label="Subject" required>
                                    <div class="invalid-feedback">@error('subject') {{ $message }} @enderror</div>
                                </div>
{{--                                <div class="col-md-6">--}}
{{--                                    <select class="form-select" name="company_service_id">--}}
{{--                                        <option selected disabled>Select Service</option>--}}
{{--                                        @foreach($services as $service)--}}
{{--                                            <option value="{{ $service->id }}">{{ $service->name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                        <option>Elderly Home Care</option>--}}
{{--                                        <option>Caregiver Services</option>--}}
{{--                                        <option>Patient Care Attendant</option>--}}
{{--                                        <option>Medical Equipment</option>--}}
{{--                                        <option>Oxygen Cylinder</option>--}}
{{--                                        <option>Physiotherapy</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
                                <div class="col-12">
                                    <textarea class="form-control @error('message') is-invalid @enderror" rows="5" name="message" placeholder="Your Message" data-label="Message">{{ old('message') }}</textarea>
                                    <div class="invalid-feedback">@error('message') {{ $message }} @enderror</div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="contact-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3648.5427850788574!2d90.3917!3d23.8759!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjPCsDUyJzMzLjIiTiA5MMKwMjMnMzAuMSJF!5e0!3m2!1sen!2sbd!4v1234567890" width="100%" height="100%" style="border:0; border-radius:8px; min-height:400px;" allowfullscreen="" loading="lazy"></iframe>
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
