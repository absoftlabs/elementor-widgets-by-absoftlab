<?php
/**
 * Plugin Name: Elementor Widgets by absoftlab
 * Description: A collection of custom Elementor widgets by absoftlab — includes Info Card, Team Card, Image Overlay Card and Review Slider.
 * Plugin URI:  https://absoftlab.com/elementor-widgets-by-absoftlab
 * Author:      absoftlab
 * Author URI:  https://absoftlab.com
 * Version:     1.4.2
 * Text Domain: absl-ew
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ✅ Check Elementor dependency
 */
function absl_ew_elementor_loaded() {
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action(
            'admin_notices',
            function () {
                echo '<div class="notice notice-error"><p><strong>Elementor Widgets by absoftlab</strong> requires Elementor to be active.</p></div>';
            }
        );
        return false;
    }
    return true;
}

/**
 * ✅ Register custom category (ABSOFTLAB Widgets)
 */
add_action(
    'elementor/elements/categories_registered',
    function ( $elements_manager ) {
        $elements_manager->add_category(
            'absoftlab',
            array(
                'title' => __( 'ABSOFTLAB Widgets', 'absl-ew' ),
                'icon'  => 'fa fa-plug',
            )
        );
    }
);

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
 * ✅ Global assets for Review Slider
 *
 * এখানে আমরা শুধু নিজের CSS + JS register করছি।
 * Swiper আলাদা করে লোড করবো না — Elementor নিজেই Swiper লোড করবে
 * এবং আমরা elementorFrontend.utils.swiper ব্যবহার করব।
 */
function absl_ew_register_assets() {

    if ( ! absl_ew_elementor_loaded() ) {
        return;
    }

    // Review Slider CSS
    wp_register_style(
        'absl-review-slider',
        plugins_url( 'assets/css/absl-review-slider.css', __FILE__ ),
        array(),
        '1.0.0'
    );

    // Review Slider JS (init logic)
    wp_register_script(
        'absl-review-slider',
        plugins_url( 'assets/js/absl-review-slider.js', __FILE__ ),
        array( 'jquery', 'elementor-frontend' ),
        '1.0.0',
        true
    );
}

// frontend + editor – দুই জায়গাতেই assets উপলব্ধ থাকুক
add_action( 'elementor/frontend/after_register_scripts', 'absl_ew_register_assets' );
add_action( 'elementor/editor/before_enqueue_scripts', 'absl_ew_register_assets' );
