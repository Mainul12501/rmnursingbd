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

    // Contact form validation
    function setFieldError($field, message) {
        $field.addClass('is-invalid');
        $field.siblings('.invalid-feedback').first().text(message);
    }

    function clearFieldError($field) {
        $field.removeClass('is-invalid');
        $field.siblings('.invalid-feedback').first().text('');
    }

    function validateContactField($field) {
        var name = $field.attr('name');
        var value = ($field.val() || '').trim();
        var digitsOnlyValue = value.replace(/\D/g, '');

        clearFieldError($field);

        if ($field.prop('required') && !value) {
            setFieldError($field, ($field.data('label') || 'This field') + ' is required.');
            return false;
        }

        if (name === 'name' && value && value.length < 2) {
            setFieldError($field, 'Please enter at least 2 characters for your name.');
            return false;
        }

        if (name === 'email' && value) {
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(value)) {
                setFieldError($field, 'Please enter a valid email address.');
                return false;
            }
        }

        if (name === 'mobile' && value) {
            if (digitsOnlyValue.length < 10 || digitsOnlyValue.length > 15) {
                setFieldError($field, 'Please enter a valid phone number.');
                return false;
            }
        }

        if (name === 'subject' && value && value.length < 3) {
            setFieldError($field, 'Subject must be at least 3 characters long.');
            return false;
        }

        if (name === 'message' && value && value.length < 10) {
            setFieldError($field, 'Message should be at least 10 characters long.');
            return false;
        }

        return true;
    }

    $('.contact-form').each(function () {
        var $form = $(this);

        $form.find('input, textarea, select').on('input blur', function () {
            validateContactField($(this));
        });

        $form.on('submit', function (e) {
            var isValid = true;
            var $fields = $form.find('input, textarea, select');

            $fields.each(function () {
                if (!validateContactField($(this))) {
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                var $firstInvalidField = $form.find('.is-invalid').first();
                if ($firstInvalidField.length) {
                    $firstInvalidField.trigger('focus');
                }
                return;
            }

            var $btn = $form.find('.btn-submit');
            $btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Sending...').prop('disabled', true);
        });
    });
});
