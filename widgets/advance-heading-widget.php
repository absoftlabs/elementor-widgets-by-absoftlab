<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Utils;

class ABSL_Advance_Heading_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'advance-heading-widget';
    }

    public function get_title()
    {
        return __('Advance Heading', 'absl-ew');
    }

    public function get_icon()
    {
        return 'eicon-heading';
    }

    public function get_categories()
    {
        return ['absoftlab'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('content_section', [
            'label' => __('Content', 'absl-ew'),
        ]);

        $this->add_control('first_text', [
            'label' => __('First Part', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Start', 'absl-ew'),
        ]);

        $this->add_control('middle_text', [
            'label' => __('Middle Part', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Middle', 'absl-ew'),
        ]);

        $this->add_control('last_text', [
            'label' => __('Last Part', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('End', 'absl-ew'),
        ]);

        $this->add_control('heading_tag', [
            'label' => __('HTML Tag', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'h2',
            'options' => [
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
                'div' => 'div',
                'span' => 'span',
                'p' => 'p',
            ],
        ]);

        $this->add_control('subtitle_text', [
            'label' => __('Subtitle', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Your subtitle here', 'absl-ew'),
            'separator' => 'before',
        ]);

        $this->add_control('subtitle_tag', [
            'label' => __('Subtitle Tag', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'p',
            'options' => [
                'div' => 'div',
                'span' => 'span',
                'p' => 'p',
                'small' => 'small',
            ],
        ]);

        $this->add_control('subtitle_position', [
            'label' => __('Subtitle Position', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'below',
            'options' => [
                'above' => __('Above Heading', 'absl-ew'),
                'below' => __('Below Heading', 'absl-ew'),
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('heading_style', [
            'label' => __('Heading', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('heading_align', [
            'label' => __('Alignment', 'absl-ew'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => __('Left', 'absl-ew'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'absl-ew'),
                    'icon' => 'eicon-text-align-center',
                ],
                'right' => [
                    'title' => __('Right', 'absl-ew'),
                    'icon' => 'eicon-text-align-right',
                ],
                'justify' => [
                    'title' => __('Justify', 'absl-ew'),
                    'icon' => 'eicon-text-align-justify',
                ],
            ],
            'default' => 'left',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'heading_global_typo',
            'selector' => '{{WRAPPER}} .absl-adv-heading__text',
        ]);

        $this->add_responsive_control('heading_gap', [
            'label' => __('Part Gap', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => ['min' => 0, 'max' => 80],
                'em' => ['min' => 0, 'max' => 6],
            ],
            'default' => ['size' => 8, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-adv-heading' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('heading_wrap', [
            'label' => __('Wrap', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'wrap',
            'options' => [
                'wrap' => __('Wrap', 'absl-ew'),
                'nowrap' => __('No Wrap', 'absl-ew'),
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-adv-heading' => 'flex-wrap: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('subtitle_style', [
            'label' => __('Subtitle', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'subtitle_typo',
            'selector' => '{{WRAPPER}} .absl-adv-subtitle',
        ]);

        $this->start_controls_tabs('subtitle_style_tabs');

        $this->start_controls_tab('subtitle_tab_normal', [
            'label' => __('Normal', 'absl-ew'),
        ]);

        $this->add_control('subtitle_color', [
            'label' => __('Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-adv-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('subtitle_tab_hover', [
            'label' => __('Hover', 'absl-ew'),
        ]);

        $this->add_control('subtitle_hover_color', [
            'label' => __('Hover Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-adv-heading-wrap:hover .absl-adv-subtitle' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control('subtitle_spacing', [
            'label' => __('Subtitle Spacing', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => ['min' => 0, 'max' => 60],
                'em' => ['min' => 0, 'max' => 4],
            ],
            'default' => ['size' => 8, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-adv-heading-wrap' => '--absl-subtitle-spacing: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->add_part_style_controls(
            'first',
            __('First Part', 'absl-ew'),
            '.absl-adv-heading__part--first',
            '.absl-adv-heading__part--first .absl-adv-heading__text'
        );
        $this->add_part_style_controls(
            'middle',
            __('Middle Part', 'absl-ew'),
            '.absl-adv-heading__part--middle',
            '.absl-adv-heading__part--middle .absl-adv-heading__text'
        );
        $this->add_part_style_controls(
            'last',
            __('Last Part', 'absl-ew'),
            '.absl-adv-heading__part--last',
            '.absl-adv-heading__part--last .absl-adv-heading__text'
        );
    }

    private function add_part_style_controls($key, $label, $part_selector, $text_selector)
    {
        $section_id = $key . '_style';
        $this->start_controls_section($section_id, [
            'label' => $label,
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => $key . '_typo',
            'selector' => '{{WRAPPER}} ' . $text_selector,
        ]);

        $this->start_controls_tabs($key . '_style_tabs');

        $this->start_controls_tab($key . '_tab_normal', [
            'label' => __('Normal', 'absl-ew'),
        ]);

        $this->add_control($key . '_color', [
            'label' => __('Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ' . $text_selector => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control($key . '_use_gradient', [
            'label' => __('Use Gradient', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'absl-ew'),
            'label_off' => __('No', 'absl-ew'),
            'return_value' => 'yes',
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => $key . '_gradient',
            'label' => __('Gradient', 'absl-ew'),
            'types' => ['gradient'],
            'selector' => '{{WRAPPER}} ' . $text_selector,
            'condition' => [$key . '_use_gradient' => 'yes'],
        ]);

        $this->add_control($key . '_gradient_clip', [
            'type' => Controls_Manager::HIDDEN,
            'default' => 'yes',
            'selectors' => [
                '{{WRAPPER}} ' . $text_selector => '-webkit-background-clip:text; background-clip:text; color: transparent; -webkit-text-fill-color: transparent;',
            ],
            'condition' => [$key . '_use_gradient' => 'yes'],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab($key . '_tab_hover', [
            'label' => __('Hover', 'absl-ew'),
        ]);

        $this->add_control($key . '_color_hover', [
            'label' => __('Hover Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-adv-heading-wrap:hover ' . $text_selector => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control($key . '_use_gradient_hover', [
            'label' => __('Use Gradient (Hover)', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'absl-ew'),
            'label_off' => __('No', 'absl-ew'),
            'return_value' => 'yes',
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => $key . '_gradient_hover',
            'label' => __('Gradient (Hover)', 'absl-ew'),
            'types' => ['gradient'],
            'selector' => '{{WRAPPER}} .absl-adv-heading-wrap:hover ' . $text_selector,
            'condition' => [$key . '_use_gradient_hover' => 'yes'],
        ]);

        $this->add_control($key . '_gradient_clip_hover', [
            'type' => Controls_Manager::HIDDEN,
            'default' => 'yes',
            'selectors' => [
                '{{WRAPPER}} .absl-adv-heading-wrap:hover ' . $text_selector => '-webkit-background-clip:text; background-clip:text; color: transparent; -webkit-text-fill-color: transparent;',
            ],
            'condition' => [$key . '_use_gradient_hover' => 'yes'],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control($key . '_animation_heading', [
            'type' => Controls_Manager::HEADING,
            'label' => __('Animation', 'absl-ew'),
            'separator' => 'before',
        ]);

        $this->add_control($key . '_entry_animation', [
            'label' => __('Entry Animation', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none' => __('None', 'absl-ew'),
                'fade-up' => __('Fade Up', 'absl-ew'),
                'fade-down' => __('Fade Down', 'absl-ew'),
                'slide-left' => __('Slide Left', 'absl-ew'),
                'slide-right' => __('Slide Right', 'absl-ew'),
                'zoom-in' => __('Zoom In', 'absl-ew'),
            ],
        ]);

        $this->add_control($key . '_entry_duration', [
            'label' => __('Duration (ms)', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 150, 'max' => 2000],
            ],
            'default' => ['size' => 600],
            'selectors' => [
                '{{WRAPPER}} ' . $text_selector => '--absl-entry-duration: {{SIZE}}ms;',
            ],
        ]);

        $this->add_control($key . '_entry_delay', [
            'label' => __('Delay (ms)', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 0, 'max' => 2000],
            ],
            'default' => ['size' => 0],
            'selectors' => [
                '{{WRAPPER}} ' . $text_selector => '--absl-entry-delay: {{SIZE}}ms;',
            ],
        ]);

        $this->add_control($key . '_entry_easing', [
            'label' => __('Easing', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'cubic-bezier(0.22, 1, 0.36, 1)',
            'options' => [
                'ease' => __('Ease', 'absl-ew'),
                'ease-in' => __('Ease In', 'absl-ew'),
                'ease-out' => __('Ease Out', 'absl-ew'),
                'ease-in-out' => __('Ease In Out', 'absl-ew'),
                'cubic-bezier(0.22, 1, 0.36, 1)' => __('Smooth', 'absl-ew'),
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $text_selector => '--absl-entry-easing: {{VALUE}};',
            ],
        ]);

        $this->add_control($key . '_exit_animation_heading', [
            'type' => Controls_Manager::HEADING,
            'label' => __('Exit Animation', 'absl-ew'),
            'separator' => 'before',
        ]);

        $this->add_control($key . '_exit_animation', [
            'label' => __('Exit Animation', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none' => __('None', 'absl-ew'),
                'fade-out' => __('Fade Out', 'absl-ew'),
                'fade-up-out' => __('Fade Up Out', 'absl-ew'),
                'fade-down-out' => __('Fade Down Out', 'absl-ew'),
                'slide-left-out' => __('Slide Left Out', 'absl-ew'),
                'slide-right-out' => __('Slide Right Out', 'absl-ew'),
                'zoom-out' => __('Zoom Out', 'absl-ew'),
                'rotate-out' => __('Rotate Out', 'absl-ew'),
            ],
        ]);

        $this->add_control($key . '_exit_duration', [
            'label' => __('Exit Duration (ms)', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 150, 'max' => 2000],
            ],
            'default' => ['size' => 500],
            'selectors' => [
                '{{WRAPPER}} ' . $text_selector => '--absl-exit-duration: {{SIZE}}ms;',
            ],
        ]);

        $this->add_control($key . '_exit_delay', [
            'label' => __('Exit Delay (ms)', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 0, 'max' => 2000],
            ],
            'default' => ['size' => 0],
            'selectors' => [
                '{{WRAPPER}} ' . $text_selector => '--absl-exit-delay: {{SIZE}}ms;',
            ],
        ]);

        $this->add_control($key . '_exit_easing', [
            'label' => __('Exit Easing', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'cubic-bezier(0.22, 1, 0.36, 1)',
            'options' => [
                'ease' => __('Ease', 'absl-ew'),
                'ease-in' => __('Ease In', 'absl-ew'),
                'ease-out' => __('Ease Out', 'absl-ew'),
                'ease-in-out' => __('Ease In Out', 'absl-ew'),
                'cubic-bezier(0.22, 1, 0.36, 1)' => __('Smooth', 'absl-ew'),
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $text_selector => '--absl-exit-easing: {{VALUE}};',
            ],
        ]);

        $this->add_control($key . '_motion_animation_heading', [
            'type' => Controls_Manager::HEADING,
            'label' => __('Motion / Infinity', 'absl-ew'),
            'separator' => 'before',
        ]);

        $this->add_control($key . '_motion_animation', [
            'label' => __('Motion Animation', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none' => __('None', 'absl-ew'),
                'float' => __('Float', 'absl-ew'),
                'pulse' => __('Pulse', 'absl-ew'),
                'swing' => __('Swing', 'absl-ew'),
                'glow' => __('Glow', 'absl-ew'),
            ],
        ]);

        $this->add_control($key . '_motion_duration', [
            'label' => __('Motion Duration (ms)', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 800, 'max' => 6000],
            ],
            'default' => ['size' => 2400],
            'selectors' => [
                '{{WRAPPER}} ' . $part_selector => '--absl-motion-duration: {{SIZE}}ms;',
            ],
        ]);

        $this->add_control($key . '_motion_easing', [
            'label' => __('Motion Easing', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'ease-in-out',
            'options' => [
                'linear' => __('Linear', 'absl-ew'),
                'ease' => __('Ease', 'absl-ew'),
                'ease-in' => __('Ease In', 'absl-ew'),
                'ease-out' => __('Ease Out', 'absl-ew'),
                'ease-in-out' => __('Ease In Out', 'absl-ew'),
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $part_selector => '--absl-motion-easing: {{VALUE}};',
            ],
        ]);

        $this->add_control($key . '_hover_animation_heading', [
            'type' => Controls_Manager::HEADING,
            'label' => __('Hover Animation', 'absl-ew'),
            'separator' => 'before',
        ]);

        $this->add_control($key . '_hover_animation', [
            'label' => __('Hover Effect', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none' => __('None', 'absl-ew'),
                'translateY(-6px)' => __('Float Up', 'absl-ew'),
                'translateY(6px)' => __('Float Down', 'absl-ew'),
                'scale(1.06)' => __('Zoom In', 'absl-ew'),
                'scale(0.96)' => __('Zoom Out', 'absl-ew'),
                'rotate(3deg)' => __('Rotate', 'absl-ew'),
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-adv-heading-wrap:hover ' . $part_selector . ' .absl-adv-heading__text' => 'transform: {{VALUE}};',
            ],
        ]);

        $this->add_control($key . '_transition_duration', [
            'label' => __('Hover Transition (ms)', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 150, 'max' => 1200],
            ],
            'default' => ['size' => 350],
            'selectors' => [
                '{{WRAPPER}} ' . $text_selector => 'transition-duration: {{SIZE}}ms;',
            ],
        ]);

        $this->end_controls_section();
    }

    private function map_align_to_justify($align)
    {
        switch ($align) {
            case 'center':
                return 'center';
            case 'right':
                return 'flex-end';
            case 'justify':
                return 'space-between';
            case 'left':
            default:
                return 'flex-start';
        }
    }

    private function get_breakpoint_max($key, $fallback)
    {
        if (class_exists('\Elementor\Plugin')) {
            $breakpoint = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints($key);
            if ($breakpoint && method_exists($breakpoint, 'get_value')) {
                $value = (int) $breakpoint->get_value();
                if ($value > 0) {
                    return $value;
                }
            }
        }

        return $fallback;
    }

    private function get_typo_size_value($value)
    {
        if (!is_array($value) || !array_key_exists('size', $value)) {
            return '';
        }

        $size = $value['size'];
        if ($size === '' || $size === null) {
            return '';
        }

        $unit = !empty($value['unit']) ? $value['unit'] : 'px';
        return $size . $unit;
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();
        $tag = !empty($s['heading_tag']) ? Utils::validate_html_tag($s['heading_tag']) : 'h2';
        $subtitle_tag = !empty($s['subtitle_tag']) ? Utils::validate_html_tag($s['subtitle_tag']) : 'p';
        $align = !empty($s['heading_align']) ? $s['heading_align'] : 'left';
        $align_tablet = !empty($s['heading_align_tablet']) ? $s['heading_align_tablet'] : '';
        $align_mobile = !empty($s['heading_align_mobile']) ? $s['heading_align_mobile'] : '';
        $unique_class = 'absl-adv-heading-wrap--' . $this->get_id();
        $tablet_breakpoint = $this->get_breakpoint_max('tablet', 1024);
        $mobile_breakpoint = $this->get_breakpoint_max('mobile', 767);
        $subtitle_font_size = $this->get_typo_size_value($s['subtitle_typo_font_size'] ?? null);
        $subtitle_font_size_tablet = $this->get_typo_size_value($s['subtitle_typo_font_size_tablet'] ?? null);
        $subtitle_font_size_mobile = $this->get_typo_size_value($s['subtitle_typo_font_size_mobile'] ?? null);
        $align_class = ' absl-adv-heading--align-' . esc_attr($align);
        $subtitle_pos = !empty($s['subtitle_position']) ? $s['subtitle_position'] : 'below';
        $subtitle_pos_class = $subtitle_pos === 'above' ? ' is-subtitle-above' : ' is-subtitle-below';

        $first_entry = !empty($s['first_entry_animation']) ? $s['first_entry_animation'] : 'none';
        $middle_entry = !empty($s['middle_entry_animation']) ? $s['middle_entry_animation'] : 'none';
        $last_entry = !empty($s['last_entry_animation']) ? $s['last_entry_animation'] : 'none';
        $first_exit = !empty($s['first_exit_animation']) ? $s['first_exit_animation'] : 'none';
        $middle_exit = !empty($s['middle_exit_animation']) ? $s['middle_exit_animation'] : 'none';
        $last_exit = !empty($s['last_exit_animation']) ? $s['last_exit_animation'] : 'none';
        $first_motion = !empty($s['first_motion_animation']) ? $s['first_motion_animation'] : 'none';
        $middle_motion = !empty($s['middle_motion_animation']) ? $s['middle_motion_animation'] : 'none';
        $last_motion = !empty($s['last_motion_animation']) ? $s['last_motion_animation'] : 'none';

        $first_entry_class = $first_entry !== 'none' ? ' absl-entry--' . esc_attr($first_entry) : '';
        $middle_entry_class = $middle_entry !== 'none' ? ' absl-entry--' . esc_attr($middle_entry) : '';
        $last_entry_class = $last_entry !== 'none' ? ' absl-entry--' . esc_attr($last_entry) : '';
        $first_exit_class = $first_exit !== 'none' ? ' absl-exit--' . esc_attr($first_exit) : '';
        $middle_exit_class = $middle_exit !== 'none' ? ' absl-exit--' . esc_attr($middle_exit) : '';
        $last_exit_class = $last_exit !== 'none' ? ' absl-exit--' . esc_attr($last_exit) : '';
        $first_motion_class = $first_motion !== 'none' ? ' absl-motion--' . esc_attr($first_motion) : '';
        $middle_motion_class = $middle_motion !== 'none' ? ' absl-motion--' . esc_attr($middle_motion) : '';
        $last_motion_class = $last_motion !== 'none' ? ' absl-motion--' . esc_attr($last_motion) : '';

        $first_text = isset($s['first_text']) ? trim($s['first_text']) : '';
        $middle_text = isset($s['middle_text']) ? trim($s['middle_text']) : '';
        $last_text = isset($s['last_text']) ? trim($s['last_text']) : '';
        $subtitle_text = isset($s['subtitle_text']) ? trim($s['subtitle_text']) : '';

        if ($first_text === '' && $middle_text === '' && $last_text === '' && $subtitle_text === '') {
            return;
        }
        ?>
        <div class="absl-adv-heading-wrap<?php echo $align_class . $subtitle_pos_class . ' ' . esc_attr($unique_class); ?>">
            <?php if ($subtitle_text !== '' && $subtitle_pos === 'above') : ?>
                <<?php echo $subtitle_tag; ?> class="absl-adv-subtitle">
                    <?php echo esc_html($subtitle_text); ?>
                </<?php echo $subtitle_tag; ?>>
            <?php endif; ?>

            <?php if ($first_text !== '' || $middle_text !== '' || $last_text !== '') : ?>
                <<?php echo $tag; ?> class="absl-adv-heading">
                    <?php if ($first_text !== '') : ?>
                        <span class="absl-adv-heading__part absl-adv-heading__part--first<?php echo $first_motion_class; ?>">
                            <span class="absl-adv-heading__text<?php echo $first_entry_class . $first_exit_class; ?>">
                                <?php echo esc_html($first_text); ?>
                            </span>
                        </span>
                    <?php endif; ?>
                    <?php if ($middle_text !== '') : ?>
                        <span class="absl-adv-heading__part absl-adv-heading__part--middle<?php echo $middle_motion_class; ?>">
                            <span class="absl-adv-heading__text<?php echo $middle_entry_class . $middle_exit_class; ?>">
                                <?php echo esc_html($middle_text); ?>
                            </span>
                        </span>
                    <?php endif; ?>
                    <?php if ($last_text !== '') : ?>
                        <span class="absl-adv-heading__part absl-adv-heading__part--last<?php echo $last_motion_class; ?>">
                            <span class="absl-adv-heading__text<?php echo $last_entry_class . $last_exit_class; ?>">
                                <?php echo esc_html($last_text); ?>
                            </span>
                        </span>
                    <?php endif; ?>
                </<?php echo $tag; ?>>
            <?php endif; ?>

            <?php if ($subtitle_text !== '' && $subtitle_pos === 'below') : ?>
                <<?php echo $subtitle_tag; ?> class="absl-adv-subtitle">
                    <?php echo esc_html($subtitle_text); ?>
                </<?php echo $subtitle_tag; ?>>
            <?php endif; ?>
        </div>

        <style>
        .absl-adv-heading-wrap{
            --absl-subtitle-spacing: 8px;
        }
        .absl-adv-heading{
            display:flex;
            align-items:baseline;
            flex-wrap:wrap;
            gap:8px;
            margin:0;
        }
        .absl-adv-heading-wrap.absl-adv-heading--align-left{
            text-align:left;
        }
        .absl-adv-heading-wrap.absl-adv-heading--align-left .absl-adv-heading{
            justify-content:flex-start;
        }
        .absl-adv-heading-wrap.absl-adv-heading--align-center{
            text-align:center;
        }
        .absl-adv-heading-wrap.absl-adv-heading--align-center .absl-adv-heading{
            justify-content:center;
        }
        .absl-adv-heading-wrap.absl-adv-heading--align-right{
            text-align:right;
        }
        .absl-adv-heading-wrap.absl-adv-heading--align-right .absl-adv-heading{
            justify-content:flex-end;
        }
        .absl-adv-heading-wrap.absl-adv-heading--align-justify{
            text-align:justify;
        }
        .absl-adv-heading-wrap.absl-adv-heading--align-justify .absl-adv-heading{
            justify-content:space-between;
        }
        .absl-adv-heading-wrap.<?php echo esc_attr($unique_class); ?>{
            text-align: <?php echo esc_attr($align); ?>;
        }
        .absl-adv-heading-wrap.<?php echo esc_attr($unique_class); ?> .absl-adv-heading{
            justify-content: <?php echo esc_attr($this->map_align_to_justify($align)); ?>;
        }
        <?php if (!empty($align_tablet)) : ?>
        @media (max-width: <?php echo (int) $tablet_breakpoint; ?>px){
            .absl-adv-heading-wrap.<?php echo esc_attr($unique_class); ?>{
                text-align: <?php echo esc_attr($align_tablet); ?> !important;
            }
            .absl-adv-heading-wrap.<?php echo esc_attr($unique_class); ?> .absl-adv-heading{
                justify-content: <?php echo esc_attr($this->map_align_to_justify($align_tablet)); ?> !important;
            }
        }
        <?php endif; ?>
        <?php if (!empty($align_mobile)) : ?>
        @media (max-width: <?php echo (int) $mobile_breakpoint; ?>px){
            .absl-adv-heading-wrap.<?php echo esc_attr($unique_class); ?>{
                text-align: <?php echo esc_attr($align_mobile); ?> !important;
            }
            .absl-adv-heading-wrap.<?php echo esc_attr($unique_class); ?> .absl-adv-heading{
                justify-content: <?php echo esc_attr($this->map_align_to_justify($align_mobile)); ?> !important;
            }
        }
        <?php endif; ?>
        <?php if ($subtitle_font_size !== '') : ?>
        .absl-adv-heading-wrap.<?php echo esc_attr($unique_class); ?> .absl-adv-subtitle{
            font-size: <?php echo esc_attr($subtitle_font_size); ?> !important;
        }
        <?php endif; ?>
        <?php if ($subtitle_font_size_tablet !== '') : ?>
        @media (max-width: <?php echo (int) $tablet_breakpoint; ?>px){
            .absl-adv-heading-wrap.<?php echo esc_attr($unique_class); ?> .absl-adv-subtitle{
                font-size: <?php echo esc_attr($subtitle_font_size_tablet); ?> !important;
            }
        }
        <?php endif; ?>
        <?php if ($subtitle_font_size_mobile !== '') : ?>
        @media (max-width: <?php echo (int) $mobile_breakpoint; ?>px){
            .absl-adv-heading-wrap.<?php echo esc_attr($unique_class); ?> .absl-adv-subtitle{
                font-size: <?php echo esc_attr($subtitle_font_size_mobile); ?> !important;
            }
        }
        <?php endif; ?>
        .absl-adv-heading__part{
            display:inline-block;
            animation-duration: var(--absl-motion-duration, 2400ms);
            animation-timing-function: var(--absl-motion-easing, ease-in-out);
            animation-iteration-count: infinite;
            animation-direction: alternate;
        }
        .absl-adv-heading__text{
            display:inline-block;
            transition-property: color, transform, opacity, text-shadow;
            transition-duration: 350ms;
            transition-timing-function: cubic-bezier(0.22, 1, 0.36, 1);
            will-change: transform;
        }
        .absl-adv-heading__text.absl-entry--fade-up{
            animation-name: absl-entry-fade-up;
            animation-fill-mode: both;
            animation-duration: var(--absl-entry-duration, 600ms);
            animation-delay: var(--absl-entry-delay, 0ms);
            animation-timing-function: var(--absl-entry-easing, cubic-bezier(0.22, 1, 0.36, 1));
        }
        .absl-adv-heading__text.absl-entry--fade-down{
            animation-name: absl-entry-fade-down;
            animation-fill-mode: both;
            animation-duration: var(--absl-entry-duration, 600ms);
            animation-delay: var(--absl-entry-delay, 0ms);
            animation-timing-function: var(--absl-entry-easing, cubic-bezier(0.22, 1, 0.36, 1));
        }
        .absl-adv-heading__text.absl-entry--slide-left{
            animation-name: absl-entry-slide-left;
            animation-fill-mode: both;
            animation-duration: var(--absl-entry-duration, 600ms);
            animation-delay: var(--absl-entry-delay, 0ms);
            animation-timing-function: var(--absl-entry-easing, cubic-bezier(0.22, 1, 0.36, 1));
        }
        .absl-adv-heading__text.absl-entry--slide-right{
            animation-name: absl-entry-slide-right;
            animation-fill-mode: both;
            animation-duration: var(--absl-entry-duration, 600ms);
            animation-delay: var(--absl-entry-delay, 0ms);
            animation-timing-function: var(--absl-entry-easing, cubic-bezier(0.22, 1, 0.36, 1));
        }
        .absl-adv-heading__text.absl-entry--zoom-in{
            animation-name: absl-entry-zoom-in;
            animation-fill-mode: both;
            animation-duration: var(--absl-entry-duration, 600ms);
            animation-delay: var(--absl-entry-delay, 0ms);
            animation-timing-function: var(--absl-entry-easing, cubic-bezier(0.22, 1, 0.36, 1));
        }
        .absl-adv-heading-wrap:hover .absl-adv-heading__text.absl-exit--fade-out{
            animation-name: absl-exit-fade-out;
            animation-fill-mode: both;
            animation-duration: var(--absl-exit-duration, 500ms);
            animation-delay: var(--absl-exit-delay, 0ms);
            animation-timing-function: var(--absl-exit-easing, cubic-bezier(0.22, 1, 0.36, 1));
        }
        .absl-adv-heading-wrap:hover .absl-adv-heading__text.absl-exit--fade-up-out{
            animation-name: absl-exit-fade-up-out;
            animation-fill-mode: both;
            animation-duration: var(--absl-exit-duration, 500ms);
            animation-delay: var(--absl-exit-delay, 0ms);
            animation-timing-function: var(--absl-exit-easing, cubic-bezier(0.22, 1, 0.36, 1));
        }
        .absl-adv-heading-wrap:hover .absl-adv-heading__text.absl-exit--fade-down-out{
            animation-name: absl-exit-fade-down-out;
            animation-fill-mode: both;
            animation-duration: var(--absl-exit-duration, 500ms);
            animation-delay: var(--absl-exit-delay, 0ms);
            animation-timing-function: var(--absl-exit-easing, cubic-bezier(0.22, 1, 0.36, 1));
        }
        .absl-adv-heading-wrap:hover .absl-adv-heading__text.absl-exit--slide-left-out{
            animation-name: absl-exit-slide-left-out;
            animation-fill-mode: both;
            animation-duration: var(--absl-exit-duration, 500ms);
            animation-delay: var(--absl-exit-delay, 0ms);
            animation-timing-function: var(--absl-exit-easing, cubic-bezier(0.22, 1, 0.36, 1));
        }
        .absl-adv-heading-wrap:hover .absl-adv-heading__text.absl-exit--slide-right-out{
            animation-name: absl-exit-slide-right-out;
            animation-fill-mode: both;
            animation-duration: var(--absl-exit-duration, 500ms);
            animation-delay: var(--absl-exit-delay, 0ms);
            animation-timing-function: var(--absl-exit-easing, cubic-bezier(0.22, 1, 0.36, 1));
        }
        .absl-adv-heading-wrap:hover .absl-adv-heading__text.absl-exit--zoom-out{
            animation-name: absl-exit-zoom-out;
            animation-fill-mode: both;
            animation-duration: var(--absl-exit-duration, 500ms);
            animation-delay: var(--absl-exit-delay, 0ms);
            animation-timing-function: var(--absl-exit-easing, cubic-bezier(0.22, 1, 0.36, 1));
        }
        .absl-adv-heading-wrap:hover .absl-adv-heading__text.absl-exit--rotate-out{
            animation-name: absl-exit-rotate-out;
            animation-fill-mode: both;
            animation-duration: var(--absl-exit-duration, 500ms);
            animation-delay: var(--absl-exit-delay, 0ms);
            animation-timing-function: var(--absl-exit-easing, cubic-bezier(0.22, 1, 0.36, 1));
        }
        .absl-adv-heading__part.absl-motion--float{
            animation-name: absl-motion-float;
        }
        .absl-adv-heading__part.absl-motion--pulse{
            animation-name: absl-motion-pulse;
        }
        .absl-adv-heading__part.absl-motion--swing{
            animation-name: absl-motion-swing;
        }
        .absl-adv-heading__part.absl-motion--glow{
            animation-name: absl-motion-glow;
        }
        .absl-adv-subtitle{
            margin:0;
        }
        .absl-adv-heading-wrap.is-subtitle-above .absl-adv-subtitle{
            margin-bottom: var(--absl-subtitle-spacing, 8px);
        }
        .absl-adv-heading-wrap.is-subtitle-below .absl-adv-subtitle{
            margin-top: var(--absl-subtitle-spacing, 8px);
        }
        @keyframes absl-entry-fade-up{
            0%{ opacity:0; transform: translateY(18px); }
            100%{ opacity:1; transform: translateY(0); }
        }
        @keyframes absl-entry-fade-down{
            0%{ opacity:0; transform: translateY(-18px); }
            100%{ opacity:1; transform: translateY(0); }
        }
        @keyframes absl-entry-slide-left{
            0%{ opacity:0; transform: translateX(20px); }
            100%{ opacity:1; transform: translateX(0); }
        }
        @keyframes absl-entry-slide-right{
            0%{ opacity:0; transform: translateX(-20px); }
            100%{ opacity:1; transform: translateX(0); }
        }
        @keyframes absl-entry-zoom-in{
            0%{ opacity:0; transform: scale(0.85); }
            100%{ opacity:1; transform: scale(1); }
        }
        @keyframes absl-exit-fade-out{
            0%{ opacity:1; }
            100%{ opacity:0; }
        }
        @keyframes absl-exit-fade-up-out{
            0%{ opacity:1; transform: translateY(0); }
            100%{ opacity:0; transform: translateY(-18px); }
        }
        @keyframes absl-exit-fade-down-out{
            0%{ opacity:1; transform: translateY(0); }
            100%{ opacity:0; transform: translateY(18px); }
        }
        @keyframes absl-exit-slide-left-out{
            0%{ opacity:1; transform: translateX(0); }
            100%{ opacity:0; transform: translateX(-20px); }
        }
        @keyframes absl-exit-slide-right-out{
            0%{ opacity:1; transform: translateX(0); }
            100%{ opacity:0; transform: translateX(20px); }
        }
        @keyframes absl-exit-zoom-out{
            0%{ opacity:1; transform: scale(1); }
            100%{ opacity:0; transform: scale(0.8); }
        }
        @keyframes absl-exit-rotate-out{
            0%{ opacity:1; transform: rotate(0deg) scale(1); }
            100%{ opacity:0; transform: rotate(8deg) scale(0.9); }
        }
        @keyframes absl-motion-float{
            0%{ transform: translateY(0); }
            100%{ transform: translateY(-6px); }
        }
        @keyframes absl-motion-pulse{
            0%{ transform: scale(1); }
            50%{ transform: scale(1.03); }
            100%{ transform: scale(1); }
        }
        @keyframes absl-motion-swing{
            0%{ transform: rotate(-2deg); }
            50%{ transform: rotate(2deg); }
            100%{ transform: rotate(-2deg); }
        }
        @keyframes absl-motion-glow{
            0%{ filter: drop-shadow(0 0 0 rgba(255,255,255,0)); }
            50%{ filter: drop-shadow(0 0 10px rgba(255,255,255,0.45)); }
            100%{ filter: drop-shadow(0 0 0 rgba(255,255,255,0)); }
        }
        @media (prefers-reduced-motion: reduce){
            .absl-adv-heading__part,
            .absl-adv-heading__text{
                transition-duration: 0ms;
                animation-duration: 0ms;
                animation-delay: 0ms;
                animation-iteration-count: 1;
            }
        }
        </style>
        <?php
    }
}
