<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class ABSL_Review_Slider_Widget extends Widget_Base {

public function get_style_depends() {
    // আমাদের custom CSS
    return [ 'absl-review-slider' ];
}

public function get_script_depends() {
    // আমাদের JS (এখানেই init হবে)
    return [ 'absl-review-slider' ];
}



    public function get_name() {
        return 'absl_review_slider';
    }

    public function get_title() {
        return __( 'Review Slider', 'absl-ew' );
    }

    public function get_icon() {
        return 'eicon-testimonial-carousel';
    }

    public function get_categories() {
        return [ 'absoftlab'];
    }

    protected function register_controls() {

        /* -----------------------
         * CONTENT: REVIEWS
         * ---------------------*/
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Reviews', 'absl-ew' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'platform_label',
            [
                'label'       => __( 'Platform Label', 'absl-ew' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Google Review', 'absl-ew' ),
                'placeholder' => __( 'Google, Trustpilot, Yelp…', 'absl-ew' ),
            ]
        );

        $repeater->add_control(
            'platform_icon',
            [
                'label'       => __( 'Platform Icon', 'absl-ew' ),
                'type'        => Controls_Manager::MEDIA,
                'default'     => [
                    'url' => '',
                ],
                'description' => __( 'Upload Google / Trustpilot / Yelp logo (shown on right side).', 'absl-ew' ),
            ]
        );

        $repeater->add_control(
            'review_text',
            [
                'label'       => __( 'Review Text', 'absl-ew' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __( 'Refacing our cabinets saved us time and money, and they look brand new. The team was professional, tidy, and respectful of our home every day.', 'absl-ew' ),
                'placeholder' => __( 'Type the customer review here…', 'absl-ew' ),
                'rows'        => 4,
            ]
        );

        $repeater->add_control(
            'rating',
            [
                'label'   => __( 'Rating (Stars)', 'absl-ew' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ],
            ]
        );

        $repeater->add_control(
            'reviewer_name',
            [
                'label'   => __( 'Reviewer Name', 'absl-ew' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'M. Reynolds', 'absl-ew' ),
            ]
        );

        $repeater->add_control(
            'reviewer_location',
            [
                'label'   => __( 'Location / Role', 'absl-ew' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Novi', 'absl-ew' ),
            ]
        );

        $repeater->add_control(
            'reviewer_avatar',
            [
                'label'   => __( 'Reviewer Photo', 'absl-ew' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'slides',
            [
                'label'       => __( 'Review Items', 'absl-ew' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'platform_label'    => __( 'Google Review', 'absl-ew' ),
                        'review_text'       => __( 'Refacing our cabinets saved us time and money, and they look brand new. The team was professional, tidy, and respectful of our home every day.', 'absl-ew' ),
                        'reviewer_name'     => __( 'M. Reynolds', 'absl-ew' ),
                        'reviewer_location' => __( 'Novi', 'absl-ew' ),
                        'rating'            => '5',
                    ],
                ],
                'title_field' => '{{{ reviewer_name }}}',
            ]
        );

        $this->end_controls_section();

        /* -----------------------
         * SLIDER SETTINGS
         * ---------------------*/
        $this->start_controls_section(
            'section_slider_settings',
            [
                'label' => __( 'Slider Settings', 'absl-ew' ),
            ]
        );

        $this->add_responsive_control(
            'cards_per_view',
            [
                'label'   => __( 'Cards Per Slider (visible at once)', 'absl-ew' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                ],
                'default' => '1',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'        => __( 'Autoplay', 'absl-ew' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'absl-ew' ),
                'label_off'    => __( 'Off', 'absl-ew' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_delay',
            [
                'label'     => __( 'Autoplay Delay (ms)', 'absl-ew' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'loop',
            [
                'label'        => __( 'Loop', 'absl-ew' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'On', 'absl-ew' ),
                'label_off'    => __( 'Off', 'absl-ew' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label'        => __( 'Show Navigation Arrows', 'absl-ew' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'absl-ew' ),
                'label_off'    => __( 'Hide', 'absl-ew' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_dots',
            [
                'label'        => __( 'Show Pagination Dots', 'absl-ew' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'absl-ew' ),
                'label_off'    => __( 'Hide', 'absl-ew' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->end_controls_section();

        /* -----------------------
         * STYLE: CARD
         * ---------------------*/
        $this->start_controls_section(
            'section_style_card',
            [
                'label' => __( 'Card', 'absl-ew' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'card_bg',
                'selector' => '{{WRAPPER}} .absl-review-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border',
                'selector' => '{{WRAPPER}} .absl-review-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_shadow',
                'selector' => '{{WRAPPER}} .absl-review-card',
            ]
        );

        $this->add_responsive_control(
            'card_radius',
            [
                'label'      => __( 'Border Radius', 'absl-ew' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 60 ],
                    '%'  => [ 'min' => 0, 'max' => 50 ],
                ],
                'default'    => [
                    'size' => 16,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .absl-review-card' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label'      => __( 'Padding', 'absl-ew' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'    => 32,
                    'right'  => 40,
                    'bottom' => 32,
                    'left'   => 40,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .absl-review-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* -----------------------
         * STYLE: REVIEW TEXT
         * ---------------------*/
        $this->start_controls_section(
            'section_style_text',
            [
                'label' => __( 'Review Text', 'absl-ew' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'review_text_color',
            [
                'label'     => __( 'Color', 'absl-ew' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-review-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'review_text_typo',
                'selector' => '{{WRAPPER}} .absl-review-text',
            ]
        );

        $this->end_controls_section();

        /* -----------------------
         * STYLE: NAME & META
         * ---------------------*/
        $this->start_controls_section(
            'section_style_name',
            [
                'label' => __( 'Name & Meta', 'absl-ew' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label'     => __( 'Name Color', 'absl-ew' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-review-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typo',
                'selector' => '{{WRAPPER}} .absl-review-name',
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label'     => __( 'Location / Meta Color', 'absl-ew' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-review-meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'meta_typo',
                'selector' => '{{WRAPPER}} .absl-review-meta',
            ]
        );

        $this->end_controls_section();

        /* -----------------------
         * STYLE: ICONS
         * ---------------------*/
        $this->start_controls_section(
            'section_style_icons',
            [
                'label' => __( 'Icons', 'absl-ew' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'platform_icon_size',
            [
                'label'      => __( 'Platform Icon Size', 'absl-ew' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 16, 'max' => 80 ],
                ],
                'default'    => [
                    'size' => 32,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .absl-review-platform-icon img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'quote_icon_size',
            [
                'label'      => __( 'Quote Icon Size', 'absl-ew' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 16, 'max' => 80 ],
                ],
                'default'    => [
                    'size' => 32,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .absl-review-quote-icon img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* -----------------------
         * STYLE: RATING
         * ---------------------*/
        $this->start_controls_section(
            'section_style_rating',
            [
                'label' => __( 'Rating Stars', 'absl-ew' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'rating_color',
            [
                'label'     => __( 'Star Color', 'absl-ew' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFC107',
                'selectors' => [
                    '{{WRAPPER}} .absl-review-rating i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* -----------------------
         * STYLE: NAVIGATION
         * ---------------------*/
        $this->start_controls_section(
            'section_style_navigation',
            [
                'label' => __( 'Navigation', 'absl-ew' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'arrow_icon_style',
            [
                'label'   => __( 'Arrow Icon Style', 'absl-ew' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'chevron',
                'options' => [
                    'chevron' => __( 'Chevron', 'absl-ew' ),
                    'angle'   => __( 'Angle', 'absl-ew' ),
                    'arrow'   => __( 'Arrow', 'absl-ew' ),
                ],
            ]
        );

        $this->add_control(
            'nav_arrows_heading',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __( 'Arrows', 'absl-ew' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'arrow_size',
            [
                'label'      => __( 'Arrow Button Size', 'absl-ew' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 24, 'max' => 64 ],
                ],
                'default'    => [
                    'size' => 32,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .absl-review-swiper-button-prev, {{WRAPPER}} .absl-review-swiper-button-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrow_radius',
            [
                'label'      => __( 'Arrow Border Radius', 'absl-ew' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 32 ],
                    '%'  => [ 'min' => 0, 'max' => 50 ],
                ],
                'default'    => [
                    'size' => 999,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .absl-review-swiper-button-prev, {{WRAPPER}} .absl-review-swiper-button-next' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_bg_color',
            [
                'label'     => __( 'Arrow Background', 'absl-ew' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-review-swiper-button-prev, {{WRAPPER}} .absl-review-swiper-button-next' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_bg_color_hover',
            [
                'label'     => __( 'Arrow Background (Hover)', 'absl-ew' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-review-swiper-button-prev:hover, {{WRAPPER}} .absl-review-swiper-button-next:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'arrow_border',
                'selector' => '{{WRAPPER}} .absl-review-swiper-button-prev, {{WRAPPER}} .absl-review-swiper-button-next',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'arrow_shadow',
                'selector' => '{{WRAPPER}} .absl-review-swiper-button-prev, {{WRAPPER}} .absl-review-swiper-button-next',
            ]
        );

        $this->add_control(
            'arrow_icon_color',
            [
                'label'     => __( 'Arrow Icon Color', 'absl-ew' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-review-arrow-icon i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_icon_color_hover',
            [
                'label'     => __( 'Arrow Icon Color (Hover)', 'absl-ew' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-review-swiper-button-prev:hover .absl-review-arrow-icon i, {{WRAPPER}} .absl-review-swiper-button-next:hover .absl-review-arrow-icon i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_dots_heading',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __( 'Dots (Pagination)', 'absl-ew' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'dots_align',
            [
                'label'   => __( 'Dots Alignment', 'absl-ew' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'absl-ew' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'     => [
                        'title' => __( 'Center', 'absl-ew' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end'   => [
                        'title' => __( 'Right', 'absl-ew' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'  => 'center',
                'selectors'=> [
                    '{{WRAPPER}} .absl-review-swiper-pagination' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_size',
            [
                'label'      => __( 'Dot Size', 'absl-ew' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 4, 'max' => 16 ],
                ],
                'default'    => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .absl-review-swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_radius',
            [
                'label'      => __( 'Dot Radius', 'absl-ew' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 20 ],
                    '%'  => [ 'min' => 0, 'max' => 50 ],
                ],
                'default'    => [
                    'size' => 999,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .absl-review-swiper-pagination .swiper-pagination-bullet' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_spacing',
            [
                'label'      => __( 'Dot Spacing', 'absl-ew' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 20 ],
                ],
                'default'    => [
                    'size' => 4,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .absl-review-swiper-pagination .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label'     => __( 'Dot Color', 'absl-ew' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-review-swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dots_color_active',
            [
                'label'     => __( 'Active Dot Color', 'absl-ew' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-review-swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

        protected function render() {
        $s      = $this->get_settings_for_display();
        $slides = ! empty( $s['slides'] ) ? $s['slides'] : [];

        if ( empty( $slides ) ) {
            return;
        }

        $slider_id = 'absl-review-slider-' . $this->get_id();

        // Responsive cards per view
        $cards_desktop = ! empty( $s['cards_per_view'] ) ? intval( $s['cards_per_view'] ) : 1;
        $cards_tablet  = ! empty( $s['cards_per_view_tablet'] ) ? intval( $s['cards_per_view_tablet'] ) : $cards_desktop;
        $cards_mobile  = ! empty( $s['cards_per_view_mobile'] ) ? intval( $s['cards_per_view_mobile'] ) : 1;

        // Behaviour options
        $loop_enabled     = ! empty( $s['loop'] ) && 'yes' === $s['loop'];
        $autoplay_enabled = ! empty( $s['autoplay'] ) && 'yes' === $s['autoplay'];
        $autoplay_delay   = ! empty( $s['autoplay_delay'] ) ? intval( $s['autoplay_delay'] ) : 5000;
        $show_arrows      = ! empty( $s['show_arrows'] ) && 'yes' === $s['show_arrows'];
        $show_dots        = ! empty( $s['show_dots'] ) && 'yes' === $s['show_dots'];

        // Quote icon (fixed path)
        $quote_icon_url = plugin_dir_url( __FILE__ ) . '../assets/images/QuoteLeft.svg';

        // Arrow icon classes
        $arrow_style = $s['arrow_icon_style'] ?? 'chevron';
        switch ( $arrow_style ) {
            case 'angle':
                $left_icon_class  = 'eicon-angle-left';
                $right_icon_class = 'eicon-angle-right';
                break;
            case 'arrow':
                $left_icon_class  = 'eicon-arrow-left';
                $right_icon_class = 'eicon-arrow-right';
                break;
            case 'chevron':
            default:
                $left_icon_class  = 'eicon-chevron-left';
                $right_icon_class = 'eicon-chevron-right';
                break;
        }
        ?>
        <div class="absl-review-slider-wrapper">
            <div
                id="<?php echo esc_attr( $slider_id ); ?>"
                class="swiper absl-review-swiper"
                data-cards-desktop="<?php echo esc_attr( $cards_desktop ); ?>"
                data-cards-tablet="<?php echo esc_attr( $cards_tablet ); ?>"
                data-cards-mobile="<?php echo esc_attr( $cards_mobile ); ?>"
                data-loop="<?php echo $loop_enabled ? 'true' : 'false'; ?>"
                data-autoplay="<?php echo $autoplay_enabled ? 'true' : 'false'; ?>"
                data-autoplay-delay="<?php echo esc_attr( $autoplay_delay ); ?>"
            >
                <div class="swiper-wrapper">
                    <?php
                    foreach ( $slides as $slide ) :

                        $platform_label    = $slide['platform_label'] ?? '';
                        $platform_icon_url = ! empty( $slide['platform_icon']['url'] ) ? $slide['platform_icon']['url'] : '';
                        $review_text       = $slide['review_text'] ?? '';
                        $rating            = isset( $slide['rating'] ) ? intval( $slide['rating'] ) : 5;
                        $reviewer_name     = $slide['reviewer_name'] ?? '';
                        $reviewer_location = $slide['reviewer_location'] ?? '';
                        $avatar_url        = ! empty( $slide['reviewer_avatar']['url'] ) ? $slide['reviewer_avatar']['url'] : '';
                        ?>
                        <div class="swiper-slide">
                            <div class="absl-review-card">
                                <div class="absl-review-top-row">
                                    <!-- LEFT: Quote icon -->
                                    <div class="absl-review-quote-icon">
                                        <img src="<?php echo esc_url( $quote_icon_url ); ?>" alt="<?php esc_attr_e( 'Quote', 'absl-ew' ); ?>">
                                    </div>

                                    <!-- RIGHT: Platform icon + label -->
                                    <div class="absl-review-platform">
                                        <?php if ( $platform_icon_url ) : ?>
                                            <span class="absl-review-platform-icon">
                                                <img src="<?php echo esc_url( $platform_icon_url ); ?>" alt="<?php echo esc_attr( $platform_label ); ?>">
                                            </span>
                                        <?php endif; ?>
                                        <?php if ( $platform_label ) : ?>
                                            <span class="absl-review-platform-label"><?php echo esc_html( $platform_label ); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="absl-review-text">
                                    <?php echo esc_html( $review_text ); ?>
                                </div>

                                <div class="absl-review-bottom-row">
                                    <div class="absl-review-user">
                                        <?php if ( $avatar_url ) : ?>
                                            <span class="absl-review-avatar">
                                                <img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $reviewer_name ); ?>">
                                            </span>
                                        <?php endif; ?>
                                        <div class="absl-review-user-meta">
                                            <?php if ( $reviewer_name ) : ?>
                                                <div class="absl-review-name"><?php echo esc_html( $reviewer_name ); ?></div>
                                            <?php endif; ?>
                                            <?php if ( $reviewer_location ) : ?>
                                                <div class="absl-review-meta"><?php echo esc_html( $reviewer_location ); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="absl-review-rating">
                                        <?php
                                        for ( $i = 1; $i <= 5; $i++ ) {
                                            if ( $i <= $rating ) {
                                                echo '<i class="eicon-star"></i>';
                                            } else {
                                                echo '<i class="eicon-star-o"></i>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    endforeach;
                    ?>
                </div>

                <?php if ( $show_arrows ) : ?>
                    <div class="absl-review-swiper-button-prev">
                        <span class="absl-review-arrow-icon">
                            <i class="<?php echo esc_attr( $left_icon_class ); ?>"></i>
                        </span>
                    </div>
                    <div class="absl-review-swiper-button-next">
                        <span class="absl-review-arrow-icon">
                            <i class="<?php echo esc_attr( $right_icon_class ); ?>"></i>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if ( $show_dots ) : ?>
                    <div class="absl-review-swiper-pagination"></div>
                <?php endif; ?>
            </div>
        </div>

        <style>
            .absl-review-slider-wrapper {
                width: 100%;
            }
            .absl-review-swiper {
                overflow: hidden;
                position: relative;
            }
            .absl-review-card {
                background: #ffffff;
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
                display: flex;
                flex-direction: column;
                min-height: 220px;
            }
            .absl-review-top-row {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                margin-bottom: 16px;
                gap: 16px;
            }
            .absl-review-quote-icon img {
                display: block;
                opacity: 0.25;
            }
            .absl-review-platform {
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }
            .absl-review-platform-icon img {
                display: block;
                border-radius: 999px;
            }
            .absl-review-platform-label {
                font-size: 13px;
                font-weight: 500;
                color: #64748b;
            }
            .absl-review-text {
                font-size: 15px;
                line-height: 1.7;
                color: #111827;
                margin-bottom: 24px;
            }
            .absl-review-bottom-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
            }
            .absl-review-user {
                display: inline-flex;
                align-items: center;
                gap: 10px;
            }
            .absl-review-avatar img {
                width: 40px;
                height: 40px;
                border-radius: 999px;
                object-fit: cover;
            }
            .absl-review-name {
                font-size: 15px;
                font-weight: 600;
            }
            .absl-review-meta {
                font-size: 13px;
                color: #6b7280;
            }
            .absl-review-rating i {
                font-size: 16px;
                margin-left: 2px;
            }

            .absl-review-swiper-button-prev,
            .absl-review-swiper-button-next {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                width: 32px;
                height: 32px;
                border-radius: 999px;
                border: 1px solid #e5e7eb;
                background: #ffffff;
                box-shadow: 0 4px 10px rgba(15, 23, 42, 0.05);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 10;
            }
            .absl-review-swiper-button-prev {
                left: 12px;
            }
            .absl-review-swiper-button-next {
                right: 12px;
            }
            .absl-review-swiper-button-prev:after,
            .absl-review-swiper-button-next:after {
                display: none !important;
            }
            .absl-review-arrow-icon i {
                font-size: 16px;
                color: #111827;
            }

            .absl-review-swiper-pagination {
                margin-top: 16px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .absl-review-swiper-pagination .swiper-pagination-bullet {
                width: 8px;
                height: 8px;
                border-radius: 999px;
                background: #d1d5db;
                opacity: 1;
                margin: 0 4px;
            }
            .absl-review-swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active {
                background: #111827;
            }
        </style>
        <?php
    }


}
