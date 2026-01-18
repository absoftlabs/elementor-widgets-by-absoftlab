<?php
if (! defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

class ABSL_Tutor_Course_Card_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'absl_tutor_course_card';
    }

    public function get_title()
    {
        return __('Tutor Course Card Widget', 'absl-ew');
    }

    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    public function get_categories()
    {
        return ['absoftlab'];
    }

    public function get_style_depends()
    {
        return ['absl-tutor-course-card'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('content_section', [
            'label' => __('Content', 'absl-ew'),
        ]);

        $this->add_control('button_text', [
            'label' => __('Button Text', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Start Learning', 'absl-ew'),
        ]);

        $this->add_control('show_button_icon', [
            'label' => __('Show Button Icon', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('button_icon', [
            'label' => __('Button Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-shopping-cart',
                'library' => 'fa-solid',
            ],
            'condition' => ['show_button_icon' => 'yes'],
        ]);

        $this->add_control('show_author', [
            'label' => __('Show Author', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('show_duration', [
            'label' => __('Show Duration', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('duration_fallback', [
            'label' => __('Duration Fallback', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Self-paced', 'absl-ew'),
            'condition' => ['show_duration' => 'yes'],
        ]);

        $this->add_control('show_level', [
            'label' => __('Show Level', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('level_fallback', [
            'label' => __('Level Fallback', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Intermediate', 'absl-ew'),
            'condition' => ['show_level' => 'yes'],
        ]);

        $this->add_control('show_rating', [
            'label' => __('Show Rating', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('rating_icon_filled', [
            'label' => __('Filled Star Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-star',
                'library' => 'fa-solid',
            ],
            'condition' => ['show_rating' => 'yes'],
        ]);

        $this->add_control('rating_icon_half', [
            'label' => __('Half Star Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-star-half-alt',
                'library' => 'fa-solid',
            ],
            'condition' => ['show_rating' => 'yes'],
        ]);

        $this->add_control('rating_icon_empty', [
            'label' => __('Empty Star Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'far fa-star',
                'library' => 'fa-regular',
            ],
            'condition' => ['show_rating' => 'yes'],
        ]);

        $this->add_control('reviews_label', [
            'label' => __('Reviews Label', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('reviews', 'absl-ew'),
            'condition' => ['show_rating' => 'yes'],
        ]);

        $this->add_control('show_price', [
            'label' => __('Show Price', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('meta_icon_author', [
            'label' => __('Author Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-user',
                'library' => 'fa-solid',
            ],
            'condition' => ['show_author' => 'yes'],
        ]);

        $this->add_control('meta_icon_duration', [
            'label' => __('Duration Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'far fa-clock',
                'library' => 'fa-regular',
            ],
            'condition' => ['show_duration' => 'yes'],
        ]);

        $this->add_control('meta_icon_level', [
            'label' => __('Level Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-signal',
                'library' => 'fa-solid',
            ],
            'condition' => ['show_level' => 'yes'],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_grid', [
            'label' => __('Grid', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('grid_columns', [
            'label' => __('Columns', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                '1' => __('1', 'absl-ew'),
                '2' => __('2', 'absl-ew'),
                '3' => __('3', 'absl-ew'),
                '4' => __('4', 'absl-ew'),
            ],
            'default' => '3',
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
            ],
        ]);

        $this->add_responsive_control('grid_gap', [
            'label' => __('Gap', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 0, 'max' => 60],
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_card', [
            'label' => __('Card', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->start_controls_tabs('card_style_tabs');

        $this->start_controls_tab('card_style_normal', [
            'label' => __('Normal', 'absl-ew'),
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'card_bg',
            'selector' => '{{WRAPPER}} .absl-tutor-course-card',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'card_border',
            'selector' => '{{WRAPPER}} .absl-tutor-course-card',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('card_style_hover', [
            'label' => __('Hover', 'absl-ew'),
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'card_bg_hover',
            'selector' => '{{WRAPPER}} .absl-tutor-course-card:hover',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'card_border_hover',
            'selector' => '{{WRAPPER}} .absl-tutor-course-card:hover',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'card_shadow',
            'selector' => '{{WRAPPER}} .absl-tutor-course-card',
        ]);

        $this->add_responsive_control('card_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => 0, 'max' => 50],
                '%' => ['min' => 0, 'max' => 50],
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-card' => 'border-radius: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-tutor-course-media' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0;',
            ],
        ]);

        $this->add_responsive_control('card_padding', [
            'label' => __('Body Padding', 'absl-ew'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_media', [
            'label' => __('Image', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('image_height', [
            'label' => __('Height', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 120, 'max' => 500],
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-media' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_title', [
            'label' => __('Title', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('title_color', [
            'label' => __('Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-title, {{WRAPPER}} .absl-tutor-course-title a' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'title_typo',
            'selector' => '{{WRAPPER}} .absl-tutor-course-title',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_meta', [
            'label' => __('Meta', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('meta_color', [
            'label' => __('Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-meta' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('meta_icon_color', [
            'label' => __('Icon Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-meta i, {{WRAPPER}} .absl-tutor-course-meta svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'meta_typo',
            'selector' => '{{WRAPPER}} .absl-tutor-course-meta',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_icons', [
            'label' => __('Icons', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('icon_size', [
            'label' => __('Icon Size', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 8, 'max' => 40],
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-meta-icon i, {{WRAPPER}} .absl-meta-icon svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-button-icon i, {{WRAPPER}} .absl-button-icon svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-rating-stars .absl-star' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_rating', [
            'label' => __('Rating', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('rating_text_color', [
            'label' => __('Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-rating-value' => 'color: {{VALUE}};',
                '{{WRAPPER}} .absl-rating-count' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('rating_star_empty_color', [
            'label' => __('Empty Star Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}' => '--absl-rating-empty: {{VALUE}};',
            ],
        ]);

        $this->add_control('rating_star_half_color', [
            'label' => __('Half Star Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}' => '--absl-rating-half: {{VALUE}};',
            ],
        ]);

        $this->add_control('rating_star_color', [
            'label' => __('Star Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}' => '--absl-rating-fill: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_price', [
            'label' => __('Price', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('price_color', [
            'label' => __('Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-price' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('price_regular_color', [
            'label' => __('Regular Price Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-price del' => 'color: {{VALUE}};',
                '{{WRAPPER}} .absl-tutor-course-price del .amount' => 'color: {{VALUE}};',
                '{{WRAPPER}} .absl-tutor-course-price del bdi' => 'color: {{VALUE}};',
                '{{WRAPPER}} .absl-tutor-course-price del span' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('price_sale_color', [
            'label' => __('Sale Price Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-price ins' => 'color: {{VALUE}};',
                '{{WRAPPER}} .absl-tutor-course-price ins .amount' => 'color: {{VALUE}};',
                '{{WRAPPER}} .absl-tutor-course-price ins bdi' => 'color: {{VALUE}};',
                '{{WRAPPER}} .absl-tutor-course-price ins span' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'price_typo',
            'selector' => '{{WRAPPER}} .absl-tutor-course-price',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_button', [
            'label' => __('Button', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'button_typo',
            'selector' => '{{WRAPPER}} .absl-tutor-course-button',
        ]);

        $this->add_control('button_text_color', [
            'label' => __('Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-button' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'button_bg',
            'selector' => '{{WRAPPER}} .absl-tutor-course-button',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'button_border',
            'selector' => '{{WRAPPER}} .absl-tutor-course-button',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'button_shadow',
            'selector' => '{{WRAPPER}} .absl-tutor-course-button',
        ]);

        $this->add_responsive_control('button_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => 0, 'max' => 60],
                '%' => ['min' => 0, 'max' => 50],
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-button' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('button_padding', [
            'label' => __('Padding', 'absl-ew'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .absl-tutor-course-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();

        $tutor_utils = function_exists('tutor_utils') ? tutor_utils() : null;
        $course_post_type = '';

        if (post_type_exists('tutor_course')) {
            $course_post_type = 'tutor_course';
        } elseif (post_type_exists('courses')) {
            $course_post_type = 'courses';
        }

        if (! $course_post_type && ! $tutor_utils) {
            echo '<div class="absl-tutor-course-empty">' . esc_html__('Tutor LMS is not active.', 'absl-ew') . '</div>';
            return;
        }

        $query = new WP_Query([
            'post_type' => $course_post_type ?: 'tutor_course',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'no_found_rows' => true,
        ]);

        if (! $query->have_posts()) {
            echo '<div class="absl-tutor-course-empty">' . esc_html__('No courses found.', 'absl-ew') . '</div>';
            return;
        }

        $button_text = ! empty($s['button_text']) ? $s['button_text'] : __('Start Learning', 'absl-ew');
        $show_author = ! empty($s['show_author']) && $s['show_author'] === 'yes';
        $show_duration = ! empty($s['show_duration']) && $s['show_duration'] === 'yes';
        $show_level = ! empty($s['show_level']) && $s['show_level'] === 'yes';
        $show_rating = ! empty($s['show_rating']) && $s['show_rating'] === 'yes';
        $show_price = ! empty($s['show_price']) && $s['show_price'] === 'yes';
        $show_button_icon = ! empty($s['show_button_icon']) && $s['show_button_icon'] === 'yes';
        $reviews_label = ! empty($s['reviews_label']) ? $s['reviews_label'] : __('reviews', 'absl-ew');
        $duration_fallback = ! empty($s['duration_fallback']) ? $s['duration_fallback'] : __('Self-paced', 'absl-ew');
        $level_fallback = ! empty($s['level_fallback']) ? $s['level_fallback'] : __('Intermediate', 'absl-ew');
        $rating_empty_color = ! empty($s['rating_star_empty_color']) ? $s['rating_star_empty_color'] : '';
        $rating_half_color = ! empty($s['rating_star_half_color']) ? $s['rating_star_half_color'] : '';
        $rating_fill_color = ! empty($s['rating_star_color']) ? $s['rating_star_color'] : '';
        $rating_style = '';
        if ($rating_empty_color || $rating_half_color || $rating_fill_color) {
            $rating_style = ' style="'
                . ($rating_empty_color ? '--absl-rating-empty:' . esc_attr($rating_empty_color) . ';' : '')
                . ($rating_half_color ? '--absl-rating-half:' . esc_attr($rating_half_color) . ';' : '')
                . ($rating_fill_color ? '--absl-rating-fill:' . esc_attr($rating_fill_color) . ';' : '')
                . '"';
        }

        ?>
        <div class="absl-tutor-course-grid"<?php echo $rating_style; ?>>
            <?php while ($query->have_posts()): $query->the_post();
                $course_id = get_the_ID();
                $course_link = get_permalink($course_id);
                $thumbnail_url = get_the_post_thumbnail_url($course_id, 'large');
                if (! $thumbnail_url) {
                    $thumbnail_url = \Elementor\Utils::get_placeholder_image_src();
                }
                $thumbnail_alt = get_post_meta(get_post_thumbnail_id($course_id), '_wp_attachment_image_alt', true);
                if (! $thumbnail_alt) {
                    $thumbnail_alt = get_the_title($course_id);
                }

                $author_name = get_the_author_meta('display_name', get_post_field('post_author', $course_id));
                if ($tutor_utils && method_exists($tutor_utils, 'get_instructor_name')) {
                    $maybe_author = $tutor_utils->get_instructor_name($course_id);
                    if (! empty($maybe_author)) {
                        $author_name = $maybe_author;
                    }
                }

                $duration_text = '';
                if ($tutor_utils && method_exists($tutor_utils, 'get_course_duration_context')) {
                    $duration_text = $tutor_utils->get_course_duration_context($course_id);
                } elseif ($tutor_utils && method_exists($tutor_utils, 'get_course_duration')) {
                    try {
                        $method = new ReflectionMethod($tutor_utils, 'get_course_duration');
                        if ($method->getNumberOfParameters() >= 2) {
                            $duration_text = $tutor_utils->get_course_duration($course_id, false);
                        } else {
                            $duration_text = $tutor_utils->get_course_duration($course_id);
                        }
                    } catch (Exception $e) {
                        $duration_text = '';
                    }
                }
                if (! $duration_text) {
                    $duration_text = $duration_fallback;
                }

                $level_text = '';
                if ($tutor_utils && method_exists($tutor_utils, 'get_course_level')) {
                    $level_text = $tutor_utils->get_course_level($course_id);
                }
                if (! $level_text) {
                    $level_text = get_post_meta($course_id, '_tutor_course_level', true);
                }
                if (! $level_text) {
                    $level_text = $level_fallback;
                }

                $rating_avg = 0;
                $rating_count = 0;
                if ($tutor_utils && method_exists($tutor_utils, 'get_course_rating')) {
                    $rating_data = $tutor_utils->get_course_rating($course_id);
                    if (is_array($rating_data)) {
                        $rating_avg = isset($rating_data['rating_avg']) ? (float) $rating_data['rating_avg'] : 0;
                        $rating_count = isset($rating_data['rating_count']) ? (int) $rating_data['rating_count'] : 0;
                    }
                }
                $rating_display = $rating_avg > 0 ? number_format_i18n($rating_avg, 1) : '0';
                $rating_filled_icon = ! empty($s['rating_icon_filled']['value']) ? $s['rating_icon_filled'] : [];
                $rating_half_icon = ! empty($s['rating_icon_half']['value']) ? $s['rating_icon_half'] : [];
                $rating_empty_icon = ! empty($s['rating_icon_empty']['value']) ? $s['rating_icon_empty'] : [];

                $price_html = '';
                if ($tutor_utils && method_exists($tutor_utils, 'get_course_price')) {
                    $price_html = $tutor_utils->get_course_price($course_id);
                }
                if (! $price_html) {
                    $price_type = get_post_meta($course_id, '_tutor_course_price_type', true);
                    if ($price_type === 'free' || $price_type === 'free_course') {
                        $price_html = esc_html__('Free', 'absl-ew');
                    } else {
                        $price_value = get_post_meta($course_id, '_tutor_course_price', true);
                        if ($price_value !== '') {
                            $price_html = esc_html($price_value);
                        } else {
                            $price_html = esc_html__('Free', 'absl-ew');
                        }
                    }
                }

                if ($price_html) {
                    $price_html = preg_replace('/(\d)\.00\b/', '$1', $price_html);
                }
            ?>
            <article class="absl-tutor-course-card">
                <div class="absl-tutor-course-media">
                    <a href="<?php echo esc_url($course_link); ?>">
                        <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($thumbnail_alt); ?>">
                    </a>
                </div>
                <div class="absl-tutor-course-body">
                    <h3 class="absl-tutor-course-title">
                        <a href="<?php echo esc_url($course_link); ?>"><?php echo esc_html(get_the_title($course_id)); ?></a>
                    </h3>

                    <?php if ($show_author || $show_duration || $show_level): ?>
                        <div class="absl-tutor-course-meta">
                            <?php if ($show_author && $author_name): ?>
                                <span class="absl-meta-item">
                                    <span class="absl-meta-icon">
                                        <?php if (! empty($s['meta_icon_author']['value'])) { Icons_Manager::render_icon($s['meta_icon_author'], ['aria-hidden' => 'true']); } ?>
                                    </span>
                                    <span class="absl-meta-text"><?php echo esc_html($author_name); ?></span>
                                </span>
                            <?php endif; ?>
                            <?php if ($show_duration && $duration_text): ?>
                                <span class="absl-meta-item">
                                    <span class="absl-meta-icon">
                                        <?php if (! empty($s['meta_icon_duration']['value'])) { Icons_Manager::render_icon($s['meta_icon_duration'], ['aria-hidden' => 'true']); } ?>
                                    </span>
                                    <span class="absl-meta-text"><?php echo esc_html($duration_text); ?></span>
                                </span>
                            <?php endif; ?>
                            <?php if ($show_level && $level_text): ?>
                                <span class="absl-meta-item">
                                    <span class="absl-meta-icon">
                                        <?php if (! empty($s['meta_icon_level']['value'])) { Icons_Manager::render_icon($s['meta_icon_level'], ['aria-hidden' => 'true']); } ?>
                                    </span>
                                    <span class="absl-meta-text"><?php echo esc_html($level_text); ?></span>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($show_rating): ?>
                        <div class="absl-tutor-course-rating">
                            <span class="absl-rating-stars" aria-hidden="true">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php
                                        $star_class = 'absl-star';
                                        $icon_data = $rating_empty_icon;
                                        if ($rating_avg >= $i) {
                                            $star_class .= ' is-filled';
                                            $icon_data = $rating_filled_icon;
                                        } elseif ($rating_avg >= ($i - 0.5)) {
                                            $star_class .= ' is-half';
                                            $icon_data = $rating_half_icon;
                                        }
                                        if (! $icon_data) {
                                            $icon_data = $rating_avg >= $i
                                                ? $rating_filled_icon
                                                : ($rating_avg >= ($i - 0.5) ? $rating_half_icon : $rating_empty_icon);
                                        }
                                    ?>
                                    <span class="<?php echo esc_attr($star_class); ?>">
                                        <?php if ($icon_data): ?>
                                            <?php Icons_Manager::render_icon($icon_data, ['aria-hidden' => 'true']); ?>
                                        <?php else: ?>
                                            <svg class="absl-star-icon" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false">
                                                <path d="M12 2.75l2.99 6.06 6.69.97-4.84 4.72 1.14 6.64L12 17.9l-5.98 3.14 1.14-6.64L2.32 9.78l6.69-.97L12 2.75z"></path>
                                            </svg>
                                        <?php endif; ?>
                                    </span>
                                <?php endfor; ?>
                            </span>
                            <span class="absl-rating-value"><?php echo esc_html($rating_display); ?></span>
                            <span class="absl-rating-count">(<?php echo esc_html(number_format_i18n($rating_count)); ?> <?php echo esc_html($reviews_label); ?>)</span>
                        </div>
                    <?php endif; ?>

                    <div class="absl-tutor-course-footer">
                        <?php if ($show_price): ?>
                            <div class="absl-tutor-course-price"><?php echo wp_kses_post($price_html); ?></div>
                        <?php endif; ?>
                        <a class="absl-tutor-course-button" href="<?php echo esc_url($course_link); ?>">
                            <?php if ($show_button_icon && ! empty($s['button_icon']['value'])): ?>
                                <span class="absl-button-icon">
                                    <?php Icons_Manager::render_icon($s['button_icon'], ['aria-hidden' => 'true']); ?>
                                </span>
                            <?php endif; ?>
                            <span class="absl-button-text"><?php echo esc_html($button_text); ?></span>
                        </a>
                    </div>
                </div>
            </article>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();
    }
}
