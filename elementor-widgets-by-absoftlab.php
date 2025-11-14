<?php
/**
 * Plugin Name: Elementor Widgets by absoftlab
 * Description: A collection of custom Elementor widgets by absoftlab — includes Info Card, Team Card and Image Overlay Card.
 * Plugin URI:  https://absoftlab.com/elementor-widgets-by-absoftlab
 * Author:      absoftlab
 * Author URI:  https://absoftlab.com
 * Version:     1.3.0
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
    if ( ! absl_ew_elementor_loaded() ) return;

    // Widget ফাইলগুলো লোড করাও
    require_once __DIR__ . '/widgets/info-card-widget.php';
    require_once __DIR__ . '/widgets/image-overlay-card-widget.php';
    require_once __DIR__ . '/widgets/team-card-widget.php';

    // রেজিস্টার করো
    $widgets_manager->register( new \ABSL_Info_Card_Widget() );
    $widgets_manager->register( new \ABSL_Image_Overlay_Card_Widget() );
    $widgets_manager->register( new \ABSL_Team_Card_Widget() );
}
add_action( 'elementor/widgets/register', 'absl_ew_register_widgets' );

/**
 * ✅ Initialize after Elementor loads
 */
function absl_ew_init() {
    absl_ew_elementor_loaded();
}
add_action( 'plugins_loaded', 'absl_ew_init' );
