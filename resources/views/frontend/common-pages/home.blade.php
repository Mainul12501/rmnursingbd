@extends('frontend.master')

@section('title', 'Home')

@push('style')
    <style>
        /* Why Choose Us Section */
        .why-choose-section {
            background-color: #dce8f5;
            padding: 60px 0;
        }
        .why-card {
            border-radius: 20px;
            padding: 40px 30px 35px;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .why-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.18);
        }
        .why-card--green {
            background-color: #2cc84d;
        }
        .why-card--blue {
            background-color: #046bd2;
        }
        .why-card__icon {
            margin-bottom: 20px;
        }
        .why-card__icon img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        .why-card__title {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 14px;
        }
        .why-card__text {
            color: rgba(255, 255, 255, 0.92);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 0;
        }
    </style>
@endpush

@section('body')
    <!-- ====== HERO SECTION ====== -->
    @if(isset($sliders) && count($sliders) > 0)
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div id="carouselExampleCaptions" class="carousel slide">
                            <div class="carousel-indicators">
                                @foreach($sliders as $index => $slider)
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" ></button>
                                @endforeach
{{--                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>--}}
{{--                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>--}}
                            </div>
                            <div class="carousel-inner">
                                @foreach($sliders as $key => $slider)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ asset($slider->image) }}" class="d-block w-100" alt="{{ $slider->title }}" style="height: 450px">
{{--                                        <div class="carousel-caption d-none d-md-block">--}}
{{--                                            <h1>{{ $slider->title ?? '' }}</h1>--}}
{{--                                            <p>{{ $slider->content ?? '' }}</p>--}}
{{--                                        </div>--}}
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

{{--    <section class="hero-section">--}}
{{--        <div class="container">--}}
{{--            <div class="row align-items-center">--}}
{{--                <div class="col-lg-6">--}}
{{--                    <div class="hero-content">--}}
{{--                        <h1>HOME<br>CAREGIVER<br>SERVICES</h1>--}}
{{--                        <p>We provide professional, reliable, and compassionate home healthcare services right at your doorstep in Dhaka.</p>--}}
{{--                        <div class="hero-buttons">--}}
{{--                            <a href="{{ route('contact-us') }}" class="btn btn-hero-green">Contact Us</a>--}}
{{--                            <a href="{{ route('service-categories') }}" class="btn btn-hero-outline">Our Services</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-6 d-none d-lg-block">--}}
{{--                    <div class="hero-image">--}}
{{--                        <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=600&h=500&fit=crop" alt="Home Care Services" class="img-fluid hero-img-main">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- Hero bottom cards -->--}}
{{--        <div class="hero-bottom-cards">--}}
{{--            <div class="container">--}}
{{--                <div class="row g-3">--}}
{{--                    <div class="col-lg-4 col-md-4">--}}
{{--                        <div class="hero-card" style="height: 100%">--}}
{{--                            <div class="hero-card-icon"><i class="fas fa-user-nurse"></i></div>--}}
{{--                            <div>--}}
{{--                                <h4>Professional Nurses</h4>--}}
{{--                                <p>Experienced, compassionate nurses provide personalized in-home care for recovery, chronic conditions and daily support.</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-lg-4 col-md-4">--}}
{{--                        <div class="hero-card" style="height: 100%">--}}
{{--                            <div class="hero-card-icon"><i class="fas fa-clock"></i></div>--}}
{{--                            <div>--}}
{{--                                <h4>24/7 Available</h4>--}}
{{--                                <p>At {{ $siteSetting->meta_title ?? 'RM Nursing BD' }}, we’re committed to offering exceptional healthcare 24/7.</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-lg-4 col-md-4">--}}
{{--                        <div class="hero-card" style="height: 100%">--}}
{{--                            <div class="hero-card-icon"><i class="fas fa-phone-alt"></i></div>--}}
{{--                            <div>--}}
{{--                                <h4>Guaranteed Satisfaction</h4>--}}
{{--                                <p>We’re dedicated to exceeding your expectations, offering a comprehensive Satisfaction Guarantee on all our services.</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

    <!-- ====== WHY CHOOSE US SECTION ====== -->
    <section class="why-choose-section" id="generateContentHere">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title">Why Choose Us</h2>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="why-card why-card--green">
                        <div class="why-card__icon">
                            <img src="{{ asset('frontend/nurse.png') }}" alt="Professional Nurses">
                        </div>
                        <h3 class="why-card__title">Professional Nurses</h3>
                        <p class="why-card__text">Experienced, compassionate nurses provide personalized in-home care for recovery, chronic conditions and daily support.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="why-card why-card--blue">
                        <div class="why-card__icon">
                            <img src="{{ asset('frontend/low-cost.png') }}" alt="Affordable Prices">
                        </div>
                        <h3 class="why-card__title">Affordable Prices</h3>
                        <p class="why-card__text">At {{ $siteSetting->meta_title ?? 'RM Nursing BD' }}, we're committed to offering exceptional healthcare at affordable prices.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="why-card why-card--blue">
                        <div class="why-card__icon">
                            <img src="{{ asset('frontend/satisfaction.png') }}" alt="Guaranteed Satisfaction">
                        </div>
                        <h3 class="why-card__title">Guaranteed Satisfaction</h3>
                        <p class="why-card__text">We're dedicated to exceeding your expectations, offering a comprehensive Satisfaction Guarantee on all our services.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== ABOUT / WELCOME SECTION ====== -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <div class="about-logo-block">
                        <img src="{{ asset('frontend/h-banner.jpeg') }}" alt="rmnursingbd banner" class="<!--about-logo-->">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="about-content">
                        <span class="section-subtitle">WHO WE ARE</span>
                        <h2 class="section-title">Welcome to<br><strong>{{ $siteSetting->meta_title ?? 'RM Nursing BD' }}</strong></h2>
                        <p>{{ $siteSetting->meta_title ?? 'RM Nursing BD' }} is a leading home healthcare service provider in Dhaka, Bangladesh. We are committed to delivering compassionate, professional, and affordable medical care to patients in the comfort of their own homes.</p>
                        <p>Our team of certified nurses, trained caregivers, and experienced physiotherapists work dedicatedly to ensure every patient receives personalized attention and quality care. We understand that healing happens best in a familiar environment surrounded by loved ones.</p>
                        <a href="{{ route('service-categories') }}" class="btn btn-primary-custom">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== OUR SERVICES SECTION ====== -->
    <section id="services" class="services-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Our Service</h2>
                <p class="section-desc">We provide top-quality home healthcare services across Dhaka</p>
            </div>
            <div class="row g-4">
                @foreach($services as $service)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card">
                            @if(isset($service->page_main_image))
                                <div class="service-img">
                                    <img src="{{ asset($service->page_main_image) }}" alt="Nursing Service">
                                </div>
                            @endif
                            <div class="service-body">
                                <h3>{{ $service->name ?? 'Service Name' }}</h3>
                                <p>{!! str()->words($service->page_content, 30, '...') !!}</p>
                                <a href="{{ route('service-details', ['companyServiceSlug' => $service->slug]) }}" class="service-read-more">Read More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach

{{--                <div class="col-lg-4 col-md-6">--}}
{{--                    <div class="service-card">--}}
{{--                        <div class="service-img">--}}
{{--                            <img src="https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?w=400&h=250&fit=crop" alt="Elderly Care">--}}
{{--                        </div>--}}
{{--                        <div class="service-body">--}}
{{--                            <h3>Elderly Home Care Services</h3>--}}
{{--                            <p>Dedicated caregivers for elderly family members providing daily assistance, medication management, and companionship at home.</p>--}}
{{--                            <a href="#" class="service-read-more">Read More <i class="fas fa-arrow-right"></i></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 col-md-6">--}}
{{--                    <div class="service-card">--}}
{{--                        <div class="service-img">--}}
{{--                            <img src="https://images.unsplash.com/photo-1631815588090-d4bfec5b1b89?w=400&h=250&fit=crop" alt="Caregiver Service">--}}
{{--                        </div>--}}
{{--                        <div class="service-body">--}}
{{--                            <h3>Caregiver Home Services</h3>--}}
{{--                            <p>Trained and compassionate caregivers to assist patients with daily living activities, personal hygiene, and mobility support.</p>--}}
{{--                            <a href="#" class="service-read-more">Read More <i class="fas fa-arrow-right"></i></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 col-md-6">--}}
{{--                    <div class="service-card">--}}
{{--                        <div class="service-img">--}}
{{--                            <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=400&h=250&fit=crop" alt="Patient Care">--}}
{{--                        </div>--}}
{{--                        <div class="service-body">--}}
{{--                            <h3>Patient Care Attendant</h3>--}}
{{--                            <p>Experienced patient care attendants providing round-the-clock support for bedridden and critically ill patients.</p>--}}
{{--                            <a href="#" class="service-read-more">Read More <i class="fas fa-arrow-right"></i></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 col-md-6">--}}
{{--                    <div class="service-card">--}}
{{--                        <div class="service-img">--}}
{{--                            <img src="https://images.unsplash.com/photo-1583912267550-d6c2ac3abe3f?w=400&h=250&fit=crop" alt="Medical Equipment">--}}
{{--                        </div>--}}
{{--                        <div class="service-body">--}}
{{--                            <h3>Medical Equipment Sales & Rental</h3>--}}
{{--                            <p>Hospital beds, wheelchairs, oxygen concentrators, and other essential medical equipment available for sale and rental.</p>--}}
{{--                            <a href="#" class="service-read-more">Read More <i class="fas fa-arrow-right"></i></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 col-md-6">--}}
{{--                    <div class="service-card">--}}
{{--                        <div class="service-img">--}}
{{--                            <img src="https://images.unsplash.com/photo-1530497610245-94d3c16cda28?w=400&h=250&fit=crop" alt="Physiotherapy">--}}
{{--                        </div>--}}
{{--                        <div class="service-body">--}}
{{--                            <h3>Physiotherapy Home Services</h3>--}}
{{--                            <p>Licensed physiotherapists providing rehabilitation exercises, pain management, and mobility improvement at your home.</p>--}}
{{--                            <a href="#" class="service-read-more">Read More <i class="fas fa-arrow-right"></i></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </section>

    <!-- ====== FAQ SECTION ====== -->
    <section class="faq-section">
        <div class="container">
            <div class="faq-wrapper">
                <h2 class="text-center mb-4">Frequently Asked Questions (FAQs)</h2>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true">
                                What services does {{ $siteSetting->meta_title ?? 'RM Nursing BD' }} provide?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">We provide home care nursing, elderly care, caregiver services, patient care attendant, medical equipment rental & sales, oxygen cylinder services, 24/7 on-call nursing, and physiotherapy at home across Dhaka.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                How do I book a nurse or caregiver?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">You can book a nurse or caregiver by calling us at +880 1754-839059 or by filling out the contact form on our website. Our team will respond within a few hours.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Are your nurses certified and experienced?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">Yes, all our nurses are certified, trained, and experienced. They undergo thorough background checks and regular training to ensure the highest quality of care.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                What areas in Dhaka do you cover?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">We cover all major areas of Dhaka including Uttara, Dhanmondi, Gulshan, Banani, Mirpur, Mohammadpur, Bashundhara, and surrounding areas.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                What are your service charges?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">Our service charges vary depending on the type of service, duration, and specific requirements. Please contact us for a detailed quote. We offer competitive and transparent pricing.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== FACILITIES SECTION ====== -->
    <section id="facilities" class="facilities-section">
        <div class="container">
            <div class="mb-4 text-center">
                <h2 class="section-title">Our Facilities</h2>
                <p class="section-subtitle-text">{{ $siteSetting->meta_title ?? 'RM Nursing BD' }}</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="facility-card">
                        <div class="facility-img">
                            <img src="https://images.unsplash.com/photo-1551190822-a9ce113ac100?w=400&h=250&fit=crop" alt="ICU Setup">
                        </div>
                        <div class="facility-body">
                            <h3>ICU Setup at Home</h3>
                            <p>Complete ICU setup with ventilator, monitor, and all necessary medical equipment at your home.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="facility-card">
                        <div class="facility-img">
                            <img src="https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?w=400&h=250&fit=crop" alt="Oxygen Supply">
                        </div>
                        <div class="facility-body">
                            <h3>Oxygen Cylinder Supply</h3>
                            <p>24/7 oxygen cylinder delivery, refill, and rental services across all areas of Dhaka city.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="facility-card">
                        <div class="facility-img">
                            <img src="https://images.unsplash.com/photo-1579684453423-f84349ef60b0?w=400&h=250&fit=crop" alt="Medical Equipment">
                        </div>
                        <div class="facility-body">
                            <h3>Medical Equipment Rental</h3>
                            <p>Hospital beds, wheelchairs, patient monitors and other medical equipment available for rent.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== BOOK APPOINTMENT CTA ====== -->
    <section class="appointment-section">
        <div class="container">
            <div class="appointment-bar">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-7">
                        <h2>Book an Appointment</h2>
                        <p>Get professional home care services. Call us now or fill out the form to book.</p>
                    </div>
                    <div class="col-lg-4 col-md-5 text-md-end">
                        <a href="tel:{{ $siteSetting ? $siteSetting->office_mobile : '' }}" class="btn btn-appointment"><i class="fas fa-phone-alt me-2"></i> {{ $siteSetting ? $siteSetting->office_mobile : '01700000000' }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== CLIENT REVIEWS ====== -->
    @if(isset($clientReviews) && count($clientReviews) > 0)
        <section class="reviews-section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Client's Reviews</h2>
                    <p class="section-desc">What our clients say about us</p>
                </div>
                <div class="owl-carousel owl-theme review-carousel">
                    @foreach($clientReviews as $clientReview)
                        <div class="item">
                            <div class="review-card">
                                <div class="review-stars">
                                    @for($i = 1; $i <= $clientReview->rating; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                                <p>"{!! $clientReview->content ?? '' !!}"</p>
                                <div class="review-author">
                                    <div class="review-avatar">
                                        @if($clientReview->client_image && file_exists(public_path($clientReview->client_image)))
                                            <img src="{{ asset($clientReview->client_image) }}" alt="{{ $clientReview->client_name }}" style="border-radius: 50%" />
                                        @else
                                            <i class="fas fa-user"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4>{{ $clientReview->client_name }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


{{--                    <div class="col-lg-4 col-md-6">--}}
{{--                        <div class="review-card">--}}
{{--                            <div class="review-stars">--}}
{{--                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>--}}
{{--                            </div>--}}
{{--                            <p>"We hired a caregiver for my elderly mother and the service has been excellent. The caregiver is kind, patient, and treats my mother like family."</p>--}}
{{--                            <div class="review-author">--}}
{{--                                <div class="review-avatar"><i class="fas fa-user"></i></div>--}}
{{--                                <div>--}}
{{--                                    <h4>Nasreen Begum</h4>--}}
{{--                                    <span>Dhanmondi, Dhaka</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-lg-4 col-md-6">--}}
{{--                        <div class="review-card">--}}
{{--                            <div class="review-stars">--}}
{{--                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>--}}
{{--                            </div>--}}
{{--                            <p>"Quick response time and professional service. The oxygen cylinder was delivered within an hour. Their 24/7 availability is truly a lifesaver."</p>--}}
{{--                            <div class="review-author">--}}
{{--                                <div class="review-avatar"><i class="fas fa-user"></i></div>--}}
{{--                                <div>--}}
{{--                                    <h4>Kamal Hossain</h4>--}}
{{--                                    <span>Gulshan, Dhaka</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </section>
    @endif


    <!-- ====== NEWS & EVENTS ====== -->
    <section id="news" class="news-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">News & Events</h2>
                <p class="section-desc">Stay updated with the latest health tips and news</p>
            </div>
            <div class="row g-4">
                @foreach($newsEvents as $newsEvent)
                    <div class="col-lg-4 col-md-6">
                        <div class="news-card">
                            <div class="news-img">
                                <img src="{{ asset($newsEvent->main_image) }}" alt="News" class="">
                                <span class="news-date">{{ $newsEvent->created_at->format('D M') }}</span>
                            </div>
                            <div class="news-body">
                                <h3><a href="#">{{ $newsEvent->main_title ?? '' }}</a></h3>
                                <p>{!! str()->words($newsEvent->main_content, 30, '...') !!}</p>
                                <a href="{{ route('news-event-details', ['newsEventSlug' => $newsEvent->slug]) }}" class="read-more-link">Read More <i class="fas fa-long-arrow-alt-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach

{{--                <div class="col-lg-4 col-md-6">--}}
{{--                    <div class="news-card">--}}
{{--                        <div class="news-img">--}}
{{--                            <img src="https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?w=400&h=220&fit=crop" alt="News">--}}
{{--                            <span class="news-date">18 Feb</span>--}}
{{--                        </div>--}}
{{--                        <div class="news-body">--}}
{{--                            <h3><a href="#">Elderly Care Tips: How to Care for Aging Parents at Home</a></h3>--}}
{{--                            <p>Practical tips and advice for families caring for elderly parents at home with professional support...</p>--}}
{{--                            <a href="#" class="read-more-link">Read More <i class="fas fa-long-arrow-alt-right"></i></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-4 col-md-6">--}}
{{--                    <div class="news-card">--}}
{{--                        <div class="news-img">--}}
{{--                            <img src="https://images.unsplash.com/photo-1530497610245-94d3c16cda28?w=400&h=220&fit=crop" alt="News">--}}
{{--                            <span class="news-date">05 Jan</span>--}}
{{--                        </div>--}}
{{--                        <div class="news-body">--}}
{{--                            <h3><a href="#">Oxygen Cylinder Services Now Available Across All Dhaka Areas</a></h3>--}}
{{--                            <p>We have expanded our oxygen cylinder delivery and rental services to cover all major areas of Dhaka...</p>--}}
{{--                            <a href="#" class="read-more-link">Read More <i class="fas fa-long-arrow-alt-right"></i></a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </section>

    <!-- ====== CONTACT / MESSAGE FORM SECTION ====== -->
    <section id="contact" class="contact-section">
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

            <div class="row g-5">
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
{{--                                    <select class="form-select">--}}
{{--                                        <option selected disabled>Select Service</option>--}}
{{--                                        <option>Home Care Nursing</option>--}}
{{--                                        <option>Elderly Home Care</option>--}}
{{--                                        <option>Caregiver Services</option>--}}
{{--                                        <option>Patient Care Attendant</option>--}}
{{--                                        <option>Medical Equipment</option>--}}
{{--                                        <option>Oxygen Cylinder</option>--}}
{{--                                        <option>Physiotherapy</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
                                <div class="col-12">
                                    <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="5" placeholder="Your Message" data-label="Message">{{ old('message') }}</textarea>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function () {
            $('.review-carousel').owlCarousel({
                loop: true,
                margin: 24,
                nav: false,
                dots: true,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 },
                    1024: { items: 3 }
                }
            });
        });
    </script>
@endpush
