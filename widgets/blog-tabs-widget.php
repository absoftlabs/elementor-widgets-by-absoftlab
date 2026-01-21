<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

class ABSL_Blog_Tabs_Widget extends Widget_Base {

    public function get_name() { return 'absl_blog_tabs'; }
    public function get_title() { return __( 'Blog Tabs', 'absl-ew' ); }
    public function get_icon() { return 'eicon-posts-ticker'; }
    public function get_categories() { return [ 'absoftlab' ]; }

    public function get_style_depends() { return [ 'absl-blog-tabs' ]; }
    public function get_script_depends() { return [ 'absl-blog-tabs' ]; }

    private function get_category_options() {
        $terms = get_terms([
            'taxonomy' => 'category',
            'hide_empty' => true,
        ]);

        $options = [];
        if ( ! is_wp_error($terms) ) {
            foreach ($terms as $term) {
                $options[$term->term_id] = $term->name;
            }
        }

        return $options;
    }

    protected function register_controls() {

        /* ================= CONTENT ================= */

        $this->start_controls_section('section_query', [
            'label' => __('Query', 'absl-ew'),
        ]);

        $this->add_control('categories', [
            'label' => __('Categories', 'absl-ew'),
            'type' => Controls_Manager::SELECT2,
            'options' => $this->get_category_options(),
            'multiple' => true,
            'label_block' => true,
        ]);

        $this->add_control('show_all_tab', [
            'label' => __('Show "All Posts" Tab', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('all_tab_label', [
            'label' => __('All Tab Label', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('All Posts', 'absl-ew'),
            'condition' => [
                'show_all_tab' => 'yes',
            ],
        ]);

        $this->add_control('posts_per_page', [
            'label' => __('Posts Per Page', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 6,
            'min' => 1,
        ]);

        $this->add_control('max_posts', [
            'label' => __('Total Posts to Load', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 24,
            'min' => 1,
        ]);

        $this->add_control('orderby', [
            'label' => __('Order By', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'date' => __('Date', 'absl-ew'),
                'title' => __('Title', 'absl-ew'),
                'comment_count' => __('Comment Count', 'absl-ew'),
                'rand' => __('Random', 'absl-ew'),
            ],
        ]);

        $this->add_control('order', [
            'label' => __('Order', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'DESC',
            'options' => [
                'DESC' => __('DESC', 'absl-ew'),
                'ASC' => __('ASC', 'absl-ew'),
            ],
        ]);

        $this->add_control('enable_pagination', [
            'label' => __('Enable Pagination', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('card_style', [
            'label' => __('Card Design', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'style-1',
            'options' => [
                'style-1' => __('Style 1 (Screenshot)', 'absl-ew'),
                'style-2' => __('Style 2', 'absl-ew'),
                'style-3' => __('Style 3', 'absl-ew'),
            ],
        ]);

        $this->add_responsive_control('columns', [
            'label' => __('Columns', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 4,
            'default' => 3,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-grid' => '--absl-cols: {{VALUE}};',
            ],
        ]);

        $this->add_control('show_thumbnail', [
            'label' => __('Show Featured Image', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('show_category_badge', [
            'label' => __('Show Category Badge', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('show_date', [
            'label' => __('Show Date', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('show_read_time', [
            'label' => __('Show Read Time', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('show_author', [
            'label' => __('Show Author', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'no',
            'return_value' => 'yes',
        ]);

        $this->add_control('read_time_wpm', [
            'label' => __('Words Per Minute', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 200,
            'min' => 100,
            'condition' => [
                'show_read_time' => 'yes',
            ],
        ]);

        $this->add_control('show_date_icon', [
            'label' => __('Show Date Icon', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
            'condition' => [
                'show_date' => 'yes',
            ],
        ]);

        $this->add_control('date_icon', [
            'label' => __('Date Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'far fa-calendar-alt',
                'library' => 'fa-regular',
            ],
            'condition' => [
                'show_date' => 'yes',
                'show_date_icon' => 'yes',
            ],
        ]);

        $this->add_control('show_read_time_icon', [
            'label' => __('Show Read Time Icon', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
            'condition' => [
                'show_read_time' => 'yes',
            ],
        ]);

        $this->add_control('read_time_icon', [
            'label' => __('Read Time Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'far fa-clock',
                'library' => 'fa-regular',
            ],
            'condition' => [
                'show_read_time' => 'yes',
                'show_read_time_icon' => 'yes',
            ],
        ]);

        $this->add_control('show_author_icon', [
            'label' => __('Show Author Icon', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
            'condition' => [
                'show_author' => 'yes',
            ],
        ]);

        $this->add_control('author_icon', [
            'label' => __('Author Icon', 'absl-ew'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'far fa-user',
                'library' => 'fa-regular',
            ],
            'condition' => [
                'show_author' => 'yes',
                'show_author_icon' => 'yes',
            ],
        ]);

        $this->add_control('show_excerpt', [
            'label' => __('Show Excerpt', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('excerpt_length', [
            'label' => __('Excerpt Length (words)', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 18,
            'min' => 5,
            'condition' => [
                'show_excerpt' => 'yes',
            ],
        ]);

        $this->add_control('excerpt_more_text', [
            'label' => __('Excerpt Suffix', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => '...',
            'condition' => [
                'show_excerpt' => 'yes',
            ],
        ]);

        $this->add_control('show_read_more', [
            'label' => __('Show Read More', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('read_more_text', [
            'label' => __('Read More Text', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Read Article', 'absl-ew'),
            'condition' => [
                'show_read_more' => 'yes',
            ],
        ]);

        $this->end_controls_section();

        /* ================= STYLE : TABS ================= */

        $this->start_controls_section('style_tabs', [
            'label' => __('Tabs', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('tabs_align', [
            'label' => __('Alignment', 'absl-ew'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => ['title' => 'Left', 'icon' => 'eicon-text-align-left'],
                'center' => ['title' => 'Center', 'icon' => 'eicon-text-align-center'],
                'flex-end' => ['title' => 'Right', 'icon' => 'eicon-text-align-right'],
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tabs-nav' => 'justify-content: {{VALUE}};',
            ],
        ]);

        $this->add_control('tabs_container_bg', [
            'label' => __('Container Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tabs-nav' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('tabs_container_padding', [
            'label' => __('Container Padding', 'absl-ew'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tabs-nav' =>
                'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'tabs_typo',
            'selector' => '{{WRAPPER}} .absl-blog-tab',
        ]);

        $this->add_responsive_control('tab_padding', [
            'label' => __('Padding', 'absl-ew'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tab' =>
                'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'tabs_container_border',
            'selector' => '{{WRAPPER}} .absl-blog-tabs-nav',
        ]);

        $this->add_responsive_control('tabs_container_radius', [
            'label' => __('Container Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tabs-nav' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('tab_text_color', [
            'label' => __('Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tab' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('tab_hover_text_color', [
            'label' => __('Hover Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tab:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('tab_active_text_color', [
            'label' => __('Active Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tab.active' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('tab_bg', [
            'label' => __('Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tab' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('tab_hover_bg', [
            'label' => __('Hover Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tab:hover' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('tab_active_bg', [
            'label' => __('Active Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tab.active' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('tab_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tab' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('tab_anim_speed', [
            'label' => __('Hover Animation Speed (ms)', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 200,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tabs' => '--absl-tab-transition: {{VALUE}}ms;',
            ],
        ]);

        $this->end_controls_section();

        /* ================= STYLE : CARDS ================= */

        $this->start_controls_section('style_cards', [
            'label' => __('Cards', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'card_bg',
            'selector' => '{{WRAPPER}} .absl-blog-card',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'card_border',
            'selector' => '{{WRAPPER}} .absl-blog-card',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'card_shadow',
            'selector' => '{{WRAPPER}} .absl-blog-card',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'card_border_hover',
            'selector' => '{{WRAPPER}} .absl-blog-card:hover',
        ]);

        $this->add_responsive_control('card_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-card' => 'border-radius: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-blog-thumb img' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0;',
            ],
        ]);

        $this->add_control('badge_position', [
            'label' => __('Badge Position', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'top-left',
            'options' => [
                'top-left' => __('Top Left', 'absl-ew'),
                'top-right' => __('Top Right', 'absl-ew'),
                'bottom-left' => __('Bottom Left', 'absl-ew'),
                'bottom-right' => __('Bottom Right', 'absl-ew'),
            ],
            'prefix_class' => 'absl-badge-pos-',
        ]);

        $this->add_responsive_control('badge_offset', [
            'label' => __('Badge Offset', 'absl-ew'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-badge' =>
                'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}}; bottom: {{BOTTOM}}{{UNIT}}; left: {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'title_typo',
            'selector' => '{{WRAPPER}} .absl-blog-title',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'meta_typo',
            'selector' => '{{WRAPPER}} .absl-blog-meta',
        ]);

        $this->add_responsive_control('meta_item_gap', [
            'label' => __('Meta Icon/Text Gap', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 0, 'max' => 32],
            ],
            'default' => [
                'size' => 8,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-blog-meta-item' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('title_color', [
            'label' => __('Title Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-title, {{WRAPPER}} .absl-blog-title a' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('meta_color', [
            'label' => __('Meta Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-meta' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('meta_icon_size', [
            'label' => __('Meta Icon Size', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => ['min' => 8, 'max' => 32],
            ],
            'default' => [
                'size' => 24,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-blog-tabs' => '--absl-meta-icon-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('excerpt_color', [
            'label' => __('Excerpt Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-excerpt' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('read_more_color', [
            'label' => __('Read More Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-readmore' => 'color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        /* ================= STYLE : PAGINATION ================= */

        $this->start_controls_section('style_pagination', [
            'label' => __('Pagination', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('pagination_align', [
            'label' => __('Alignment', 'absl-ew'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => ['title' => 'Left', 'icon' => 'eicon-text-align-left'],
                'center' => ['title' => 'Center', 'icon' => 'eicon-text-align-center'],
                'flex-end' => ['title' => 'Right', 'icon' => 'eicon-text-align-right'],
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-blog-pagination' => 'justify-content: {{VALUE}};',
            ],
        ]);

        $this->add_control('pagination_text', [
            'label' => __('Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-pagination button' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('pagination_active_text', [
            'label' => __('Active Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-pagination button.active' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('pagination_bg', [
            'label' => __('Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-pagination button' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('pagination_active_bg', [
            'label' => __('Active Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-blog-pagination button.active' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    private static function get_read_time_static($content, $wpm = 200) {
        $wpm = max(100, (int) $wpm);
        $words = str_word_count(wp_strip_all_tags($content));
        return max(1, (int) ceil($words / $wpm));
    }

    private static function build_card_html($post_id, $s) {
        $cats_slugs = wp_get_post_terms($post_id, 'category', ['fields' => 'slugs']);
        $cats_names = wp_get_post_terms($post_id, 'category', ['fields' => 'names']);
        $cats_str = ! empty($cats_slugs) ? implode(' ', $cats_slugs) : '';
        $primary_cat = ! empty($cats_names) ? $cats_names[0] : '';
        $thumb_url = get_the_post_thumbnail_url($post_id, 'large');
        if ( ! $thumb_url ) {
            $thumb_url = \Elementor\Utils::get_placeholder_image_src();
        }
        $content = get_post_field('post_content', $post_id);
        $read_time = self::get_read_time_static($content, (int) ($s['read_time_wpm'] ?? 200));
        $author_name = get_the_author_meta('display_name', (int) get_post_field('post_author', $post_id));

        $meta_icon_value = self::get_meta_icon_size_value($s);
        $meta_icon_var_style = self::get_meta_icon_var_style($meta_icon_value);
        $meta_icon_box_style = self::get_meta_icon_box_style($meta_icon_value);
        $date_icon = '';
        if ( ($s['show_date_icon'] ?? 'yes') === 'yes' && ! empty($s['date_icon']) && ! empty($s['date_icon']['value']) ) {
            ob_start();
            \Elementor\Icons_Manager::render_icon($s['date_icon'], ['aria-hidden' => 'true']);
            $date_icon = ob_get_clean();
            $date_icon = self::force_svg_icon_size($date_icon, $meta_icon_value);
            $date_icon = '<span class="absl-blog-meta-icon" style="' . esc_attr($meta_icon_box_style) . '">' . $date_icon . '</span>';
        }

        $read_time_icon = '';
        if ( ($s['show_read_time_icon'] ?? 'yes') === 'yes' && ! empty($s['read_time_icon']) && ! empty($s['read_time_icon']['value']) ) {
            ob_start();
            \Elementor\Icons_Manager::render_icon($s['read_time_icon'], ['aria-hidden' => 'true']);
            $read_time_icon = ob_get_clean();
            $read_time_icon = self::force_svg_icon_size($read_time_icon, $meta_icon_value);
            $read_time_icon = '<span class="absl-blog-meta-icon" style="' . esc_attr($meta_icon_box_style) . '">' . $read_time_icon . '</span>';
        }

        $author_icon = '';
        if ( ($s['show_author_icon'] ?? 'yes') === 'yes' && ! empty($s['author_icon']) && ! empty($s['author_icon']['value']) ) {
            ob_start();
            \Elementor\Icons_Manager::render_icon($s['author_icon'], ['aria-hidden' => 'true']);
            $author_icon = ob_get_clean();
            $author_icon = self::force_svg_icon_size($author_icon, $meta_icon_value);
            $author_icon = '<span class="absl-blog-meta-icon" style="' . esc_attr($meta_icon_box_style) . '">' . $author_icon . '</span>';
        }

        ob_start();
        ?>
        <article class="absl-blog-card" data-cats="<?php echo esc_attr($cats_str); ?>">
            <?php if ( ($s['show_thumbnail'] ?? 'yes') === 'yes' ) : ?>
                <div class="absl-blog-thumb">
                    <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>">
                    <?php if ( ($s['show_category_badge'] ?? 'yes') === 'yes' && ! empty($primary_cat) ) : ?>
                        <span class="absl-blog-badge"><?php echo esc_html($primary_cat); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="absl-blog-content">
                <?php if ( ($s['show_date'] ?? 'yes') === 'yes' || ($s['show_read_time'] ?? 'yes') === 'yes' || ($s['show_author'] ?? 'yes') === 'yes' ) : ?>
                    <div class="absl-blog-meta">
                        <?php if ( ($s['show_date'] ?? 'yes') === 'yes' ) : ?>
                            <span class="absl-blog-meta-item absl-meta-date" style="display:flex;align-items:center;justify-content:center;">
                                <?php echo $date_icon; ?>
                                <span class="absl-blog-meta-text"><?php echo esc_html(get_the_date('', $post_id)); ?></span>
                            </span>
                        <?php endif; ?>

                        <?php if ( ($s['show_author'] ?? 'yes') === 'yes' && ! empty($author_name) ) : ?>
                            <span class="absl-blog-meta-item absl-meta-author" style="display:flex;align-items:center;justify-content:center;">
                                <?php echo $author_icon; ?>
                                <span class="absl-blog-meta-text"><?php echo esc_html($author_name); ?></span>
                            </span>
                        <?php endif; ?>

                        <?php if ( ($s['show_read_time'] ?? 'yes') === 'yes' ) : ?>
                            <span class="absl-blog-meta-item absl-meta-readtime" style="display:flex;align-items:center;justify-content:center;">
                                <?php echo $read_time_icon; ?>
                                <span class="absl-blog-meta-text">
                                    <?php echo esc_html($read_time); ?>
                                    <?php esc_html_e('min read', 'absl-ew'); ?>
                                </span>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <h3 class="absl-blog-title">
                    <a href="<?php echo esc_url(get_permalink($post_id)); ?>">
                        <?php echo esc_html(get_the_title($post_id)); ?>
                    </a>
                </h3>

                <?php if ( ($s['show_excerpt'] ?? 'yes') === 'yes' ) : ?>
                    <div class="absl-blog-excerpt">
                        <?php
                            $more_text = $s['excerpt_more_text'] ?? '...';
                            echo esc_html(wp_trim_words(get_the_excerpt($post_id), (int) ($s['excerpt_length'] ?? 18), $more_text));
                        ?>
                    </div>
                <?php endif; ?>

                <?php if ( ($s['show_read_more'] ?? 'yes') === 'yes' ) : ?>
                    <a class="absl-blog-readmore" href="<?php echo esc_url(get_permalink($post_id)); ?>">
                        <?php echo esc_html($s['read_more_text'] ?? __('Read Article', 'absl-ew')); ?>
                        <span class="absl-blog-arrow">-></span>
                    </a>
                <?php endif; ?>
            </div>
        </article>
        <?php
        return ob_get_clean();
    }

    public static function ajax_search() {
        if ( ! check_ajax_referer('absl_blog_tabs', 'nonce', false) ) {
            wp_send_json_error(['message' => __('Invalid request.', 'absl-ew')]);
        }

        $category = sanitize_text_field($_POST['category'] ?? 'all');
        $page = max(1, (int) ($_POST['page'] ?? 1));
        $per_page = max(1, (int) ($_POST['per_page'] ?? 6));
        $max_posts = max(1, (int) ($_POST['max_posts'] ?? 24));

        $orderby = sanitize_text_field($_POST['orderby'] ?? 'date');
        $allowed_orderby = ['date', 'title', 'comment_count', 'rand'];
        if ( ! in_array($orderby, $allowed_orderby, true) ) {
            $orderby = 'date';
        }

        $order = strtoupper(sanitize_text_field($_POST['order'] ?? 'DESC'));
        $order = ($order === 'ASC') ? 'ASC' : 'DESC';

        $cat_ids = array_map('intval', (array) ($_POST['categories'] ?? []));

        $offset = ($page - 1) * $per_page;
        if ( $max_posts > 0 && $offset >= $max_posts ) {
            wp_send_json_success([
                'html' => '',
                'total_pages' => 0,
                'total_found' => 0,
            ]);
        }

        $query_args = [
            'post_type' => 'post',
            'posts_per_page' => $per_page,
            'orderby' => $orderby,
            'order' => $order,
            'ignore_sticky_posts' => true,
        ];

        if ( ! empty($cat_ids) ) {
            $query_args['category__in'] = $cat_ids;
        }

        if ( $category !== 'all' ) {
            $term = get_term_by('slug', $category, 'category');
            if ( $term ) {
                $query_args['cat'] = (int) $term->term_id;
            }
        }

        if ( $max_posts > 0 ) {
            $remaining = max(0, $max_posts - $offset);
            $query_args['posts_per_page'] = min($per_page, $remaining);
            $query_args['offset'] = $offset;
        }

        $query = new WP_Query($query_args);

        $total_found = (int) $query->found_posts;
        if ( $max_posts > 0 ) {
            $total_found = min($total_found, $max_posts);
        }

        $total_pages = ($per_page > 0) ? (int) ceil($total_found / $per_page) : 1;

        $parse_icon = function ($value) {
            if (is_array($value)) {
                return $value;
            }
            if (is_string($value) && $value !== '') {
                $decoded = json_decode(stripslashes($value), true);
                if (is_array($decoded)) {
                    return $decoded;
                }
            }
            return [];
        };

        $s = [
            'show_thumbnail' => sanitize_text_field($_POST['show_thumbnail'] ?? 'yes'),
            'show_category_badge' => sanitize_text_field($_POST['show_category_badge'] ?? 'yes'),
            'show_date' => sanitize_text_field($_POST['show_date'] ?? 'yes'),
            'show_read_time' => sanitize_text_field($_POST['show_read_time'] ?? 'yes'),
            'show_author' => sanitize_text_field($_POST['show_author'] ?? 'yes'),
            'read_time_wpm' => (int) ($_POST['read_time_wpm'] ?? 200),
            'show_date_icon' => sanitize_text_field($_POST['show_date_icon'] ?? 'yes'),
            'show_read_time_icon' => sanitize_text_field($_POST['show_read_time_icon'] ?? 'yes'),
            'show_author_icon' => sanitize_text_field($_POST['show_author_icon'] ?? 'yes'),
            'date_icon' => $parse_icon($_POST['date_icon'] ?? []),
            'read_time_icon' => $parse_icon($_POST['read_time_icon'] ?? []),
            'author_icon' => $parse_icon($_POST['author_icon'] ?? []),
            'show_excerpt' => sanitize_text_field($_POST['show_excerpt'] ?? 'yes'),
            'excerpt_length' => (int) ($_POST['excerpt_length'] ?? 18),
            'excerpt_more_text' => sanitize_text_field($_POST['excerpt_more_text'] ?? '...'),
            'show_read_more' => sanitize_text_field($_POST['show_read_more'] ?? 'yes'),
            'read_more_text' => sanitize_text_field($_POST['read_more_text'] ?? __('Read Article', 'absl-ew')),
        ];
        $meta_size = (float) ($_POST['meta_icon_size'] ?? 24);
        $meta_unit = sanitize_text_field($_POST['meta_icon_unit'] ?? 'px');
        $s['meta_icon_size'] = ['size' => $meta_size, 'unit' => $meta_unit];

        $html = '';
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $html .= self::build_card_html(get_the_ID(), $s);
            }
            wp_reset_postdata();
        }

        wp_send_json_success([
            'html' => $html,
            'total_pages' => $total_pages,
            'total_found' => $total_found,
        ]);
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $cats = ! empty($s['categories']) ? array_map('intval', $s['categories']) : [];
        $max_posts = ! empty($s['max_posts']) ? (int) $s['max_posts'] : 24;
        $per_page = ! empty($s['posts_per_page']) ? (int) $s['posts_per_page'] : 6;
        $orderby = $s['orderby'] ?? 'date';
        $order = $s['order'] ?? 'DESC';

        $query_args = [
            'post_type' => 'post',
            'posts_per_page' => $max_posts,
            'orderby' => $orderby,
            'order' => $order,
            'ignore_sticky_posts' => true,
        ];

        if ( ! empty($cats) ) {
            $query_args['category__in'] = $cats;
        }

        $query = new WP_Query($query_args);

        if ( ! $query->have_posts() ) {
            echo '<div class="absl-blog-empty">' . esc_html__('No posts found.', 'absl-ew') . '</div>';
            return;
        }

        $tab_terms = [];
        if ( ! empty($cats) ) {
            $tab_terms = get_terms([
                'taxonomy' => 'category',
                'include' => $cats,
                'hide_empty' => true,
            ]);
        } else {
            $tab_terms = get_terms([
                'taxonomy' => 'category',
                'hide_empty' => true,
            ]);
        }

        $default_filter = 'all';
        if ( $s['show_all_tab'] !== 'yes' && ! empty($tab_terms) ) {
            $first = $tab_terms[0];
            $default_filter = $first->slug;
        }

        $wrapper_class = 'absl-blog-tabs absl-' . esc_attr($s['card_style']);
        $meta_icon_value = self::get_meta_icon_size_value($s);
        $meta_icon_var_style = self::get_meta_icon_var_style($meta_icon_value);
        $nonce = wp_create_nonce('absl_blog_tabs');
        ?>

        <div class="<?php echo esc_attr($wrapper_class); ?>"
             style="<?php echo esc_attr($meta_icon_var_style); ?>"
             data-per-page="<?php echo esc_attr($per_page); ?>"
             data-max-posts="<?php echo esc_attr($max_posts); ?>"
             data-pagination="<?php echo esc_attr($s['enable_pagination']); ?>"
             data-default-tab="<?php echo esc_attr($default_filter); ?>"
             data-ajax="yes"
             data-ajax-nonce="<?php echo esc_attr($nonce); ?>"
             data-orderby="<?php echo esc_attr($orderby); ?>"
             data-order="<?php echo esc_attr($order); ?>"
             data-categories="<?php echo esc_attr(wp_json_encode($cats)); ?>"
             data-show-thumbnail="<?php echo esc_attr($s['show_thumbnail']); ?>"
             data-show-category-badge="<?php echo esc_attr($s['show_category_badge']); ?>"
             data-show-date="<?php echo esc_attr($s['show_date']); ?>"
             data-show-read-time="<?php echo esc_attr($s['show_read_time']); ?>"
             data-show-author="<?php echo esc_attr($s['show_author']); ?>"
             data-read-time-wpm="<?php echo esc_attr($s['read_time_wpm']); ?>"
             data-meta-icon-size="<?php echo esc_attr($s['meta_icon_size']['size'] ?? 24); ?>"
             data-meta-icon-unit="<?php echo esc_attr($s['meta_icon_size']['unit'] ?? 'px'); ?>"
             data-show-date-icon="<?php echo esc_attr($s['show_date_icon']); ?>"
             data-show-read-time-icon="<?php echo esc_attr($s['show_read_time_icon']); ?>"
             data-show-author-icon="<?php echo esc_attr($s['show_author_icon']); ?>"
             data-date-icon="<?php echo esc_attr(wp_json_encode($s['date_icon'] ?? [])); ?>"
             data-read-time-icon="<?php echo esc_attr(wp_json_encode($s['read_time_icon'] ?? [])); ?>"
             data-author-icon="<?php echo esc_attr(wp_json_encode($s['author_icon'] ?? [])); ?>"
             data-show-excerpt="<?php echo esc_attr($s['show_excerpt']); ?>"
             data-excerpt-length="<?php echo esc_attr($s['excerpt_length']); ?>"
             data-excerpt-more-text="<?php echo esc_attr($s['excerpt_more_text'] ?? '...'); ?>"
             data-show-read-more="<?php echo esc_attr($s['show_read_more']); ?>"
             data-read-more-text="<?php echo esc_attr($s['read_more_text']); ?>"
             data-empty-text="<?php echo esc_attr__('No posts found.', 'absl-ew'); ?>">

            <div class="absl-blog-tabs-nav" role="tablist">
                <?php if ( $s['show_all_tab'] === 'yes' ) : ?>
                    <button class="absl-blog-tab active" data-filter="all" type="button">
                        <?php echo esc_html($s['all_tab_label']); ?>
                        <span class="absl-blog-count">(<?php echo (int) $query->found_posts; ?>)</span>
                    </button>
                <?php endif; ?>

                <?php if ( ! empty($tab_terms) && ! is_wp_error($tab_terms) ) : ?>
                    <?php foreach ($tab_terms as $term) : ?>
                        <?php
                            $is_active = ($default_filter === $term->slug && $s['show_all_tab'] !== 'yes') ? ' active' : '';
                        ?>
                        <button class="absl-blog-tab<?php echo esc_attr($is_active); ?>" data-filter="<?php echo esc_attr($term->slug); ?>" type="button">
                            <?php echo esc_html($term->name); ?>
                            <span class="absl-blog-count">(<?php echo (int) $term->count; ?>)</span>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="absl-blog-grid" role="tabpanel">
                <?php
                while ( $query->have_posts() ) :
                    $query->the_post();
                    echo self::build_card_html(get_the_ID(), $s);
                endwhile; wp_reset_postdata(); ?>
            </div>

            <div class="absl-blog-pagination" aria-label="<?php esc_attr_e('Pagination', 'absl-ew'); ?>"></div>
        </div>
        <?php
    }

    private static function get_meta_icon_size_value($s) {
        $size = 24;
        $unit = 'px';
        if (!empty($s['meta_icon_size']) && is_array($s['meta_icon_size'])) {
            if (!empty($s['meta_icon_size']['size'])) {
                $size = (float) $s['meta_icon_size']['size'];
            }
            if (!empty($s['meta_icon_size']['unit'])) {
                $unit = $s['meta_icon_size']['unit'];
            }
        }
        if (!empty($s['meta_icon_size_size'])) {
            $size = (float) $s['meta_icon_size_size'];
        }
        if (!empty($s['meta_icon_size_unit'])) {
            $unit = $s['meta_icon_size_unit'];
        }
        return $size . $unit;
    }

    private static function get_meta_icon_var_style($value) {
        return '--absl-meta-icon-size:' . $value . ';';
    }

    private static function get_meta_icon_box_style($value) {
        return '--absl-meta-icon-size:' . $value . ';' .
            'width:' . $value . ';height:' . $value . ';' .
            'max-width:' . $value . ';max-height:' . $value . ';' .
            'font-size:' . $value . ';';
    }

    private static function force_svg_icon_size($html, $value) {
        if (stripos($html, '<svg') === false) {
            return $html;
        }

        $html = preg_replace('/\\s(width|height)=([\"\\\'])[^\\"\\\']*\\2/i', '', $html);
        $html = preg_replace_callback('/<svg\\b([^>]*)>/i', function ($matches) use ($value) {
            $attrs = $matches[1];

            if (preg_match('/\\sstyle=\"([^\"]*)\"/i', $attrs, $style_match)) {
                $style = rtrim($style_match[1], ';') . ';width:' . $value . ';height:' . $value . ';';
                $attrs = preg_replace('/\\sstyle=\"([^\"]*)\"/i', ' style="' . $style . '"', $attrs);
            } else {
                $attrs .= ' style="width:' . $value . ';height:' . $value . ';"';
            }

            return '<svg' . $attrs . ' width="' . $value . '" height="' . $value . '">';
        }, $html, 1);

        return $html;
    }
}

add_action('wp_ajax_absl_blog_tabs_search', ['ABSL_Blog_Tabs_Widget', 'ajax_search']);
add_action('wp_ajax_nopriv_absl_blog_tabs_search', ['ABSL_Blog_Tabs_Widget', 'ajax_search']);
