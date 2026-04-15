$(document).ready(function () {

    // ========== Sticky Navbar Shadow on Scroll ==========
    $(window).on('scroll', function () {
        var scrollTop = $(this).scrollTop();

        // Navbar shadow
        if (scrollTop > 50) {
            $('.main-navbar').addClass('scrolled');
        } else {
            $('.main-navbar').removeClass('scrolled');
        }

        // Back to top button
        if (scrollTop > 400) {
            $('#backToTop').addClass('visible');
        } else {
            $('#backToTop').removeClass('visible');
        }
    });

    // ========== Back to Top ==========
    $('#backToTop').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 500);
    });

    // ========== Smooth Scroll for Anchor Links ==========
    $('a[href^="#"]').not('[data-bs-toggle]').on('click', function (e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 85
            }, 600);

            // Close mobile menu if open
            var navCollapse = $('#mainNav');
            if (navCollapse.hasClass('show')) {
                navCollapse.collapse('hide');
            }
        }
    });

    // ========== Scroll Reveal Animation ==========
    function revealOnScroll() {
        var windowHeight = $(window).height();
        var revealPoint = 100;

        $('.service-card, .why-card, .news-card, .testimonial-card, .stat-item, .about-content, .about-image-wrapper, .contact-info-wrapper, .contact-form-wrapper').each(function () {
            var elementTop = $(this).offset().top;
            var scrollTop = $(window).scrollTop();

            if (elementTop < scrollTop + windowHeight - revealPoint) {
                $(this).addClass('fade-in-up');
            }
        });
    }

    $(window).on('scroll', revealOnScroll);
    revealOnScroll(); // Run on load

    // ========== Active Nav Link on Scroll ==========
    $(window).on('scroll', function () {
        var scrollPos = $(this).scrollTop() + 120;
        $('section[id]').each(function () {
            var sectionTop = $(this).offset().top;
            var sectionHeight = $(this).outerHeight();
            var sectionId = $(this).attr('id');

            if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                $('.navbar-nav .nav-link').removeClass('active');
                $('.navbar-nav .nav-link[href="#' + sectionId + '"]').addClass('active');
            }
        });
    });

    // ========== Contact Form Submit (prevent default) ==========
    $('.contact-form').on('submit', function (e) {
        e.preventDefault();
        var btn = $(this).find('button[type="submit"]');
        var originalText = btn.html();

        btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Sending...');
        btn.prop('disabled', true);

        setTimeout(function () {
            btn.html('<i class="fas fa-check me-2"></i> Message Sent!');
            btn.removeClass('btn-primary-custom').addClass('btn-success');

            setTimeout(function () {
                btn.html(originalText);
                btn.removeClass('btn-success').addClass('btn-primary-custom');
                btn.prop('disabled', false);
                $('.contact-form')[0].reset();
            }, 2500);
        }, 1500);
    });
});
