<?php
/**
 * Plugin Name: Elementor Widgets by absoftlab
 * Description: A collection of custom Elementor widgets by absoftlab — includes Info Card, Team Card, Image Overlay Card and Review Slider.
 * Plugin URI:  https://absoftlab.com/elementor-widgets-by-absoftlab
 * Author:      absoftlab
 * Author URI:  https://absoftlab.com
 * Version:     1.3.3
 * Text Domain: absl-ew
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ✅ Check Elementor dependency
 */
function absl_ew_elementor_loaded() {
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-error"><p><strong>Elementor Widgets by absoftlab</strong> requires Elementor to be active.</p></div>';
        });
        return false;
    }
    return true;
}

/**
 * ✅ Register custom category (ABSOFTLAB Widgets)
 */
add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
    $elements_manager->add_category(
        'absoftlab',
        [
            'title' => __( 'ABSOFTLAB Widgets', 'absl-ew' ),
            'icon'  => 'fa fa-plug',
        ]
    );
});

/**
 * ✅ Register widgets
 */
function absl_ew_register_widgets( $widgets_manager ) {

    // Elementor active check
    if ( ! absl_ew_elementor_loaded() ) {
        return;
    }

    // Widget ফাইলগুলো লোড করাও
    require_once __DIR__ . '/widgets/info-card-widget.php';
    require_once __DIR__ . '/widgets/image-overlay-card-widget.php';
    require_once __DIR__ . '/widgets/team-card-widget.php';
    require_once __DIR__ . '/widgets/review-slider-widget.php';

    // রেজিস্টার করো
    $widgets_manager->register( new \ABSL_Info_Card_Widget() );
    $widgets_manager->register( new \ABSL_Image_Overlay_Card_Widget() );
    $widgets_manager->register( new \ABSL_Team_Card_Widget() );
    $widgets_manager->register( new \ABSL_Review_Slider_Widget() );
}
add_action( 'elementor/widgets/register', 'absl_ew_register_widgets' );

/**
 * ✅ Initialize after Elementor loads
 */
function absl_ew_init() {
    absl_ew_elementor_loaded();
}
add_action( 'plugins_loaded', 'absl_ew_init' );

/**
 * ✅ Review Slider – JS Init (সব পেজে সঠিকভাবে কাজ করার জন্য)
 *
 * এখানে আমরা Elementor-এর নিজস্ব Swiper wrapper ব্যবহার করছি:
 * elementorFrontend.utils.swiper
 *
 * তাই আলাদা করে Swiper JS/CSS enqueue করার দরকার নেই।
 */
function absl_ew_enqueue_review_slider_script() {
    // Elementor না থাকলে কিছুই করব না
    if ( ! absl_ew_elementor_loaded() ) {
        return;
    }

    // আমাদের dummy script handle
    $handle = 'absl-ew-review-slider-init';

    // Elementor frontend script-কে dependency হিসাবে রাখলাম
    wp_register_script(
        $handle,
        '', // empty src – শুধু inline JS ব্যবহার করব
        [ 'elementor-frontend', 'jquery' ],
        '1.0.0',
        true
    );
    wp_enqueue_script( $handle );

    // Inline JS – এখানে নতুন করে পুরো init logic দিলাম
    $inline_js = <<<JS
(function($){
    "use strict";

    /**
     * Single scope ভিতরে Review Slider init করবে
     */
    function abslInitReviewSlider(\$scope){

        var \$wrappers = \$scope.find('.absl-review-slider-wrapper');
        if (!\$wrappers.length) {
            return;
        }

        \$wrappers.each(function(){
            var \$wrapper  = $(this);
            var \$swiperEl = \$wrapper.find('.absl-review-swiper').first();

            if (!\$swiperEl.length) {
                return;
            }

            // একবার init হয়ে গেলে আর রি-ইনিট করব না
            if (\$swiperEl.data('abslSwiperDone')) {
                return;
            }

            // Elementor এর Swiper helper
            var SwiperCtor = (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.swiper)
                ? elementorFrontend.utils.swiper
                : window.Swiper;

            if (!SwiperCtor) {
                return;
            }

            var nextBtn = \$wrapper.find('.absl-review-swiper-button-next')[0];
            var prevBtn = \$wrapper.find('.absl-review-swiper-button-prev')[0];
            var pagEl   = \$wrapper.find('.absl-review-swiper-pagination')[0];

            var swiper = new SwiperCtor( \$swiperEl[0], {
                loop: true,
                speed: 500,
                grabCursor: true,
                watchSlidesProgress: true,
                slidesPerView: 1,
                spaceBetween: 24,

                navigation: {
                    nextEl: nextBtn || null,
                    prevEl: prevBtn || null
                },

                pagination: {
                    el: pagEl || null,
                    clickable: true
                },

                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 16
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    1200: {
                        slidesPerView: 3,
                        spaceBetween: 24
                    }
                }
            });

            // Mark as done
            \$swiperEl.data('abslSwiperDone', true);
            \$swiperEl.data('abslSwiperInstance', swiper);
        });
    }

    // Elementor frontend ready হলে – widget scope অনুযায়ী init
    $(window).on('elementor/frontend/init', function(){

        // আমাদের উইজেটের get_name() = 'absl_review_slider'
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/absl_review_slider.default',
            function(\$scope){
                abslInitReviewSlider(\$scope);
            }
        );
    });

    // যদি Elementor ছাড়া direct কোনো পেজে render করা হয় (safe fallback)
    $(function(){
        abslInitReviewSlider($(document));
    });

})(jQuery);
JS;

    wp_add_inline_script( $handle, $inline_js );
}
add_action( 'wp_enqueue_scripts', 'absl_ew_enqueue_review_slider_script' );
