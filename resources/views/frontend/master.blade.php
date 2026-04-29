<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ $siteSetting->meta_description ?? '' }}">
    <title>{{ $siteSetting->title ?? '' }} - Trusted Home Care Services in Dhaka | @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset($siteSetting->favicon ?? '/frontend/favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800&family=Archivo+Narrow:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Mainul12501/css-common-helper-classes/helper.min.css">
    {!! $siteSetting ? $siteSetting->header_custom_code : '' !!}
    <link rel="stylesheet" href="{{ asset('/frontend/css/style.css') }}">
    <style>
        /* Show dropdown on hover */
        .nav-item.dropdown:hover .home-service-menu {
            display: block !important;
        }

        /* Optional: prevent flicker when moving mouse to dropdown */
        .home-service-menu {
            margin-top: 0 !important;
        }
    </style>
    @stack('style')
</head>
<body>

<!-- ====== TOP BAR ====== -->
<div class="top-bar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="top-bar-left xx">
                <a href="tel:+88{{ $siteSetting ? $siteSetting->office_mobile : '' }}"><i class="fas fa-phone-alt"></i> {{ $siteSetting ? $siteSetting->office_mobile : '' }}</a>
                <a href="tel:+88{{ $siteSetting ? $siteSetting->office_address : '' }}" class="ms-3"><i class="fas fa-address-card"></i> {{ $siteSetting ? $siteSetting->office_address : '' }}</a>
            </div>
            <div class="top-bar-right">
                <a target="_blank" href="{{ $siteSetting ? $siteSetting->linkedin : '' }}"><i class="fab fa-linkedin-in"></i></a>
                <a target="_blank" href="{{ $siteSetting ? $siteSetting->fb : '' }}"><i class="fab fa-facebook-f"></i></a>
                <a target="_blank" href="https://wa.me/{{ $siteSetting ? $siteSetting->whatsapp : '' }}"><i class="fab fa-whatsapp"></i></a>
                <a target="_blank" href="{{ $siteSetting ? $siteSetting->x : '' }}"><i class="fab fa-x-twitter"></i></a>
                <a target="_blank" href="{{ $siteSetting ? $siteSetting->insta : '' }}"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- ====== MAIN NAVBAR ====== -->
<nav class="navbar navbar-expand-lg sticky-top main-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset($siteSetting ? $siteSetting->menu_logo : 'https://t4.ftcdn.net/jpg/06/18/70/35/360_F_618703552_WeVTEs8XmeEb1hGiEZ5ZjJXSbx4yiiPm.jpg') }}" alt="Doctors Home Care Ltd" class="logo-img">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">Home</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle home-service-menu-btn" href="{{ route('service-categories') }}" data-bs-toggle="dropdown">Services</a>
                    <ul class="dropdown-menu home-service-menu">
                        @foreach($services as $service)
                            <li><a class="dropdown-item" href="{{ route('service-details', ['companyServiceSlug' => $service->slug]) }}">{{ $service->name ?? '' }}</a></li>
                        @endforeach
{{--                        <li><a class="dropdown-item" href="#">Elderly Home Care Services</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#">Caregiver Home Services</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#">Patient Care Attendant Services</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#">Medical Equipment Sales & Rental</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#">Oxygen Cylinder Services</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#">24/7 On-Call Nursing Services</a></li>--}}
{{--                        <li><a class="dropdown-item" href="#">Physiotherapy Home Services</a></li>--}}
                    </ul>
                </li>
                @foreach($pages as $page)
                    <li class="nav-item"><a class="nav-link" href="{{ route('page-details', ['pageSlug' => $page->slug]) }}">{{ $page->page_title }}</a></li>
                @endforeach
{{--                <li class="nav-item"><a class="nav-link" href="#">Our Documents</a></li>--}}
{{--                <li class="nav-item"><a class="nav-link" href="#facilities">Facilities</a></li>--}}
                <li class="nav-item"><a class="nav-link" href="{{ route('news-event-category') }}">News & Events</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact-us') }}">Contact Us</a></li>
            </ul>
        </div>
    </div>
</nav>

@yield('body')

<!-- ====== FOOTER ====== -->
<footer class="main-footer">
    <div class="footer-top">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget">
                        <img src="{{ asset($siteSetting ? $siteSetting->logo : '') }}" alt="Logo" class="footer-logo">
                        <p>{{ $siteSetting ? $siteSetting->meta_footer : 'Appnexaa is Dhaka\'s trusted provider of professional home healthcare services including nursing, elderly care, caregiver support, and medical equipment.' }}</p>
                        <div class="footer-social">
                            <a target="_blank" href="{{ $siteSetting ? $siteSetting->fb : '' }}"><i class="fab fa-facebook-f"></i></a>
                            <a target="_blank" href="{{ $siteSetting ? $siteSetting->linkedin : '' }}"><i class="fab fa-linkedin-in"></i></a>
                            <a target="_blank" href="https://web.whatsapp.com/send?phone=88{{ $siteSetting->whatsapp ?? '' }}&text="><i class="fab fa-whatsapp"></i></a>
                            <a target="_blank" href="{{ $siteSetting ? $siteSetting->insta : '' }}"><i class="fab fa-instagram"></i></a>
                            <a target="_blank" href="{{ $siteSetting ? $siteSetting->x : '' }}"><i class="fab fa-x-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="footer-widget">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('service-categories') }}">Services</a></li>
                            @foreach($pages as $page)
                                <li><a href="{{ route('page-details', ['pageSlug' => $page->slug]) }}">{{ $page->page_title ?? '' }}</a></li>
                            @endforeach
{{--                            <li><a href="#facilities">Facilities</a></li>--}}
                            <li><a href="{{ route('news-event-category') }}">News</a></li>
                            <li><a href="{{ route('contact-us') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h4>Our Services</h4>
                        <ul>
                            @foreach($services as $service)
                                <li><a href="{{ route('service-details', ['companyServiceSlug' => $service->slug]) }}">{{ $service->name ?? '' }}</a></li>
                            @endforeach
{{--                            <li><a href="#">Elderly Home Care</a></li>--}}
{{--                            <li><a href="#">Caregiver Services</a></li>--}}
{{--                            <li><a href="#">Patient Care</a></li>--}}
{{--                            <li><a href="#">Medical Equipment</a></li>--}}
{{--                            <li><a href="#">Oxygen Cylinder</a></li>--}}
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h4>Contact Information</h4>
                        <div class="footer-contact-list">
                            <div class="footer-contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $siteSetting ? $siteSetting->office_address : 'Office Address, Dhaka' }}</span>
                            </div>
                            <div class="footer-contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <a href="tel:+88{{ $siteSetting ? $siteSetting->office_mobile : '' }}">{{ $siteSetting ? $siteSetting->office_mobile : '+8801700000000' }}</a>
                            </div>
                            <div class="footer-contact-item">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:{{ $siteSetting ? $siteSetting->office_email : '' }}">{{ $siteSetting ? $siteSetting->office_email : 'office@email.com' }}</a>
                            </div>
                            <div class="footer-contact-item">
                                <i class="fas fa-clock"></i>
                                <span>Mon - Sun: 9AM - 5PM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <p>&copy; {{ date('Y') }} {{ $siteSetting ? $siteSetting->site_title : '' }}. All rights reserved.</p>
                <p>Designed by Appnexaa</p>
            </div>
        </div>
    </div>
</footer>

<!-- ====== WHATSAPP FLOAT ====== -->
<a href="https://wa.me/{{ $siteSetting ? $siteSetting->whatsapp : '' }}" class="whatsapp-float" target="_blank" rel="noopener">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- ====== BACK TO TOP ====== -->
<a href="#" class="back-to-top" id="backToTop">
    <i class="fas fa-chevron-up"></i>
</a>

{{--<script src="{{ asset('/') }}frontend/js/jquery-4.0.0.min.js"></script>--}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ asset('/') }}frontend/js/bootstrap.bundle.min.js"></script>
{!! $siteSetting ? $siteSetting->footer_custom_code : '' !!}
<script src="{{ asset('/') }}frontend/js/script.js"></script>
@stack('script')
</body>
</html>
