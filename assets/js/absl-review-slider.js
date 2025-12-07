(function ($) {
    "use strict";

    function abslInitReviewSlider($scope) {

        var $wrappers = $scope.find('.absl-review-slider-wrapper');
        if (!$wrappers.length) {
            return;
        }

        var SwiperCtor =
            (typeof elementorFrontend !== 'undefined' &&
                elementorFrontend.utils &&
                elementorFrontend.utils.swiper)
                ? elementorFrontend.utils.swiper
                : window.Swiper;

        if (!SwiperCtor) {
            return;
        }

        $wrappers.each(function () {
            var $wrapper = $(this);

            var $swiperEl = $wrapper.find('.absl-review-swiper').first();
            if (!$swiperEl.length) {
                $swiperEl = $wrapper.find('.swiper').first();
            }
            if (!$swiperEl.length) {
                return;
            }

            if ($swiperEl.data('abslSwiperDone')) {
                return;
            }

            // data-attribute থেকে অপশন
            var cardsDesktop = parseInt($swiperEl.data('cards-desktop'), 10) || 3;
            var cardsTablet  = parseInt($swiperEl.data('cards-tablet'), 10) || cardsDesktop;
            var cardsMobile  = parseInt($swiperEl.data('cards-mobile'), 10) || 1;

            var loopEnabled   = String($swiperEl.data('loop')) === 'true';
            var autoplayOn    = String($swiperEl.data('autoplay')) === 'true';
            var autoplayDelay = parseInt($swiperEl.data('autoplay-delay'), 10) || 5000;

            // এই swiper-এ আসল স্লাইড সংখ্যা (ডুপ্লিকেট ছাড়া)
            var realSlidesCount = $swiperEl
                .find('.swiper-wrapper > .swiper-slide')
                .not('.swiper-slide-duplicate')
                .length || 0;

            // ১টা স্লাইড থাকলে loop করা মানে নেই
            var effectiveLoop = loopEnabled && realSlidesCount > 1;

            // Navigation elements (নতুন + পুরোনো)
            var nextBtn =
                $wrapper.find('.absl-review-swiper-button-next').first()[0] ||
                $wrapper.find('.swiper-button-next').first()[0] ||
                null;

            var prevBtn =
                $wrapper.find('.absl-review-swiper-button-prev').first()[0] ||
                $wrapper.find('.swiper-button-prev').first()[0] ||
                null;

            var pagEl =
                $wrapper.find('.absl-review-swiper-pagination').first()[0] ||
                $wrapper.find('.swiper-pagination').first()[0] ||
                null;

            var config = {
                loop: effectiveLoop,
                // 👉 মূল ফিক্স – overflow হলেও navigation/pagination lock করবে না
                watchOverflow: false,
                slidesPerView: cardsDesktop,
                spaceBetween: 24,
                speed: 500,
                grabCursor: true,
                navigation: {
                    nextEl: nextBtn,
                    prevEl: prevBtn
                },
                pagination: {
                    el: pagEl,
                    clickable: true
                },
                breakpoints: {
                    0: {
                        slidesPerView: cardsMobile
                    },
                    768: {
                        slidesPerView: cardsTablet
                    },
                    1024: {
                        slidesPerView: cardsDesktop
                    }
                }
            };

            if (autoplayOn) {
                config.autoplay = {
                    delay: autoplayDelay,
                    disableOnInteraction: false
                };
            }

            var swiper = new SwiperCtor($swiperEl[0], config);

            $swiperEl.data('abslSwiperDone', true);
            $swiperEl.data('abslSwiperInstance', swiper);
        });
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/absl_review_slider.default',
            function ($scope) {
                abslInitReviewSlider($scope);
            }
        );
    });

    $(function () {
        abslInitReviewSlider($(document));
    });

})(jQuery);
