$(document).ready(function () {

    // Sticky navbar shadow
    $(window).on('scroll', function () {
        var st = $(this).scrollTop();
        if (st > 50) {
            $('.main-navbar').css('box-shadow', '0 2px 12px rgba(0,0,0,0.1)');
        } else {
            $('.main-navbar').css('box-shadow', '0 1px 4px rgba(0,0,0,0.06)');
        }

        // Back to top
        if (st > 400) {
            $('#backToTop').addClass('visible');
        } else {
            $('#backToTop').removeClass('visible');
        }
    });

    // Back to top click
    $('#backToTop').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 500);
    });

    // Smooth scroll
    $('a[href^="#"]').not('[data-bs-toggle]').on('click', function (e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: target.offset().top - 75 }, 600);
            var navCollapse = $('#mainNav');
            if (navCollapse.hasClass('show')) {
                navCollapse.collapse('hide');
            }
        }
    });

    // Scroll reveal
    function revealOnScroll() {
        var wh = $(window).height();
        $('.service-card, .facility-card, .review-card, .news-card, .faq-wrapper, .about-content, .about-logo-block, .contact-form-box, .contact-map').each(function () {
            var et = $(this).offset().top;
            if (et < $(window).scrollTop() + wh - 80) {
                $(this).addClass('fade-in-up');
            }
        });
    }

    $(window).on('scroll', revealOnScroll);
    revealOnScroll();

    // Contact form
    $('.contact-form').on('submit', function (e) {
        e.preventDefault();
        var btn = $(this).find('.btn-submit');
        var orig = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Sending...').prop('disabled', true);
        setTimeout(function () {
            btn.html('<i class="fas fa-check me-2"></i>Sent!').css('background', '#28a745');
            setTimeout(function () {
                btn.html(orig).css('background', '').prop('disabled', false);
                $('.contact-form')[0].reset();
            }, 2500);
        }, 1500);
    });
});
