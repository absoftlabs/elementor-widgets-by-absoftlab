<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Icons_Manager;

class ABSL_Course_Accordion_Widget extends Widget_Base {
    public function get_name() { return 'absl_course_accordion'; }
    public function get_title() { return __('Course Accordion', 'absl-ew'); }
    public function get_icon() { return 'eicon-accordion'; }
    public function get_categories() { return ['absoftlab']; }
    public function get_style_depends() { return ['absl-course-accordion']; }
    public function get_script_depends() { return ['absl-course-accordion']; }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => __('Courses', 'absl-ew'),
        ]);

        $lesson_repeater = new Repeater();
        $lesson_repeater->add_control('lesson_title', [
            'label' => __('Lesson Title', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'default' => __('Introduction to Video Editing', 'absl-ew'),
        ]);
        $lesson_repeater->add_control('lesson_duration', [
            'label' => __('Lesson Duration', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'default' => __('10:30', 'absl-ew'),
        ]);
        $lesson_repeater->add_control('lesson_badge', [
            'label' => __('Lesson Badge', 'absl-ew'),
            'type'  => Controls_Manager::SELECT,
            'default' => 'preview',
            'options' => [
                'none' => __('None', 'absl-ew'),
                'preview' => __('Preview', 'absl-ew'),
                'locked' => __('Locked', 'absl-ew'),
            ],
        ]);
        $lesson_repeater->add_control('lesson_badge_text', [
            'label' => __('Preview Text', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'default' => __('Preview', 'absl-ew'),
            'condition' => ['lesson_badge' => 'preview'],
        ]);
        $lesson_repeater->add_control('lesson_link', [
            'label' => __('Lesson Video Link', 'absl-ew'),
            'type' => Controls_Manager::URL,
            'placeholder' => __('https://your-link.com', 'absl-ew'),
            'options' => ['url', 'is_external', 'nofollow'],
            'description' => __('Only applies to unlocked lessons (Preview/None).', 'absl-ew'),
        ]);

        $course_repeater = new Repeater();
        $course_repeater->add_control('course_number', [
            'label' => __('Number', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'default' => '01',
        ]);
        $course_repeater->add_control('course_title', [
            'label' => __('Course Title', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'default' => __('Basics of Video Editing', 'absl-ew'),
        ]);
        $course_repeater->add_control('course_lessons', [
            'label' => __('Lessons Count', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'default' => '4',
        ]);
        $course_repeater->add_control('course_duration', [
            'label' => __('Total Duration', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'default' => __('1h 45m', 'absl-ew'),
        ]);
        $course_repeater->add_control('course_open', [
            'label' => __('Open by Default', 'absl-ew'),
            'type'  => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);
        $course_repeater->add_control('lessons', [
            'label' => __('Lessons', 'absl-ew'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $lesson_repeater->get_controls(),
            'default' => [
                [
                    'lesson_title' => __('Introduction to Video Editing', 'absl-ew'),
                    'lesson_duration' => __('10:30', 'absl-ew'),
                    'lesson_badge' => 'preview',
                ],
                [
                    'lesson_title' => __('Understanding Your Editing Software', 'absl-ew'),
                    'lesson_duration' => __('15:00', 'absl-ew'),
                    'lesson_badge' => 'preview',
                ],
                [
                    'lesson_title' => __('Importing and Organizing Footage', 'absl-ew'),
                    'lesson_duration' => __('12:45', 'absl-ew'),
                    'lesson_badge' => 'locked',
                ],
                [
                    'lesson_title' => __('Basic Cuts and Transitions', 'absl-ew'),
                    'lesson_duration' => __('18:20', 'absl-ew'),
                    'lesson_badge' => 'locked',
                ],
            ],
            'title_field' => '{{{ lesson_title }}}',
        ]);

        $this->add_control('courses', [
            'label' => __('Courses', 'absl-ew'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $course_repeater->get_controls(),
            'default' => [
                [
                    'course_number' => '01',
                    'course_title' => __('Basics of Video Editing', 'absl-ew'),
                    'course_lessons' => '4',
                    'course_duration' => __('1h 45m', 'absl-ew'),
                    'course_open' => 'yes',
                ],
                [
                    'course_number' => '02',
                    'course_title' => __('Editing for Social Media', 'absl-ew'),
                    'course_lessons' => '3',
                    'course_duration' => __('2h 15m', 'absl-ew'),
                    'course_open' => '',
                ],
                [
                    'course_number' => '03',
                    'course_title' => __('Branding & Visual Consistency', 'absl-ew'),
                    'course_lessons' => '2',
                    'course_duration' => __('1h 30m', 'absl-ew'),
                    'course_open' => '',
                ],
            ],
            'title_field' => '{{{ course_title }}}',
        ]);

        $this->add_control('lesson_label', [
            'label' => __('Lessons Label', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('lessons', 'absl-ew'),
        ]);

        $this->add_control('allow_multiple', [
            'label' => __('Allow Multiple Open', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'return_value' => 'yes',
        ]);

        $this->add_control('meta_icon_lessons', [
            'label' => __('Lessons Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-play',
                'library' => 'fa-solid',
            ],
        ]);
        $this->add_control('meta_icon_duration', [
            'label' => __('Duration Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'far fa-clock',
                'library' => 'fa-regular',
            ],
        ]);
        $this->add_control('lesson_icon', [
            'label' => __('Lesson Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-play',
                'library' => 'fa-solid',
            ],
        ]);
        $this->add_control('toggle_icon', [
            'label' => __('Toggle Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-chevron-down',
                'library' => 'fa-solid',
            ],
        ]);
        $this->add_control('lock_icon', [
            'label' => __('Lock Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-lock',
                'library' => 'fa-solid',
            ],
        ]);
        $this->add_control('badge_icon', [
            'label' => __('Preview Badge Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-play',
                'library' => 'fa-solid',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_wrapper', [
            'label' => __('Wrapper', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('wrapper_gap', [
            'label' => __('Card Gap', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 40]],
            'selectors' => [
                '{{WRAPPER}} .absl-course-accordion' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_card', [
            'label' => __('Course Card', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'card_bg',
            'selector' => '{{WRAPPER}} .absl-course-item',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'card_border',
            'selector' => '{{WRAPPER}} .absl-course-item',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'card_border_hover',
            'label' => __('Hover Border', 'absl-ew'),
            'selector' => '{{WRAPPER}} .absl-course-item:hover',
        ]);

        $this->add_responsive_control('card_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => ['px' => ['min' => 0, 'max' => 60], '%' => ['min' => 0, 'max' => 50]],
            'selectors' => [
                '{{WRAPPER}} .absl-course-item' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'card_shadow',
            'selector' => '{{WRAPPER}} .absl-course-item',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_header', [
            'label' => __('Header', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('header_padding', [
            'label' => __('Padding', 'absl-ew'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .absl-course-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->start_controls_tabs('header_style_tabs');

        $this->start_controls_tab('header_style_normal', [
            'label' => __('Normal', 'absl-ew'),
        ]);

        $this->add_control('header_bg', [
            'label' => __('Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-course-header' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('header_title_color', [
            'label' => __('Title Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-course-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('meta_color', [
            'label' => __('Meta Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-course-meta' => 'color: {{VALUE}};',
                '{{WRAPPER}} .absl-meta-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('meta_icon_color', [
            'label' => __('Meta Icon Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-meta-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('meta_icon_bg', [
            'label' => __('Meta Icon Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-meta-icon' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->add_responsive_control('meta_icon_size', [
            'label' => __('Meta Icon Size', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 10, 'max' => 40]],
            'selectors' => [
                '{{WRAPPER}} .absl-meta-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-meta-icon i, {{WRAPPER}} .absl-meta-icon svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('meta_icon_radius', [
            'label' => __('Meta Icon Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => ['px' => ['min' => 0, 'max' => 30], '%' => ['min' => 0, 'max' => 50]],
            'selectors' => [
                '{{WRAPPER}} .absl-meta-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('header_style_active', [
            'label' => __('Active', 'absl-ew'),
        ]);

        $this->add_control('header_bg_active', [
            'label' => __('Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-course-item.is-open .absl-course-header' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('header_title_color_active', [
            'label' => __('Title Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-course-item.is-open .absl-course-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('meta_color_active', [
            'label' => __('Meta Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-course-item.is-open .absl-course-meta' => 'color: {{VALUE}};',
                '{{WRAPPER}} .absl-course-item.is-open .absl-meta-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'header_title_typo',
            'selector' => '{{WRAPPER}} .absl-course-title',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'meta_typo',
            'selector' => '{{WRAPPER}} .absl-course-meta',
        ]);

        $this->add_responsive_control('meta_gap', [
            'label' => __('Meta Gap', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0, 'max' => 30]],
            'selectors' => [
                '{{WRAPPER}} .absl-course-meta' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_number', [
            'label' => __('Number Badge', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'number_bg',
            'label' => __('Background', 'absl-ew'),
            'types' => ['classic', 'gradient'],
            'selector' => '{{WRAPPER}} .absl-course-number',
        ]);

        $this->add_control('number_color', [
            'label' => __('Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-course-number' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'number_typo',
            'selector' => '{{WRAPPER}} .absl-course-number',
        ]);

        $this->add_responsive_control('number_size', [
            'label' => __('Size', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 24, 'max' => 80]],
            'selectors' => [
                '{{WRAPPER}} .absl-course-number' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('number_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => ['px' => ['min' => 0, 'max' => 40], '%' => ['min' => 0, 'max' => 50]],
            'selectors' => [
                '{{WRAPPER}} .absl-course-number' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_toggle', [
            'label' => __('Toggle Icon', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('toggle_color', [
            'label' => __('Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-course-toggle' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('toggle_bg', [
            'label' => __('Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-course-toggle' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('toggle_size', [
            'label' => __('Size', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 10, 'max' => 40]],
            'selectors' => [
                '{{WRAPPER}} .absl-course-toggle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-course-toggle i, {{WRAPPER}} .absl-course-toggle svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('toggle_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => ['px' => ['min' => 0, 'max' => 30], '%' => ['min' => 0, 'max' => 50]],
            'selectors' => [
                '{{WRAPPER}} .absl-course-toggle' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_lessons', [
            'label' => __('Lessons', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('lessons_bg', [
            'label' => __('Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-course-body' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('lessons_divider', [
            'label' => __('Divider Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson' => 'border-top-color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('lesson_padding', [
            'label' => __('Lesson Padding', 'absl-ew'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_control('lesson_title_color', [
            'label' => __('Title Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-title' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('lesson_time_color', [
            'label' => __('Time Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-time' => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_control('lesson_hover_bg', [
            'label' => __('Hover Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson:hover' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->add_control('lesson_hover_title_color', [
            'label' => __('Hover Title Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson:hover .absl-lesson-title' => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_control('lesson_hover_time_color', [
            'label' => __('Hover Time Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson:hover .absl-lesson-time' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'lesson_title_typo',
            'selector' => '{{WRAPPER}} .absl-lesson-title',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'lesson_time_typo',
            'selector' => '{{WRAPPER}} .absl-lesson-time',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_lesson_icon', [
            'label' => __('Lesson Icon', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('lesson_icon_bg', [
            'label' => __('Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-icon' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('lesson_icon_color', [
            'label' => __('Icon Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('lesson_icon_size', [
            'label' => __('Container Size', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 18, 'max' => 60]],
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('lesson_icon_padding', [
            'label' => __('Padding', 'absl-ew'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('lesson_icon_inner_size', [
            'label' => __('Icon Size', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 10, 'max' => 40]],
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-icon i, {{WRAPPER}} .absl-lesson-icon svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('lesson_icon_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => ['px' => ['min' => 0, 'max' => 30], '%' => ['min' => 0, 'max' => 50]],
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_badge', [
            'label' => __('Preview Badge', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('badge_bg', [
            'label' => __('Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-badge' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('badge_color', [
            'label' => __('Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-badge' => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_control('badge_icon_color', [
            'label' => __('Icon Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-badge-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('badge_icon_bg', [
            'label' => __('Icon Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-badge-icon' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->add_responsive_control('badge_icon_size', [
            'label' => __('Icon Size', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 10, 'max' => 40]],
            'selectors' => [
                '{{WRAPPER}} .absl-badge-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-badge-icon i, {{WRAPPER}} .absl-badge-icon svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('badge_icon_radius', [
            'label' => __('Icon Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => ['px' => ['min' => 0, 'max' => 30], '%' => ['min' => 0, 'max' => 50]],
            'selectors' => [
                '{{WRAPPER}} .absl-badge-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'badge_typo',
            'selector' => '{{WRAPPER}} .absl-lesson-badge',
        ]);

        $this->add_responsive_control('badge_padding', [
            'label' => __('Padding', 'absl-ew'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('badge_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => ['px' => ['min' => 0, 'max' => 40], '%' => ['min' => 0, 'max' => 50]],
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-badge' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_lock', [
            'label' => __('Lock Icon', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('lock_color', [
            'label' => __('Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-lock' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('lock_bg', [
            'label' => __('Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-lock' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('lock_size', [
            'label' => __('Size', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 10, 'max' => 32]],
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-lock' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-lesson-lock i, {{WRAPPER}} .absl-lesson-lock svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('lock_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => ['px' => ['min' => 0, 'max' => 30], '%' => ['min' => 0, 'max' => 50]],
            'selectors' => [
                '{{WRAPPER}} .absl-lesson-lock' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $allow_multiple = (!empty($s['allow_multiple']) && $s['allow_multiple'] === 'yes') ? 'yes' : 'no';
        $lesson_label = !empty($s['lesson_label']) ? $s['lesson_label'] : __('lessons', 'absl-ew');
        $courses = !empty($s['courses']) && is_array($s['courses']) ? $s['courses'] : [];
        ?>
        <div class="absl-course-accordion" data-allow-multiple="<?php echo esc_attr($allow_multiple); ?>">
            <?php foreach ($courses as $course):
                $is_open = !empty($course['course_open']) && $course['course_open'] === 'yes';
                $course_title = !empty($course['course_title']) ? $course['course_title'] : '';
                $course_number = !empty($course['course_number']) ? $course['course_number'] : '';
                $course_duration = !empty($course['course_duration']) ? $course['course_duration'] : '';
                $course_lessons = !empty($course['course_lessons']) ? $course['course_lessons'] : '';
                $lessons = !empty($course['lessons']) && is_array($course['lessons']) ? $course['lessons'] : [];
                if ($course_lessons === '') {
                    $course_lessons = count($lessons);
                }
                $course_lessons_text = trim($course_lessons . ' ' . $lesson_label);
            ?>
            <div class="absl-course-item<?php echo $is_open ? ' is-open' : ''; ?>">
                <div class="absl-course-header" role="button" tabindex="0" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>">
                    <div class="absl-course-number"><?php echo esc_html($course_number); ?></div>
                    <div class="absl-course-main">
                        <h3 class="absl-course-title"><?php echo esc_html($course_title); ?></h3>
                        <div class="absl-course-meta">
                            <span class="absl-meta">
                                <span class="absl-meta-icon">
                                    <?php if (!empty($s['meta_icon_lessons']['value'])) { Icons_Manager::render_icon($s['meta_icon_lessons'], ['aria-hidden' => 'true']); } ?>
                                </span>
                                <span class="absl-meta-text"><?php echo esc_html($course_lessons_text); ?></span>
                            </span>
                            <span class="absl-meta">
                                <span class="absl-meta-icon">
                                    <?php if (!empty($s['meta_icon_duration']['value'])) { Icons_Manager::render_icon($s['meta_icon_duration'], ['aria-hidden' => 'true']); } ?>
                                </span>
                                <span class="absl-meta-text"><?php echo esc_html($course_duration); ?></span>
                            </span>
                        </div>
                    </div>
                    <div class="absl-course-toggle">
                        <?php if (!empty($s['toggle_icon']['value'])) { Icons_Manager::render_icon($s['toggle_icon'], ['aria-hidden' => 'true']); } ?>
                    </div>
                </div>
                <div class="absl-course-body">
                    <?php foreach ($lessons as $lesson):
                        $badge = !empty($lesson['lesson_badge']) ? $lesson['lesson_badge'] : 'none';
                        $badge_text = !empty($lesson['lesson_badge_text']) ? $lesson['lesson_badge_text'] : __('Preview', 'absl-ew');
                        $lesson_title = !empty($lesson['lesson_title']) ? $lesson['lesson_title'] : '';
                        $lesson_duration = !empty($lesson['lesson_duration']) ? $lesson['lesson_duration'] : '';
                        $lesson_link = !empty($lesson['lesson_link']['url']) ? $lesson['lesson_link'] : [];
                        $lesson_has_link = ($badge === 'preview' && !empty($lesson_link['url']));
                        $lesson_target = !empty($lesson_link['is_external']) ? ' target="_blank"' : '';
                        $lesson_rel = [];
                        if (!empty($lesson_link['nofollow'])) $lesson_rel[] = 'nofollow';
                        if (!empty($lesson_link['is_external'])) $lesson_rel[] = 'noopener noreferrer';
                        $lesson_rel_attr = $lesson_rel ? ' rel="'.esc_attr(implode(' ', $lesson_rel)).'"' : '';
                    ?>
                    <div class="absl-lesson">
                        <span class="absl-lesson-icon">
                            <?php if (!empty($s['lesson_icon']['value'])) { Icons_Manager::render_icon($s['lesson_icon'], ['aria-hidden' => 'true']); } ?>
                        </span>
                        <div class="absl-lesson-main">
                            <div class="absl-lesson-title"><?php echo esc_html($lesson_title); ?></div>
                            <div class="absl-lesson-time"><?php echo esc_html($lesson_duration); ?></div>
                        </div>
                        <div class="absl-lesson-action">
                            <?php if ($badge === 'preview'): ?>
                                <?php if ($lesson_has_link): ?>
                                    <a class="absl-lesson-badge absl-lesson-badge-link" href="<?php echo esc_url($lesson_link['url']); ?>"<?php echo $lesson_target . $lesson_rel_attr; ?>>
                                <?php else: ?>
                                    <span class="absl-lesson-badge">
                                <?php endif; ?>
                                        <?php if (!empty($s['badge_icon']['value'])): ?>
                                            <span class="absl-badge-icon">
                                                <?php Icons_Manager::render_icon($s['badge_icon'], ['aria-hidden' => 'true']); ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="absl-badge-text"><?php echo esc_html($badge_text); ?></span>
                                <?php if ($lesson_has_link): ?>
                                    </a>
                                <?php else: ?>
                                    </span>
                                <?php endif; ?>
                            <?php elseif ($badge === 'locked'): ?>
                                <span class="absl-lesson-lock">
                                    <?php if (!empty($s['lock_icon']['value'])) { Icons_Manager::render_icon($s['lock_icon'], ['aria-hidden' => 'true']); } ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
