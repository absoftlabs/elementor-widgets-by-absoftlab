<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class ABSL_Info_Card_Widget extends Widget_Base {
    public function get_name() { return 'absl_info_card'; }
    public function get_title() { return __('Info Card', 'absl-ew'); }
    public function get_icon() { return 'eicon-info-box'; }
    public function get_categories() { return ['absoftlab']; }

    protected function register_controls() {

        /* -----------------------
         * CONTENT
         * ---------------------*/
        $this->start_controls_section('content_section', [
            'label' => __('Content', 'absl-ew')
        ]);

        // Media Type (Icon or Image)
        $this->add_control('media_type', [
            'label'   => __('Media Type', 'absl-ew'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'icon',
            'options' => [
                'icon'  => __('Icon', 'absl-ew'),
                'image' => __('Image', 'absl-ew'),
            ],
        ]);

        // ICON (only if media_type = icon)
        $this->add_control('icon', [
            'label' => __('Icon', 'absl-ew'),
            'type'  => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-star',
                'library' => 'fa-solid',
            ],
            'condition' => ['media_type' => 'icon'],
        ]);

        // IMAGE (only if media_type = image)
        $this->add_control('image', [
            'label'   => __('Image', 'absl-ew'),
            'type'    => Controls_Manager::MEDIA,
            'default' => ['url' => \Elementor\Utils::get_placeholder_image_src() ],
            'condition' => ['media_type' => 'image'],
        ]);
        $this->add_control('image_alt', [
            'label' => __('Image Alt Text', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'placeholder' => __('Describe the image…', 'absl-ew'),
            'condition' => ['media_type' => 'image'],
        ]);

        // Media position (works for both)
        $this->add_responsive_control('icon_position', [
            'label'   => __('Media Position', 'absl-ew'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'top'   => ['title' => __('Top', 'absl-ew'),   'icon' => 'eicon-v-align-top'],
                'left'  => ['title' => __('Left', 'absl-ew'),  'icon' => 'eicon-h-align-left'],
                'right' => ['title' => __('Right', 'absl-ew'), 'icon' => 'eicon-h-align-right'],
            ],
            'default' => 'top',
            'toggle'  => true,
            'selectors_dictionary' => [
                'top'   => 'column',
                'left'  => 'row',
                'right' => 'row-reverse',
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-inner' => 'flex-direction: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('media_alignment', [
            'label' => __('Media Alignment', 'absl-ew'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => __('Start', 'absl-ew'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'absl-ew'),
                    'icon' => 'eicon-h-align-center',
                ],
                'flex-end' => [
                    'title' => __('End', 'absl-ew'),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-icon' => 'align-self: {{VALUE}};',
                '{{WRAPPER}} .absl-card .absl-media' => 'align-self: {{VALUE}};',
            ],
        ]);

        // Icon View
        $this->add_control('icon_view', [
            'label'   => __('Icon View', 'absl-ew'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => __('Default', 'absl-ew'),
                'stacked' => __('Stacked', 'absl-ew'),
                'framed'  => __('Framed', 'absl-ew'),
            ],
            'condition' => ['media_type' => 'icon'],
        ]);
        // Icon Shape
        $this->add_control('icon_shape', [
            'label'   => __('Icon Shape', 'absl-ew'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'rounded',
            'options' => [
                'square'  => __('Square', 'absl-ew'),
                'circle'  => __('Circle', 'absl-ew'),
                'rounded' => __('Rounded', 'absl-ew'),
            ],
            'condition' => [
                'media_type' => 'icon',
                'icon_view!' => 'default',
            ],
        ]);

        // IMAGE View (same feature-set as icon)
        $this->add_control('image_view', [
            'label'   => __('Image View', 'absl-ew'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => __('Default', 'absl-ew'),
                'stacked' => __('Stacked (with BG)', 'absl-ew'),
                'framed'  => __('Framed (with Border)', 'absl-ew'),
            ],
            'condition' => ['media_type' => 'image'],
        ]);
        // IMAGE Shape
        $this->add_control('image_shape', [
            'label'   => __('Image Shape', 'absl-ew'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'rounded',
            'options' => [
                'square'  => __('Square', 'absl-ew'),
                'circle'  => __('Circle', 'absl-ew'),
                'rounded' => __('Rounded', 'absl-ew'),
            ],
            'condition' => [
                'media_type' => 'image',
                'image_view!' => 'default',
            ],
        ]);

        $this->add_control('title', [
            'label' => __('Title', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'default' => __('Card Title', 'absl-ew')
        ]);

        // Subtitle
        $this->add_control('subtitle', [
            'label' => __('Subtitle', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'default' => __('Card Subtitle', 'absl-ew'),
            'placeholder' => __('Enter subtitle...', 'absl-ew'),
        ]);

        $this->add_control('description', [
            'label' => __('Description', 'absl-ew'),
            'type'  => Controls_Manager::TEXTAREA,
            'default' => __('This is a sample description text.', 'absl-ew')
        ]);

        /* ------------ CTA / BUTTON (CONTENT) ------------ */
        $this->add_control('show_button', [
            'label'        => __('Show Button (CTA)', 'absl-ew'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('Show', 'absl-ew'),
            'label_off'    => __('Hide', 'absl-ew'),
            'return_value' => 'yes',
            'default'      => 'yes',
            'separator'    => 'before',
        ]);

        $this->add_control('button_text', [
            'label'     => __('Button Label', 'absl-ew'),
            'type'      => Controls_Manager::TEXT,
            'default'   => __('Learn More', 'absl-ew'),
            'condition' => ['show_button' => 'yes'],
        ]);

        $this->add_control('button_link', [
            'label'       => __('Button Link', 'absl-ew'),
            'type'        => Controls_Manager::URL,
            'placeholder' => __('https://your-link.com', 'absl-ew'),
            'options'     => ['url', 'is_external', 'nofollow'],
            'default'     => [
                'url' => '#',
                'is_external' => false,
                'nofollow'    => false,
            ],
            'condition'   => ['show_button' => 'yes'],
        ]);

        /* -------- Card Link (NEW) -------- */
        $this->add_control('card_link_heading', [
            'type'  => Controls_Manager::HEADING,
            'label' => __('Card Link', 'absl-ew'),
            'separator' => 'before',
        ]);
        $this->add_control('card_link', [
            'label'       => __('Link (whole card)', 'absl-ew'),
            'type'        => Controls_Manager::URL,
            'placeholder' => __('https://example.com', 'absl-ew'),
            'options'     => ['url','is_external','nofollow'],
            'description' => __('If set, the whole card becomes clickable. Inner links (like the button) keep working.', 'absl-ew'),
        ]);

        $this->end_controls_section();

        /* -----------------------
         * STYLE: CARD
         * ---------------------*/
        $this->start_controls_section('card_style', [
            'label' => __('Card', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->start_controls_tabs('card_style_tabs');

        $this->start_controls_tab('card_style_tab_normal', [
            'label' => __('Normal', 'absl-ew'),
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'card_bg',
            'label'    => __('Background', 'absl-ew'),
            'selector' => '{{WRAPPER}} .absl-card',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'card_border',
            'selector' => '{{WRAPPER}} .absl-card',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_shadow',
            'selector' => '{{WRAPPER}} .absl-card',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('card_style_tab_hover', [
            'label' => __('Hover', 'absl-ew'),
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'card_hover_bg',
            'label'    => __('Background', 'absl-ew'),
            'selector' => '{{WRAPPER}} .absl-card:hover',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'card_border_hover',
            'selector' => '{{WRAPPER}} .absl-card:hover',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_shadow_hover',
            'selector' => '{{WRAPPER}} .absl-card:hover',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('card_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => ['px' => ['min'=>0, 'max'=>60], '%'=>['min'=>0, 'max'=>50]],
            'selectors' => ['{{WRAPPER}} .absl-card' => 'border-radius: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('card_padding', [
            'label' => __('Padding', 'absl-ew'),
            'type'  => Controls_Manager::DIMENSIONS,
            'size_units' => ['px','em','%'],
            'selectors' => [
                '{{WRAPPER}} .absl-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // Content Alignment
        $this->add_responsive_control('content_align', [
            'label'   => __('Content Alignment', 'absl-ew'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => ['title'=>__('Left','absl-ew'),   'icon'=>'eicon-text-align-left'],
                'center' => ['title'=>__('Center','absl-ew'), 'icon'=>'eicon-text-align-center'],
                'right'  => ['title'=>__('Right','absl-ew'),  'icon'=>'eicon-text-align-right'],
                'justify'=> ['title'=>__('Justify','absl-ew'),'icon'=>'eicon-text-align-justify'],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .absl-card' => 'text-align: {{VALUE}};',
                '{{WRAPPER}} .absl-card p' => 'text-align: {{VALUE}};',
                '{{WRAPPER}} .absl-card .absl-subtitle' => 'text-align: {{VALUE}};',
            ],
            'render_type' => 'ui',
        ]);

        /* ===== Height Controls ===== */
        $this->add_responsive_control('equal_height', [
            'label' => __('Equal Height (match row)', 'absl-ew'),
            'type'  => Controls_Manager::SWITCHER,
            'label_on'  => __('On', 'absl-ew'),
            'label_off' => __('Off', 'absl-ew'),
            'return_value' => 'yes',
            'default' => 'yes',
            'selectors' => [
                '{{WRAPPER}}' => 'height:100%;',
                '{{WRAPPER}} .elementor-widget-container' => 'height:100%; display:flex;',
                '{{WRAPPER}} .elementor-widget-container > .absl-card' => 'height:100%; flex:1 1 auto;',
            ],
        ]);

        $this->add_control('height_mode', [
            'label'   => __('Height Mode', 'absl-ew'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'auto',
            'options' => [
                'auto'  => __('Auto', 'absl-ew'),
                'min'   => __('Min Height', 'absl-ew'),
                'fixed' => __('Fixed Height', 'absl-ew'),
            ],
        ]);

        $this->add_responsive_control('card_min_height', [
            'label' => __('Min Height', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','vh'],
            'range' => [
                'px' => ['min'=>100, 'max'=>1000],
                'vh' => ['min'=>10, 'max'=>100],
            ],
            'condition' => ['height_mode' => 'min'],
            'selectors' => [
                '{{WRAPPER}} .absl-card' => 'min-height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('card_fixed_height', [
            'label' => __('Fixed Height', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','vh'],
            'range' => [
                'px' => ['min'=>120, 'max'=>1200],
                'vh' => ['min'=>10, 'max'=>100],
            ],
            'condition' => ['height_mode' => 'fixed'],
            'selectors' => [
                '{{WRAPPER}} .absl-card' => 'height: {{SIZE}}{{UNIT}}; overflow:hidden;',
            ],
        ]);

        // Vertical alignment inside card
        $this->add_responsive_control('content_vertical_align', [
            'label'   => __('Vertical Align (inside card)', 'absl-ew'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => ['title'=>__('Top','absl-ew'),    'icon'=>'eicon-v-align-top'],
                'center'     => ['title'=>__('Center','absl-ew'), 'icon'=>'eicon-v-align-middle'],
                'flex-end'   => ['title'=>__('Bottom','absl-ew'), 'icon'=>'eicon-v-align-bottom'],
            ],
            'default' => 'flex-start',
            'selectors' => [
                '{{WRAPPER}} .absl-card' => 'justify-content: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        /* -----------------------
         * STYLE: OVERLAY (NEW)
         * ---------------------*/
        $this->start_controls_section('overlay_style', [
            'label' => __('Card Overlay', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        // Normal overlay BG
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'card_overlay_bg',
            'label'    => __('Overlay (Normal)', 'absl-ew'),
            'types'    => ['classic','gradient'],
            'selector' => '{{WRAPPER}} .absl-card::before',
        ]);

        // Normal overlay opacity
        $this->add_control('card_overlay_opacity', [
            'label' => __('Overlay Opacity', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
            'default' => [ 'size' => 1 ],
            'selectors' => [
                '{{WRAPPER}} .absl-card::before' => 'opacity: {{SIZE}};',
            ],
        ]);

        // Hover overlay BG
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'card_overlay_hover_bg',
            'label'    => __('Overlay (Hover)', 'absl-ew'),
            'types'    => ['classic','gradient'],
            'selector' => '{{WRAPPER}} .absl-card:hover::before',
        ]);

        // Hover overlay opacity
        $this->add_control('card_overlay_opacity_hover', [
            'label' => __('Overlay Opacity (Hover)', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
            'default' => [ 'size' => 1 ],
            'selectors' => [
                '{{WRAPPER}} .absl-card:hover::before' => 'opacity: {{SIZE}};',
            ],
        ]);

        $this->end_controls_section();

        /* -----------------------
         * STYLE: ICON (media_type = icon)
         * ---------------------*/
        $this->start_controls_section('icon_style', [
            'label' => __('Icon', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
            'condition' => ['media_type' => 'icon'],
        ]);

        // Icon Size
        $this->add_responsive_control('icon_size', [
            'label' => __('Icon Size', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px' => ['min'=>10, 'max'=>200]],
            'default' => ['size'=>48, 'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-card .absl-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Icon Box Size (stacked/framed)
        $this->add_responsive_control('icon_box_size', [
            'label' => __('Icon Box Size', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px' => ['min'=>20, 'max'=>260]],
            'default' => ['size'=>80, 'unit'=>'px'],
            'condition' => ['icon_view!' => 'default'],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-icon.is-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Icon Colors
        $this->add_control('icon_color', [
            'label' => __('Icon Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-card .absl-icon i, {{WRAPPER}} .absl-card .absl-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};']
        ]);
        $this->add_control('icon_hover_color', [
            'label' => __('Icon Hover Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-card:hover .absl-icon i, {{WRAPPER}} .absl-card:hover .absl-icon svg' => 'color: {{VALUE}}; fill: {{VALUE}};']
        ]);
        $this->add_control('icon_hover_animation', [
            'label' => __('Icon Hover Animation', 'absl-ew'),
            'type'  => Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none' => __('None', 'absl-ew'),
                'scale(1.1)' => __('Zoom In', 'absl-ew'),
                'scale(0.9)' => __('Zoom Out', 'absl-ew'),
                'rotate(10deg)' => __('Rotate', 'absl-ew'),
                'translateY(-6px)' => __('Float Up', 'absl-ew'),
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-card:hover .absl-icon' => 'transform: {{VALUE}};',
            ],
        ]);

        // Icon Background (Stacked)
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'icon_bg',
            'label'    => __('Icon Background (Normal)', 'absl-ew'),
            'selector' => '{{WRAPPER}} .absl-card .absl-icon.is-stacked',
            'condition'=> ['icon_view' => 'stacked'],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'icon_bg_hover',
            'label'    => __('Icon Background (Hover)', 'absl-ew'),
            'selector' => '{{WRAPPER}} .absl-card:hover .absl-icon.is-stacked',
            'condition'=> ['icon_view' => 'stacked'],
        ]);

        // Framed border (Icon)
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'icon_frame_border',
            'selector' => '{{WRAPPER}} .absl-card .absl-icon.is-framed',
            'condition'=> ['icon_view' => 'framed'],
        ]);

        // Icon corner override
        $this->add_responsive_control('icon_radius_custom', [
            'label' => __('Icon Radius (override shape)', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => ['px' => ['min'=>0,'max'=>100], '%'=>['min'=>0,'max'=>50]],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-icon.is-box' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
            'description' => __('If set, this will override the shape preset.', 'absl-ew'),
            'condition'=> ['icon_view!' => 'default'],
        ]);

        // Spacing between media and text
        $this->add_responsive_control('icon_spacing', [
            'label' => __('Icon Spacing', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','em'],
            'range' => ['px'=>['min'=>0,'max'=>100],'em'=>['min'=>0,'max'=>6]],
            'default' => ['size'=>16,'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-inner' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        /* -----------------------
         * STYLE: IMAGE (media_type = image)
         * ---------------------*/
        $this->start_controls_section('image_style', [
            'label' => __('Image', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
            'condition' => ['media_type' => 'image'],
        ]);

        // Image Size (like icon_size)
        $this->add_responsive_control('image_size', [
            'label' => __('Image Size', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px'=>['min'=>20,'max'=>260]],
            'default' => ['size'=>80,'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-media img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Image Box Size (for stacked/framed wrapper, same as icon_box_size)
        $this->add_responsive_control('image_box_size', [
            'label' => __('Image Box Size', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px'=>['min'=>20,'max'=>300]],
            'default' => ['size'=>100,'unit'=>'px'],
            'condition' => ['image_view!' => 'default'],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-media.is-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Image Object Fit
        $this->add_control('image_object_fit', [
            'label' => __('Object Fit', 'absl-ew'),
            'type'  => Controls_Manager::SELECT,
            'default' => 'cover',
            'options' => [
                'cover'   => __('Cover', 'absl-ew'),
                'contain' => __('Contain', 'absl-ew'),
                'fill'    => __('Fill', 'absl-ew'),
                'none'    => __('None', 'absl-ew'),
                'scale-down' => __('Scale Down', 'absl-ew'),
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-media img' => 'object-fit: {{VALUE}};',
            ],
        ]);

        // Background (ONLY for Stacked)
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'image_bg',
            'label'    => __('Image Box Background (Normal)', 'absl-ew'),
            'selector' => '{{WRAPPER}} .absl-card .absl-media.is-stacked',
            'condition'=> ['image_view' => 'stacked'],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'image_bg_hover',
            'label'    => __('Image Box Background (Hover)', 'absl-ew'),
            'selector' => '{{WRAPPER}} .absl-card:hover .absl-media.is-stacked',
            'condition'=> ['image_view' => 'stacked'],
        ]);

        // Framed border (ONLY for Framed)
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'image_frame_border',
            'selector' => '{{WRAPPER}} .absl-card .absl-media.is-framed',
            'condition'=> ['image_view' => 'framed'],
        ]);

        // Image corner override (override shape)
        $this->add_responsive_control('image_radius_custom', [
            'label' => __('Image Radius (override shape)', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','%'],
            'range' => ['px'=>['min'=>0,'max'=>100], '%'=>['min'=>0,'max'=>50]],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-media.is-box' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
            'description' => __('If set, this will override the shape preset.', 'absl-ew'),
            'condition'=> ['image_view!' => 'default'],
        ]);

        // Spacing between media and text (image)
        $this->add_responsive_control('image_spacing', [
            'label' => __('Image Spacing', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','em'],
            'range' => ['px'=>['min'=>0,'max'=>100],'em'=>['min'=>0,'max'=>6]],
            'default' => ['size'=>16,'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-inner' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        /* -----------------------
         * STYLE: TITLE
         * ---------------------*/
        $this->start_controls_section('title_style', [
            'label' => __('Title', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('title_color', [
            'label' => __('Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-card h3' => 'color: {{VALUE}};']
        ]);
        $this->add_control('title_hover_color', [
            'label' => __('Hover Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-card:hover h3' => 'color: {{VALUE}};']
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'title_typo',
            'selector' => '{{WRAPPER}} .absl-card h3',
        ]);
        // spacing Title ↔ Description (subtitle has own margin)
        $this->add_responsive_control('content_spacing', [
            'label' => __('Content Spacing (Title ↔ Description)', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','em'],
            'range' => ['px'=>['min'=>0,'max'=>60],'em'=>['min'=>0,'max'=>6]],
            'default' => ['size'=>8,'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-card h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        /* -----------------------
         * STYLE: SUBTITLE
         * ---------------------*/
        $this->start_controls_section('subtitle_style', [
            'label' => __('Subtitle', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('subtitle_color', [
            'label' => __('Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-subtitle' => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_control('subtitle_hover_color', [
            'label' => __('Hover Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-card:hover .absl-subtitle' => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'subtitle_typo',
            'selector' => '{{WRAPPER}} .absl-card .absl-subtitle',
        ]);
        $this->add_responsive_control('subtitle_spacing_bottom', [
            'label' => __('Subtitle Bottom Spacing', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','em'],
            'range' => ['px'=>['min'=>0,'max'=>40],'em'=>['min'=>0,'max'=>4]],
            'default' => ['size'=>10,'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        /* -----------------------
         * STYLE: DESCRIPTION
         * ---------------------*/
        $this->start_controls_section('desc_style', [
            'label' => __('Description', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('desc_color', [
            'label' => __('Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-card p' => 'color: {{VALUE}};']
        ]);
        $this->add_control('desc_hover_color', [
            'label' => __('Hover Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-card:hover p' => 'color: {{VALUE}};']
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'desc_typo',
            'selector' => '{{WRAPPER}} .absl-card p',
        ]);
        $this->end_controls_section();

        /* -----------------------
         * STYLE: BUTTON (CTA)
         * ---------------------*/
        $this->start_controls_section('button_style', [
            'label' => __('Button (CTA)', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
            'condition' => ['show_button' => 'yes'],
        ]);

        // Alignment (+ Full Width option)
        $this->add_responsive_control('button_alignment', [
            'label' => __('Button Alignment', 'absl-ew'),
            'type'  => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => ['title'=>__('Left','absl-ew'),'icon'=>'eicon-h-align-left'],
                'center'     => ['title'=>__('Center','absl-ew'),'icon'=>'eicon-h-align-center'],
                'flex-end'   => ['title'=>__('Right','absl-ew'),'icon'=>'eicon-h-align-right'],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-btn-wrap' => 'justify-content: {{VALUE}};',
            ],
        ]);

        $this->add_control('button_full_width', [
            'label'        => __('Full Width', 'absl-ew'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
        ]);

        $this->add_responsive_control('button_top_spacing', [
            'label' => __('Top Spacing', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','em'],
            'range' => ['px'=>['min'=>0,'max'=>60],'em'=>['min'=>0,'max'=>6]],
            'default' => ['size'=>16,'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-btn-wrap' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Typography
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'button_typo',
            'selector' => '{{WRAPPER}} .absl-card .absl-btn',
        ]);

        // NORMAL
        $this->add_control('button_heading_normal', [
            'type' => Controls_Manager::HEADING,
            'label' => __('Normal', 'absl-ew'),
            'separator' => 'before',
        ]);
        $this->add_control('button_text_color', [
            'label' => __('Text Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-btn' => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'button_bg',
            'label'    => __('Background', 'absl-ew'),
            'selector' => '{{WRAPPER}} .absl-card .absl-btn',
        ]);
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'button_border',
            'selector' => '{{WRAPPER}} .absl-card .absl-btn',
        ]);
        $this->add_responsive_control('button_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','%'],
            'range' => ['px'=>['min'=>0,'max'=>60], '%'=>['min'=>0,'max'=>50]],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('button_padding', [
            'label' => __('Padding', 'absl-ew'),
            'type'  => Controls_Manager::DIMENSIONS,
            'size_units' => ['px','em'],
            'default' => ['top'=>12,'right'=>20,'bottom'=>12,'left'=>20,'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'button_shadow',
            'selector' => '{{WRAPPER}} .absl-card .absl-btn',
        ]);

        // HOVER
        $this->add_control('button_heading_hover', [
            'type' => Controls_Manager::HEADING,
            'label' => __('Hover', 'absl-ew'),
            'separator' => 'before',
        ]);
        $this->add_control('button_text_color_hover', [
            'label' => __('Text Color (Hover)', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-card .absl-btn:hover' => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'button_bg_hover',
            'label'    => __('Background (Hover)', 'absl-ew'),
            'selector' => '{{WRAPPER}} .absl-card .absl-btn:hover',
        ]);
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'button_border_hover',
            'selector' => '{{WRAPPER}} .absl-card .absl-btn:hover',
        ]);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'button_shadow_hover',
            'selector' => '{{WRAPPER}} .absl-card .absl-btn:hover',
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $is_icon  = isset($s['media_type']) && $s['media_type'] === 'icon';
        $is_image = isset($s['media_type']) && $s['media_type'] === 'image';

        // Shape + view classes for icon
        $icon_shape_cls  = '';
        if ( $is_icon && ($s['icon_view'] ?? 'default') !== 'default' ) {
            if ( ($s['icon_shape'] ?? 'rounded') === 'circle' )      $icon_shape_cls = 'shape-circle';
            elseif ( ($s['icon_shape'] ?? 'rounded') === 'square' )  $icon_shape_cls = 'shape-square';
            else                                                     $icon_shape_cls = 'shape-rounded';
        }
        $icon_view_cls = '';
        if ( $is_icon ) {
            if ( ($s['icon_view'] ?? 'default') === 'stacked' ) $icon_view_cls = 'is-box is-stacked';
            elseif ( ($s['icon_view'] ?? 'default') === 'framed' ) $icon_view_cls = 'is-box is-framed';
        }

        // Shape + view classes for image
        $img_shape_cls  = '';
        if ( $is_image && ($s['image_view'] ?? 'default') !== 'default' ) {
            if ( ($s['image_shape'] ?? 'rounded') === 'circle' )      $img_shape_cls = 'shape-circle';
            elseif ( ($s['image_shape'] ?? 'rounded') === 'square' )  $img_shape_cls = 'shape-square';
            else                                                      $img_shape_cls = 'shape-rounded';
        }
        $img_view_cls = '';
        if ( $is_image ) {
            if ( ($s['image_view'] ?? 'default') === 'stacked' ) $img_view_cls = 'is-box is-stacked';
            elseif ( ($s['image_view'] ?? 'default') === 'framed' ) $img_view_cls = 'is-box is-framed';
        }

        // Button link attrs
        $btn_url   = isset($s['button_link']['url']) ? esc_url($s['button_link']['url']) : '#';
        $btn_target= !empty($s['button_link']['is_external']) ? ' target="_blank"' : '';
        $btn_rel   = [];
        if (!empty($s['button_link']['nofollow'])) $btn_rel[] = 'nofollow';
        if (!empty($s['button_link']['is_external'])) $btn_rel[] = 'noopener noreferrer';
        $btn_rel_attr = $btn_rel ? ' rel="'.esc_attr(implode(' ', $btn_rel)).'"' : '';

        $full_width = (!empty($s['button_full_width']) && $s['button_full_width'] === 'yes') ? ' is-full' : '';

        // CARD LINK (new)
        $card_link = $s['card_link'] ?? [];
        $card_href = !empty($card_link['url']) ? esc_url($card_link['url']) : '';
        $card_target = !empty($card_link['is_external']) ? '_blank' : '_self';
        $card_rel = [];
        if (!empty($card_link['nofollow']))    $card_rel[] = 'nofollow';
        if (!empty($card_link['is_external'])) $card_rel[] = 'noopener noreferrer';
        $card_rel_attr = implode(' ', $card_rel);

        // Media HTML (icon or image)
        ob_start();
        if ( $is_image && !empty($s['image']['url']) ) {
            $alt = !empty($s['image_alt']) ? esc_attr($s['image_alt']) : '';
            echo '<span class="absl-media '.esc_attr($img_view_cls.' '.$img_shape_cls).'">';
            echo '<img src="'.esc_url($s['image']['url']).'" alt="'.$alt.'">';
            echo '</span>';
        } else {
            echo '<span class="absl-icon '.esc_attr($icon_view_cls.' '.$icon_shape_cls).'">';
            \Elementor\Icons_Manager::render_icon($s['icon'], ['aria-hidden' => 'true']);
            echo '</span>';
        }
        $media_html = ob_get_clean();

        // clickable class & data attributes
        $card_attrs = '';
        $card_extra_cls = '';
        if ( $card_href ) {
            $card_extra_cls = ' is-clickable';
            $card_attrs = sprintf(
                ' role="link" tabindex="0" data-absl-link="%s" data-target="%s" data-rel="%s" aria-label="%s"',
                esc_attr($card_href),
                esc_attr($card_target),
                esc_attr($card_rel_attr),
                esc_attr(strip_tags($s['title'] ?? 'Card link'))
            );
        }
        ?>
        <div class="absl-card <?php echo esc_attr($card_extra_cls); ?>"<?php echo $card_attrs; ?>>
            <div class="absl-inner">
                <?php echo $media_html; ?>

                <div class="absl-content">
                    <h3><?php echo esc_html($s['title']); ?></h3>
                    <?php if ( ! empty( $s['subtitle'] ) ) : ?>
                        <div class="absl-subtitle"><?php echo esc_html($s['subtitle']); ?></div>
                    <?php endif; ?>
                    <p><?php echo esc_html($s['description']); ?></p>

                    <?php if ( !empty($s['show_button']) && $s['show_button'] === 'yes' && !empty($s['button_text']) ) : ?>
                        <div class="absl-btn-wrap">
                            <a class="absl-btn<?php echo esc_attr($full_width); ?>" href="<?php echo $btn_url; ?>"<?php echo $btn_target . $btn_rel_attr; ?>>
                                <?php echo esc_html($s['button_text']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <style>
        /* Base card */
        .absl-card{
            transition:all .3s ease;
            padding:30px; border-radius:15px;
            text-align:center;
            display:flex; flex-direction:column;
            position:relative;
            box-sizing:border-box;
        }
        .absl-card.is-clickable{ cursor:pointer; }

        /* Overlay layer (controlled by Elementor overlay controls) */
        .absl-card::before{
            content:"";
            position:absolute;
            inset:0;
            z-index:1;
            pointer-events:none;
            border-radius:inherit;
            transition:all .35s ease;
            /* default transparent so it won't change previous look unless set */
            background: transparent;
            opacity: 1;
        }
        .absl-card > *{ position:relative; z-index:2; }

        /* Media (icon/img) wrappers */
        .absl-card .absl-icon,
        .absl-card .absl-media{
            display:inline-flex; align-items:center; justify-content:center; transition:all .3s ease;
        }
        .absl-card .absl-icon i,
        .absl-card .absl-icon svg{ transition:all .3s ease; display:inline-block; }
        .absl-card .absl-media img{ display:block; object-fit:cover; transition:all .3s ease; width:100%; height:100%; }

        .absl-card h3{ font-weight:700; margin:0 0 6px 0; transition:all .3s ease; }
        .absl-card .absl-subtitle{ margin:0 0 10px 0; opacity:.95; transition:all .3s ease; }
        .absl-card p{ margin:0; line-height:1.6; transition:all .3s ease; }

        /* Layout by position */
        .absl-card .absl-inner{ display:flex; flex-direction:column; align-items:center; gap:16px; }

        /* Let content area flex */
        .absl-card .absl-content{ flex:1 1 auto; width:100%; }

        /* Shape presets for boxed media (Stacked/Framed for BOTH icon & image) */
        .absl-card .absl-icon.is-box.shape-circle,
        .absl-card .absl-media.is-box.shape-circle{ border-radius:50%; }
        .absl-card .absl-icon.is-box.shape-rounded,
        .absl-card .absl-media.is-box.shape-rounded{ border-radius:14px; }
        .absl-card .absl-icon.is-box.shape-square,
        .absl-card .absl-media.is-box.shape-square{ border-radius:0; }

        .absl-card .absl-icon.is-box,
        .absl-card .absl-media.is-box{ overflow:hidden; }

        /* Button base */
        .absl-card .absl-btn-wrap{ display:flex; justify-content:center; position:relative; z-index:2; }
        .absl-card .absl-btn{
            display:inline-flex; align-items:center; justify-content:center;
            text-decoration:none; cursor:pointer; transition:all .25s ease;
            font-weight:600;
        }
        .absl-card .absl-btn.is-full{ width:100%; }
        </style>

        <?php if ( ! empty( $card_href ) ) : ?>
        <script>
        (function(){
            function isInsideAnchor(el){ return !!el.closest('a'); }
            document.addEventListener('click', function(e){
                var card = e.target.closest('.absl-card[data-absl-link]');
                if(!card) return;
                if(isInsideAnchor(e.target)) return;
                var url = card.getAttribute('data-absl-link');
                var target = card.getAttribute('data-target') || '_self';
                if(url){
                    if(target === '_blank'){ window.open(url, '_blank', 'noopener'); }
                    else { window.location.href = url; }
                }
            });
            document.addEventListener('keydown', function(e){
                if(e.key !== 'Enter' && e.key !== ' ') return;
                var card = document.activeElement;
                if(!card || !card.classList.contains('absl-card') || !card.hasAttribute('data-absl-link')) return;
                e.preventDefault();
                var url = card.getAttribute('data-absl-link');
                var target = card.getAttribute('data-target') || '_self';
                if(url){
                    if(target === '_blank'){ window.open(url, '_blank', 'noopener'); }
                    else { window.location.href = url; }
                }
            });
        })();
        </script>
        <?php endif; ?>
        <?php
    }
}
