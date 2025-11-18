(function ($) {
    'use strict';

    /**
     * একেকটা স্লাইডার wrapper ইনিশিয়ালাইজ
     */
    function initSingleSlider($wrapper) {
        if (!$wrapper.length) return;

        // একবারের বেশি ইনিশিয়ালাইজ না করার জন্য গার্ড
        if ($wrapper.data('abslReviewInit')) {
            return;
        }
        $wrapper.data('abslReviewInit', true);

        var $track = $wrapper.find('.absl-review-track');
        if (!$track.length) return;

        // স্লাইড হিসেবে প্রথমে .absl-review-slide খুঁজব, না পেলে .absl-review-card
        var $slides = $track.find('.absl-review-slide');
        if (!$slides.length) {
            $slides = $track.find('.absl-review-card');
        }
        if (!$slides.length) return;

        var total = $slides.length;

        // ট্র্যাক ও স্লাইডের width সেট করি
        $track.css({
            width: (total * 100) + '%',
            display: 'flex',
            transition: 'transform .4s ease'
        });

        var slideWidth = 100 / total;
        $slides.css({
            width: slideWidth + '%',
            flex: '0 0 ' + slideWidth + '%'
        });

        // ডট ন্যাভিগেশন বানাই
        var $dotsWrap = $wrapper.find('.absl-review-dots');
        $dotsWrap.empty();
        for (var i = 0; i < total; i++) {
            var $dot = $('<button type="button" class="absl-review-dot" aria-label="Go to slide ' + (i + 1) + '"></button>');
            if (i === 0) {
                $dot.addClass('is-active');
            }
            $dotsWrap.append($dot);
        }

        function goTo(index) {
            if (total <= 0) return;

            // ইনফিনিট লুপ
            if (index < 0) {
                index = total - 1;
            } else if (index >= total) {
                index = 0;
            }

            var offset = -(100 / total) * index;
            $track.css('transform', 'translate3d(' + offset + '%, 0, 0)');

            // ডট আপডেট
            var $dots = $wrapper.find('.absl-review-dot');
            $dots.removeClass('is-active').eq(index).addClass('is-active');

            // স্টেট আপডেট
            var state = $wrapper.data('abslReviewState') || {};
            state.current = index;
            state.total = total;
            $wrapper.data('abslReviewState', state);
        }

        // স্টেট সেভ
        $wrapper.data('abslReviewState', {
            current: 0,
            total: total,
            goTo: function (i) {
                goTo(i);
            }
        });

        // প্রথম স্লাইডে সেট
        goTo(0);
    }

    /**
     * একটা scope (Elementor widget / পুরো ডকুমেন্ট) এর ভিতরের সব স্লাইডার ইনিশিয়ালাইজ
     */
    function initScope($scope) {
        $scope.find('.absl-review-slider-wrapper').each(function () {
            initSingleSlider($(this));
        });
    }

    /**
     * Elementor পেজে ইনিশিয়ালাইজ
     */
    $(window).on('elementor/frontend/init', function () {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction(
                'frontend/element_ready/absl_review_slider.default',
                function ($scope) {
                    initScope($scope);
                }
            );
        }
    });

    /**
     * নন-Elementor / fallback – যেকোনো পেজেই DOM ready হলে
     */
    $(function () {
        initScope($(document));
    });

    /**
     * 🔁 গ্লোবাল ন্যাভিগেশন হ্যান্ডলার (prev/next/dot)
     * — সব পেজে কাজ করবে, multiple slider থাকলেও
     */

    // Arrow navigation
    $(document).on('click', '.absl-review-prev, .absl-review-next', function (e) {
        e.preventDefault();

        var $btn = $(this);
        var $wrapper = $btn.closest('.absl-review-slider-wrapper');
        if (!$wrapper.length) return;

        var state = $wrapper.data('abslReviewState');
        if (!state || typeof state.goTo !== 'function') return;

        var current = state.current || 0;
        var total = state.total || 0;
        if (total <= 0) return;

        if ($btn.hasClass('absl-review-prev')) {
            state.goTo(current - 1);
        } else {
            state.goTo(current + 1);
        }
    });

    // Dot navigation
    $(document).on('click', '.absl-review-dot', function (e) {
        e.preventDefault();

        var $dot = $(this);
        var $wrapper = $dot.closest('.absl-review-slider-wrapper');
        if (!$wrapper.length) return;

        var state = $wrapper.data('abslReviewState');
        if (!state || typeof state.goTo !== 'function') return;

        var index = $dot.index();
        state.goTo(index);
    });

})(jQuery);
