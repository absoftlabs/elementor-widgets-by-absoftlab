<?php
/**
 * Plugin Name: Elementor Widgets by absoftlab
 * Description: A collection of custom Elementor widgets by absoftlab — includes Info Card, Team Card, Image Overlay Card and Review Slider.
 * Plugin URI:  https://absoftlab.com/elementor-widgets-by-absoftlab
 * Author:      absoftlab
 * Author URI:  https://absoftlab.com
 * Version:     2.1.2
 * Text Domain: absl-ew
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * ✅ Check Elementor dependency
 */
function absl_ew_elementor_loaded()
{
    if (! did_action('elementor/loaded')) {
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
    function ($elements_manager) {

        // আগে থেকেই থাকলে remove করে নতুন করে add করবো
        if (method_exists($elements_manager, 'remove_category')) {
            $elements_manager->remove_category('absoftlab');
        }

        $elements_manager->add_category(
            'absoftlab',
            [
                'title' => __('absoftlab', 'absl-ew'),
                'icon'  => 'eicon-star',
            ],
            0// 🔥 priority = 0 → একদম উপরে
        );
    },
    1// 🔥 hook priority খুব early
);

/**
 * Editor-only: Subtle brand border for absoftlab widget cards
 */
add_action('elementor/editor/after_enqueue_styles', function () {

    wp_add_inline_style(
        'elementor-editor',
        '
        /* Target only absoftlab widgets inside the panel */
        .elementor-panel .elementor-element-wrapper[data-categories~="absoftlab"] {
            border: 1px solid rgba(101, 40, 247, 0.35);
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        /* Hover effect for better attention */
        .elementor-panel .elementor-element-wrapper[data-categories~="absoftlab"]:hover {
            border-color: #6528f7;
            box-shadow: 0 0 0 1px rgba(101, 40, 247, 0.35);
        }
        '
    );

});

/**
 * ✅ Register widgets
 */
function absl_ew_register_widgets($widgets_manager)
{

    // Elementor active check
    if (! absl_ew_elementor_loaded()) {
        return;
    }

    // Widget ফাইলগুলো লোড করাও
    require_once __DIR__ . '/widgets/info-card-widget.php';
    require_once __DIR__ . '/widgets/image-overlay-card-widget.php';
    require_once __DIR__ . '/widgets/team-card-widget.php';
    require_once __DIR__ . '/widgets/review-slider-widget.php';
    require_once __DIR__ . '/widgets/motion-gallery-widget.php';
    require_once __DIR__ . '/widgets/details-card-widget.php';
    require_once __DIR__ . '/widgets/course-accordion-widget.php';
    require_once __DIR__ . '/widgets/image-gallery-widget.php';
    require_once __DIR__ . '/widgets/accordion-widget.php';
    require_once __DIR__ . '/widgets/tutor-course-card-widget.php';
    require_once __DIR__ . '/widgets/advance-heading-widget.php';
    require_once __DIR__ . '/widgets/blog-tabs-widget.php';

    // রেজিস্টার করো
    $widgets_manager->register(new \ABSL_Info_Card_Widget());
    $widgets_manager->register(new \ABSL_Image_Overlay_Card_Widget());
    $widgets_manager->register(new \ABSL_Team_Card_Widget());
    $widgets_manager->register(new \ABSL_Review_Slider_Widget());
    $widgets_manager->register(new \ABSL_Motion_Gallery_Widget());
    $widgets_manager->register(new \ABSL_Details_Card_Widget());
    $widgets_manager->register(new \ABSL_Course_Accordion_Widget());
    $widgets_manager->register(new \ABSL_Image_Gallery_Widget());
    $widgets_manager->register(new \ABSL_Accordion_Widget());
    $widgets_manager->register(new \ABSL_Tutor_Course_Card_Widget());
    $widgets_manager->register(new \ABSL_Advance_Heading_Widget());
    $widgets_manager->register(new \ABSL_Blog_Tabs_Widget());
}
add_action('elementor/widgets/register', 'absl_ew_register_widgets');

/**
 * ✅ Initialize after Elementor loads
 */
function absl_ew_init()
{
    absl_ew_elementor_loaded();
}
add_action('plugins_loaded', 'absl_ew_init');
/**
 * ✅ Register frontend + editor assets (CSS + JS)
 */
function absl_ew_register_assets()
{

    if (! absl_ew_elementor_loaded()) {
        return;
    }

    // Review Slider CSS
    wp_register_style(
        'absl-review-slider',
        plugins_url('assets/css/absl-review-slider.css', __FILE__),
        [],
        '1.0.0'
    );

    // Motion Gallery CSS
    wp_register_style(
        'absl-motion-gallery',
        plugins_url('assets/css/absl-motion-gallery.css', __FILE__),
        [],
        '1.0.0'
    );

    wp_register_style(
        'absl-details-card',
        plugins_url('assets/css/absl-details-card.css', __FILE__),
        [],
        '1.0.0'
    );

    wp_register_style(
        'absl-course-accordion',
        plugins_url('assets/css/absl-course-accordion.css', __FILE__),
        [],
        '1.0.0'
    );

    wp_register_style(
        'absl-accordion',
        plugins_url('assets/css/absl-accordion.css', __FILE__),
        [],
        '1.0.0'
    );

    wp_register_style(
        'absl-tutor-course-card',
        plugins_url('assets/css/absl-tutor-course-card.css', __FILE__),
        [],
        '1.0.0'
    );

    wp_register_style(
        'absl-blog-tabs',
        plugins_url('assets/css/absl-blog-tabs.css', __FILE__),
        [],
        '1.0.0'
    );

    wp_register_script(
        'absl-motion-gallery',
        plugins_url('assets/js/absl-motion-gallery.js', __FILE__),
        [],
        '1.0.0',
        true
    );

    // Review Slider JS (init logic)
    wp_register_script(
        'absl-review-slider',
        plugins_url('assets/js/absl-review-slider.js', __FILE__),
        ['jquery', 'elementor-frontend'],
        '1.0.0',
        true
    );

    wp_register_style(
        'absl-image-gallery',
        plugins_url('assets/css/absl-image-gallery.css', __FILE__),
        [],
        '1.0.0'
    );

    wp_register_script(
        'absl-image-gallery',
        plugins_url('assets/js/absl-image-gallery.js', __FILE__),
        ['jquery'],
        '1.0.0',
        true
    );

    wp_register_script(
        'absl-course-accordion',
        plugins_url('assets/js/absl-course-accordion.js', __FILE__),
        ['jquery', 'elementor-frontend'],
        '1.0.0',
        true
    );

    wp_register_script(
        'absl-accordion',
        plugins_url('assets/js/absl-accordion.js', __FILE__),
        ['jquery', 'elementor-frontend'],
        '1.0.0',
        true
    );

    wp_register_script(
        'absl-blog-tabs',
        plugins_url('assets/js/absl-blog-tabs.js', __FILE__),
        ['jquery', 'elementor-frontend'],
        '1.0.0',
        true
    );

    wp_localize_script('absl-blog-tabs', 'abslBlogTabs', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
    ]);

}

// frontend + editor – দুই জায়গাতেই assets উপলব্ধ থাকুক
add_action('elementor/frontend/after_register_scripts', 'absl_ew_register_assets');
add_action('elementor/editor/before_enqueue_scripts', 'absl_ew_register_assets');
add_action('wp_enqueue_scripts', 'absl_ew_register_assets');
