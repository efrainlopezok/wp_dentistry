;
(function ($) {

    var $html = $('html');
    var offset;

    function preventBodyScrolling() {
        if (!$html.hasClass('is-menu-open')) {
            $html.addClass('is-menu-open')
                .css('top', -offset)
                .data('scroll-offset', offset);
        } else {
            $html.removeClass('is-menu-open')
                .css('top', '');
            $(window).scrollTop($html.data('scroll-offset'));
        }
    }

    function handleFirstTab(e) {
        var key = e.key || e.keyCode;
        if (key === 'Tab' || key === '9') {
            $('body').removeClass('no-outline');

            window.removeEventListener('keydown', handleFirstTab);
            window.addEventListener('mousedown', handleMouseDownOnce);
        }
    }

    function handleMouseDownOnce() {
        $('body').addClass('no-outline');

        window.removeEventListener('mousedown', handleMouseDownOnce);
        window.addEventListener('keydown', handleFirstTab);
    }

    window.addEventListener('keydown', handleFirstTab);

    // Fit slide video background to video holder
    function resizeVideo() {
        var $holder = $('.videoHolder');
        $holder.each(function () {
            var $that = $(this);
            var ratio = $that.data('ratio') ? $that.data('ratio') : '16:9',
                width = parseFloat(ratio.split(':')[0]),
                height = parseFloat(ratio.split(':')[1]);
            $that.find('.video').each(function () {
                if ($that.width() / width > $that.height() / height) {
                    $(this).css({'width': '100%', 'height': 'auto'});
                } else {
                    $(this).css({'width': $that.height() * width / height, 'height': '100%'});
                }
            });
        });
    }

    function smooth_scroll(link, e) {
        if (link &&
            link.indexOf('#') > 0 &&
            link.split('#')[0].indexOf(location.origin + location.pathname) !== 0) {
            return false;
        }
        if (e) e.preventDefault();
        var hash = false;
        if (!link && window.location.hash) {
            hash = window.location.hash
        } else if (link && link.indexOf('#') >= 0) {
            hash = '#' + link.split('#')[1]
        } else if (
            link &&
            location.pathname.replace(/^\//, '') == link.pathname.replace(/^\//, '') &&
            location.hostname == link.hostname
        ) {
            hash = link.hash
        }

        if (hash) {
            $('html, body').animate(
                {
                    scrollTop: $(hash).offset().top - $('.header__bottom').outerHeight(),
                },
                600
            );
            history.replaceState(null, null, hash)
        }
        $(window).trigger('hashchange')
    }

    // Scripts which runs after DOM load

    $(document).on('ready', function () {

        $('a[href^="#"]:not([href="#"],[href="#0"],[href^="#fancy-"],[role="tab"],[data-vc-accordion])').on(
            'click',
            function (e) {
                smooth_scroll($(this).attr('href'), e)
            }
        );

        // Init LazyLoad
        var lazyLoadInstance = new LazyLoad({
            elements_selector: 'img[data-lazy-src],.pre-lazyload',
            data_src: "lazy-src",
            data_srcset: "lazy-srcset",
            data_sizes: "lazy-sizes",
            skip_invisible: false,
            class_loading: "lazyloading",
            class_loaded: "lazyloaded",
        });
        // Add tracking on adding any new nodes to body to update lazyload for the new images (AJAX for example)
        window.addEventListener('LazyLoad::Initialized', function (e) {
            // Get the instance and puts it in the lazyLoadInstance variable
            if (window.MutationObserver) {
                var observer = new MutationObserver(function (mutations) {
                    mutations.forEach(function (mutation) {
                        mutation.addedNodes.forEach(function (node) {
                            if (typeof node.getElementsByTagName !== 'function') {
                                return;
                            }
                            imgs = node.getElementsByTagName('img');
                            if (0 === imgs.length) {
                                return;
                            }
                            lazyLoadInstance.update();
                        });
                    });
                });
                var b = document.getElementsByTagName("body")[0];
                var config = {childList: true, subtree: true};
                observer.observe(b, config);
            }
        }, false);

        // Update LazyLoad images before Slide change
        $('.slick-slider').on('beforeChange', function () {
            lazyLoadInstance.update();
        });

        // Detect element appearance in viewport
        /*var scrollOut = ScrollOut( {
            threshold: 0.3,
            once: true,
            onShown: function( element ) {
                if ( $( element ).is( '.ease-order' ) ) {
                    $( element ).find( '.ease-order__item' ).each( function( i ) {
                        var $this = $( this );
                        $( this ).attr( 'data-scroll', '' );
                        window.setTimeout( function() {
                            $this.attr( 'data-scroll', 'in' );
                        }, 300 * i );
                    } );
                }
            }
            /!* options *!/
        } );*/


        // Init parallax
        /*$('.jarallax').jarallax({
            speed: 0.5,
            /!* options *!/
        });*/

        // IE Object-fit cover polyfill
        if ($('.of-cover').length) {
            objectFitImages('.of-cover');
        }

        //Remove placeholder on click
        $('input,textarea').each(function () {
            $(this).data('holder', $(this).attr('placeholder'));

            $(this).on('focusin', function () {
                $(this).attr('placeholder', '');
            });

            $(this).on('focusout', function () {
                $(this).attr('placeholder', $(this).data('holder'));
            });
        });

        //Make elements equal height
        $('.matchHeight').matchHeight();


        // Add fancybox to images
        $('.gallery-item').find('a[href$="jpg"], a[href$="png"], a[href$="gif"]').attr('rel', 'gallery').attr('data-fancybox', 'gallery');
        $('a[rel*="album"], .fancybox, a[href$="jpg"], a[href$="png"], a[href$="gif"]').fancybox({
            minHeight: 0,
            helpers: {
                overlay: {
                    locked: false
                }
            }
        });

        /**
         * Scroll to Gravity Form confirmation message after form submit
         */
        $(document).on('gform_confirmation_loaded', function (event, formId) {
            var $target = $('#gform_confirmation_wrapper_' + formId);
            if ($target.length) {
                $('html, body').animate({
                    scrollTop: $target.offset().top - 50,
                }, 500);
                return false;
            }
        });

        /**
         * Hide gravity forms required field message on data input
         */
        $('body').on('change keyup', '.gfield input, .gfield textarea', function () {
            var $field = $(this).closest('.gfield');
            if ($field.hasClass('gfield_error') && $(this).val().length) {
                $field.find('.validation_message').hide();
            } else if ($field.hasClass('gfield_error') && !$(this).val().length) {
                $field.find('.validation_message').show();
            }
        });

        /**
         * Add `is-active` class to menu-icon button on Responsive menu toggle
         * And remove it on breakpoint change
         */
        $(window).on('toggled.zf.responsiveToggle', function () {
            $('.menu-icon').toggleClass('is-active');
        }).on('changed.zf.mediaquery', function (e, value) {
            $('.menu-icon').removeClass('is-active');
        });

        /**
         * Close responsive menu on orientation change
         */
        $(window).on('orientationchange', function () {
            setTimeout(function () {
                if ($('.menu-icon').hasClass('is-active') && window.innerWidth < 641) {
                    $('[data-responsive-toggle="main-menu"]').foundation('toggleMenu')
                }
            }, 200);
        });

        resizeVideo();

    });


    // Scripts which runs after all elements load

    $(window).on('load', function () {

        //jQuery code goes here
        if ($('.preloader').length) {
            $('.preloader').addClass('preloader--hidden');
        }

        if (window.location.hash) {
            smooth_scroll(window.location.hash)
        }

    });

    // Scripts which runs at window resize

    $(window).on('resize', function () {

        //jQuery code goes here

        resizeVideo();

    });

    // Scripts which runs on scrolling

    $(window).on('scroll', function () {

        //jQuery code goes here

    });

    $('.dentists__slider').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false
    });

    $('.slick__testimonial').slick({
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3,
        arrows: true,
        adaptiveHeight: false,
        dots: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,

                }
            },
            {
                breakpoint: 750,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,

                }
            },
        ]
    });

    $(window).on('scroll load resize', function () {
        var $header = $('.header');
        var height = $('body').offset().top;
        var $hb = $('.header__bottom');
        var initialOffset = $hb.parent('.full').offset().top;
        var scrollOffset = initialOffset - height;

        if ($(document).scrollTop() > scrollOffset && !$header.hasClass('sticky-header white')) {
            $header.addClass('sticky-header white');
            $hb.css('top', height);
        } else if ($(document).scrollTop() <= scrollOffset && $header.hasClass('sticky-header white')) {
            if (!$('html').hasClass('is-menu-open')) {
                $header.removeClass('sticky-header white');
                $hb.css('top', 0);
            }
        }

    });

    $(document).on(' ready', function () {
        $(window).on('toggled.zf.responsiveToggle', function () {
            offset = $(window).scrollTop();
            preventBodyScrolling();
        }).on('changed.zf.mediaquery', function (e, value) {
            $html.removeClass('is-menu-open')
        });


        $('.location-link').on('click', function (e) {
            smooth_scroll($(this).attr('href'), e);
        });

        if ($(window).width() < 1024) {
            $(".team").each(function (index) {
                var $that = $(this);
                $(this).find('a').on('click', function (e) {
                    $that.siblings().find('a').data('clicks', false);
                    var clicks = $(this).data('clicks');
                    if (!clicks) {
                        e.preventDefault();
                    }
                    $(this).data("clicks", !clicks);
                });

            });
        };

        var $heightTitle = $('.default-title');
         if ($heightTitle.height() > 80) {
            $heightTitle.addClass('half');
        } else{
            $heightTitle.addClass('line');
        }


    })
}(jQuery));
