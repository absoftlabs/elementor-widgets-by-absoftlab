<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

class ABSL_Motion_Gallery_Widget extends Widget_Base {

    public function get_name() { return 'absl_motion_gallery'; }
    public function get_title() { return __( 'Motion Gallery', 'absl-ew' ); }
    public function get_icon() { return 'eicon-carousel'; }
    public function get_categories() { return [ 'absoftlab']; }

    public function get_style_depends() {
        return [ 'absl-motion-gallery' ];
    }

    public function get_script_depends() {
        return [ 'absl-motion-gallery' ];
    }

    protected function register_controls() {

        /* -------- Content -------- */
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Logos', 'absl-ew' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'logo',
            [
                'label' => __( 'Logo Image', 'absl-ew' ),
                'type'  => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'logos',
            [
                'type'   => Controls_Manager::REPEATER,
                'fields'=> $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'direction',
            [
                'label'   => __( 'Scroll Direction', 'absl-ew' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'left'  => __( 'Left', 'absl-ew' ),
                    'right' => __( 'Right', 'absl-ew' ),
                ],
                'default' => 'left',
            ]
        );

        $this->add_control(
            'speed',
            [
                'label'   => __( 'Scroll Speed', 'absl-ew' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 40,
                'min'     => 10,
                'max'     => 200,
                'description' => __( 'Higher = slower', 'absl-ew' ),
            ]
        );

        $this->end_controls_section();

        /* -------- Style -------- */
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'absl-ew' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'logo_height',
            [
                'label' => __( 'Logo Height', 'absl-ew' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 30, 'max' => 120 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .absl-logo img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'grayscale',
            [
                'label'        => __( 'Grayscale Logos', 'absl-ew' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label'        => __( 'Color on Hover', 'absl-ew' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'condition'    => [
                    'grayscale' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $s = $this->get_settings_for_display();
        if ( empty( $s['logos'] ) ) return;

        $classes = [
            'absl-motion-gallery',
            'dir-' . $s['direction'],
        ];

        if ( $s['grayscale'] === 'yes' ) {
            $classes[] = 'is-grayscale';
        }

        if ( $s['hover_color'] === 'yes' ) {
            $classes[] = 'hover-color';
        }
        ?>
        <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
             data-speed="<?php echo esc_attr( $s['speed'] ); ?>">
            <div class="absl-track">
                <?php foreach ( $s['logos'] as $item ) :
                    if ( empty( $item['logo']['url'] ) ) continue; ?>
                    <div class="absl-logo">
                        <img src="<?php echo esc_url( $item['logo']['url'] ); ?>" alt="">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
