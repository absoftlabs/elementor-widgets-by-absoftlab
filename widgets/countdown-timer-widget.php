<?php
if (! defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class ABSL_Countdown_Timer_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'absl_countdown_timer';
    }

    public function get_title()
    {
        return __('Countdown Timer', 'absl-ew');
    }

    public function get_icon()
    {
        return 'eicon-countdown';
    }

    public function get_categories()
    {
        return ['absoftlab'];
    }

    public function get_style_depends()
    {
        return ['absl-countdown-timer'];
    }

    public function get_script_depends()
    {
        return ['absl-countdown-timer'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', [
            'label' => __('Content', 'absl-ew'),
        ]);

        $this->add_control('duration_days', [
            'label' => __('Days', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'min' => 0,
        ]);

        $this->add_control('duration_hours', [
            'label' => __('Hours', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 1,
            'min' => 0,
            'max' => 23,
        ]);

        $this->add_control('duration_minutes', [
            'label' => __('Minutes', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'min' => 0,
            'max' => 59,
        ]);

        $this->add_control('duration_seconds', [
            'label' => __('Seconds', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'min' => 0,
            'max' => 59,
        ]);

        $this->add_control('show_days', [
            'label' => __('Show Days', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('show_hours', [
            'label' => __('Show Hours', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('show_minutes', [
            'label' => __('Show Minutes', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('show_seconds', [
            'label' => __('Show Seconds', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('auto_reset', [
            'label' => __('Auto Reset', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('reset_delay', [
            'label' => __('Reset Delay (seconds)', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'min' => 0,
            'condition' => [
                'auto_reset' => 'yes',
            ],
        ]);

        $this->add_control('animation', [
            'label' => __('Digit Animation', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'flip',
            'options' => [
                'none' => __('None', 'absl-ew'),
                'flip' => __('Flip', 'absl-ew'),
                'slide' => __('Slide', 'absl-ew'),
                'pulse' => __('Pulse', 'absl-ew'),
            ],
        ]);

        $this->add_control('animation_duration', [
            'label' => __('Animation Duration (ms)', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 600,
            'min' => 50,
            'selectors' => [
                '{{WRAPPER}} .absl-countdown-timer' => '--absl-ct-anim-duration: {{VALUE}}ms;',
            ],
        ]);

        $this->add_control('show_labels', [
            'label' => __('Show Labels', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('label_days', [
            'label' => __('Days Label', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Days', 'absl-ew'),
            'condition' => [
                'show_labels' => 'yes',
                'show_days' => 'yes',
            ],
        ]);

        $this->add_control('label_hours', [
            'label' => __('Hours Label', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Hours', 'absl-ew'),
            'condition' => [
                'show_labels' => 'yes',
                'show_hours' => 'yes',
            ],
        ]);

        $this->add_control('label_minutes', [
            'label' => __('Minutes Label', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Minutes', 'absl-ew'),
            'condition' => [
                'show_labels' => 'yes',
                'show_minutes' => 'yes',
            ],
        ]);

        $this->add_control('label_seconds', [
            'label' => __('Seconds Label', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Seconds', 'absl-ew'),
            'condition' => [
                'show_labels' => 'yes',
                'show_seconds' => 'yes',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_layout', [
            'label' => __('Layout', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('align', [
            'label' => __('Alignment', 'absl-ew'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => __('Left', 'absl-ew'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => __('Center', 'absl-ew'),
                    'icon' => 'eicon-text-align-center',
                ],
                'flex-end' => [
                    'title' => __('Right', 'absl-ew'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-countdown-timer' => 'justify-content: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('gap', [
            'label' => __('Gap', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 0, 'max' => 60],
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-countdown-timer' => '--absl-ct-gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'digit_typography',
            'selector' => '{{WRAPPER}} .absl-ct-value',
        ]);

        $this->add_control('digit_color', [
            'label' => __('Digit Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-ct-value' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'label_typography',
            'selector' => '{{WRAPPER}} .absl-ct-label',
        ]);

        $this->add_control('label_color', [
            'label' => __('Label Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-ct-label' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'show_labels' => 'yes',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_digit_box', [
            'label' => __('Digit Box', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('digit_box_padding', [
            'label' => __('Padding', 'absl-ew'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .absl-ct-group' =>
                'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('digit_box_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 0, 'max' => 60],
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-ct-group' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs('digit_box_tabs');

        $this->start_controls_tab('digit_box_tab_normal', [
            'label' => __('Normal', 'absl-ew'),
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'digit_box_bg',
            'selector' => '{{WRAPPER}} .absl-ct-group',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'digit_box_border',
            'selector' => '{{WRAPPER}} .absl-ct-group',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'digit_box_shadow',
            'selector' => '{{WRAPPER}} .absl-ct-group',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('digit_box_tab_hover', [
            'label' => __('Hover', 'absl-ew'),
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'digit_box_bg_hover',
            'selector' => '{{WRAPPER}} .absl-ct-group:hover',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'digit_box_border_hover',
            'selector' => '{{WRAPPER}} .absl-ct-group:hover',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'digit_box_shadow_hover',
            'selector' => '{{WRAPPER}} .absl-ct-group:hover',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render()
    {
        if (function_exists('absl_ew_register_assets')) {
            absl_ew_register_assets();
        }
        if (class_exists('\Elementor\Plugin')) {
            $frontend = \Elementor\Plugin::$instance->frontend;
            if ($frontend && method_exists($frontend, 'enqueue_styles')) {
                $frontend->enqueue_styles();
            }
            if ($frontend && method_exists($frontend, 'enqueue_scripts')) {
                $frontend->enqueue_scripts();
            }
        }
        wp_enqueue_style('absl-countdown-timer');
        wp_enqueue_script('absl-countdown-timer');

        $s = $this->get_settings_for_display();
        $days = max(0, (int) ($s['duration_days'] ?? 0));
        $hours = max(0, min(23, (int) ($s['duration_hours'] ?? 0)));
        $minutes = max(0, min(59, (int) ($s['duration_minutes'] ?? 0)));
        $seconds = max(0, min(59, (int) ($s['duration_seconds'] ?? 0)));
        $duration = ($days * 86400) + ($hours * 3600) + ($minutes * 60) + $seconds;

        $animation = $s['animation'] ?? 'flip';
        $auto_reset = ($s['auto_reset'] ?? 'yes') === 'yes' ? 'yes' : 'no';
        $reset_delay = max(0, (int) ($s['reset_delay'] ?? 0));
        $anim_duration = max(50, (int) ($s['animation_duration'] ?? 600));
        $show_labels = ($s['show_labels'] ?? 'yes') === 'yes';
        $show_days = ($s['show_days'] ?? 'yes') === 'yes';
        $show_hours = ($s['show_hours'] ?? 'yes') === 'yes';
        $show_minutes = ($s['show_minutes'] ?? 'yes') === 'yes';
        $show_seconds = ($s['show_seconds'] ?? 'yes') === 'yes';

        $wrapper_class = 'absl-countdown-timer absl-ct-anim-' . esc_attr($animation);
        ?>
        <div class="<?php echo esc_attr($wrapper_class); ?>"
             data-duration="<?php echo esc_attr($duration); ?>"
             data-auto-reset="<?php echo esc_attr($auto_reset); ?>"
             data-reset-delay="<?php echo esc_attr($reset_delay); ?>"
             data-animation="<?php echo esc_attr($animation); ?>"
             data-animation-duration="<?php echo esc_attr($anim_duration); ?>">

            <?php if ($show_days) : ?>
                <div class="absl-ct-group absl-ct-days">
                    <div class="absl-ct-value">00</div>
                    <?php if ($show_labels) : ?>
                        <div class="absl-ct-label"><?php echo esc_html($s['label_days'] ?? __('Days', 'absl-ew')); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($show_hours) : ?>
                <div class="absl-ct-group absl-ct-hours">
                    <div class="absl-ct-value">00</div>
                    <?php if ($show_labels) : ?>
                        <div class="absl-ct-label"><?php echo esc_html($s['label_hours'] ?? __('Hours', 'absl-ew')); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($show_minutes) : ?>
                <div class="absl-ct-group absl-ct-minutes">
                    <div class="absl-ct-value">00</div>
                    <?php if ($show_labels) : ?>
                        <div class="absl-ct-label"><?php echo esc_html($s['label_minutes'] ?? __('Minutes', 'absl-ew')); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($show_seconds) : ?>
                <div class="absl-ct-group absl-ct-seconds">
                    <div class="absl-ct-value">00</div>
                    <?php if ($show_labels) : ?>
                        <div class="absl-ct-label"><?php echo esc_html($s['label_seconds'] ?? __('Seconds', 'absl-ew')); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
