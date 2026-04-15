<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Company Name - Trusted Home Care Services in Dhaka | @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800&family=Archivo+Narrow:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}frontend/css/style.css">
    @stack('style')
</head>
<body>

<!-- ====== TOP BAR ====== -->
<div class="top-bar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="top-bar-left">
                <a href="tel:+8801754839059"><i class="fas fa-phone-alt"></i> +880 1754-839059</a>
            </div>
            <div class="top-bar-right">
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-whatsapp"></i></a>
                <a href="#"><i class="fab fa-x-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- ====== MAIN NAVBAR ====== -->
<nav class="navbar navbar-expand-lg sticky-top main-navbar">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="https://doctorshomecarebd.com/wp-content/uploads/2025/05/cropped-Doctors-Home-Care-Logo-1-1.png" alt="Doctors Home Care Ltd" class="logo-img">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Services</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Home Care Nursing Services</a></li>
                        <li><a class="dropdown-item" href="#">Elderly Home Care Services</a></li>
                        <li><a class="dropdown-item" href="#">Caregiver Home Services</a></li>
                        <li><a class="dropdown-item" href="#">Patient Care Attendant Services</a></li>
                        <li><a class="dropdown-item" href="#">Medical Equipment Sales & Rental</a></li>
                        <li><a class="dropdown-item" href="#">Oxygen Cylinder Services</a></li>
                        <li><a class="dropdown-item" href="#">24/7 On-Call Nursing Services</a></li>
                        <li><a class="dropdown-item" href="#">Physiotherapy Home Services</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">Our Documents</a></li>
                <li class="nav-item"><a class="nav-link" href="#facilities">Facilities</a></li>
                <li class="nav-item"><a class="nav-link" href="#news">News & Events</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
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
                        <img src="https://doctorshomecarebd.com/wp-content/uploads/2025/05/cropped-Doctors-Home-Care-Logo-1-1.png" alt="Logo" class="footer-logo">
                        <p>Doctors Home Care Ltd is Dhaka's trusted provider of professional home healthcare services including nursing, elderly care, caregiver support, and medical equipment.</p>
                        <div class="footer-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-whatsapp"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-x-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="footer-widget">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#about">About Us</a></li>
                            <li><a href="#services">Services</a></li>
                            <li><a href="#facilities">Facilities</a></li>
                            <li><a href="#news">News</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h4>Our Services</h4>
                        <ul>
                            <li><a href="#">Home Care Nursing</a></li>
                            <li><a href="#">Elderly Home Care</a></li>
                            <li><a href="#">Caregiver Services</a></li>
                            <li><a href="#">Patient Care</a></li>
                            <li><a href="#">Medical Equipment</a></li>
                            <li><a href="#">Oxygen Cylinder</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h4>Contact Information</h4>
                        <div class="footer-contact-list">
                            <div class="footer-contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>House 20, Road 05, Sector 13, Uttara, Dhaka 1230</span>
                            </div>
                            <div class="footer-contact-item">
                                <i class="fas fa-phone-alt"></i>
                                <a href="tel:+8801754839059">+880 1754-839059</a>
                            </div>
                            <div class="footer-contact-item">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:info@doctorshomecarebd.com">info@doctorshomecarebd.com</a>
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
                <p>&copy; 2025 Doctors Home Care Ltd. All rights reserved.</p>
                <p>Designed by Doctors Home Care Ltd</p>
            </div>
        </div>
    </div>
</footer>

<!-- ====== WHATSAPP FLOAT ====== -->
<a href="https://wa.me/8801754839059" class="whatsapp-float" target="_blank" rel="noopener">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- ====== BACK TO TOP ====== -->
<a href="#" class="back-to-top" id="backToTop">
    <i class="fas fa-chevron-up"></i>
</a>

<script src="{{ asset('/') }}frontend/js/jquery-4.0.0.min.js"></script>
<script src="{{ asset('/') }}frontend/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('/') }}frontend/js/script.js"></script>
@stack('script')
</body>
</html>
