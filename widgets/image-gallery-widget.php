<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

class ABSL_Image_Gallery_Widget extends Widget_Base {

    public function get_name() { return 'absl_image_gallery'; }
    public function get_title() { return __( 'Image Gallery', 'absl-ew' ); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return [ 'absoftlab' ]; }

    public function get_style_depends() { return [ 'absl-image-gallery' ]; }
    public function get_script_depends() { return [ 'absl-image-gallery' ]; }

    protected function register_controls() {

        /* ================= CONTENT ================= */

        $this->start_controls_section('section_items', [
            'label' => __('Gallery Items', 'absl-ew'),
        ]);

        $repeater = new Repeater();

        $repeater->add_control('image', [
            'type' => Controls_Manager::MEDIA,
            'default' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
        ]);

        $repeater->add_control('title', [
            'label' => __('Title', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
        ]);

        $repeater->add_control('category', [
            'label' => __('Category', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => 'Nature',
        ]);

        $repeater->add_control('image_link', [
            'label' => __('Image Link', 'absl-ew'),
            'type' => Controls_Manager::URL,
            'options' => ['url','is_external','nofollow'],
        ]);

        $this->add_control('items', [
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ title }}}',
        ]);

        $this->end_controls_section();

        /* ================= SETTINGS ================= */

        $this->start_controls_section('section_settings', [
            'label' => __('Settings', 'absl-ew'),
        ]);

        $this->add_control('layout', [
            'label' => __('Layout', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'grid',
            'options' => [
                'grid' => 'Grid',
                'masonry' => 'Masonry',
            ],
        ]);

        $this->add_control('enable_lightbox', [
            'label' => __('Enable Lightbox', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('items_per_page', [
            'label' => __('Items Per Load', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 6,
        ]);

        $this->add_control('load_mode', [
            'label' => __('Image Load Mode', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'load_more',
            'options' => [
                'load_more' => __('Load More Button', 'absl-ew'),
                'infinite'  => __('Infinite Scroll', 'absl-ew'),
            ],
        ]);

        $this->end_controls_section();

        /* ================= STYLE : FILTER TABS ================= */

        $this->start_controls_section('style_tabs', [
            'label' => __('Filter Tabs', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('tabs_align', [
            'label' => __('Alignment', 'absl-ew'),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => ['title'=>'Left','icon'=>'eicon-text-align-left'],
                'center'     => ['title'=>'Center','icon'=>'eicon-text-align-center'],
                'flex-end'   => ['title'=>'Right','icon'=>'eicon-text-align-right'],
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-filter' => 'justify-content: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'tab_typo',
            'selector' => '{{WRAPPER}} .absl-filter button',
        ]);

        $this->add_control('tab_color', [
            'label' => __('Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-filter button' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('tab_active_color', [
            'label' => __('Active Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-filter button.active' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'tab_bg',
            'selector' => '{{WRAPPER}} .absl-filter button',
        ]);

        $this->add_control('tab_active_bg', [
            'label' => __('Active Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-filter button.active' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('tab_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .absl-filter button' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        /* 🔹 Underline controls (RESTORED) */
        $this->add_control('tab_underline', [
            'label' => __('Underline', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('tab_underline_color', [
            'label' => __('Underline Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'default' => '#111827',
            'condition' => ['tab_underline' => 'yes'],
        ]);

        $this->add_control('tab_underline_height', [
            'label' => __('Underline Thickness (px)', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 2,
            'condition' => ['tab_underline' => 'yes'],
        ]);

        $this->add_control('tab_switch_anim', [
            'label' => __('Tab Switch Animation', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'fade',
            'options' => [
                'fade'  => 'Fade',
                'scale' => 'Scale',
                'slide' => 'Slide Up',
            ],
        ]);

        $this->add_control('tab_anim_speed', [
            'label' => __('Animation Speed (ms)', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 300,
        ]);

        $this->end_controls_section();

        /* ================= STYLE : IMAGE ================= */

        $this->start_controls_section('style_image', [
            'label' => __('Image', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        /* 🔹 Hover animation controls (RESTORED) */
        $this->add_control('hover_anim', [
            'label' => __('Hover Animation', 'absl-ew'),
            'type' => Controls_Manager::SELECT,
            'default' => 'lift',
            'options' => [
                'none'        => 'None',
                'lift'        => 'Lift',
                'zoom'        => 'Zoom',
                'zoom-rotate' => 'Zoom + Rotate',
            ],
        ]);

        $this->add_control('hover_speed', [
            'label' => __('Hover Speed (ms)', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 300,
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'image_border',
            'selector' => '{{WRAPPER}} .absl-gallery-item',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'image_shadow',
            'selector' => '{{WRAPPER}} .absl-gallery-item',
        ]);

        $this->add_responsive_control('image_radius', [
            'label' => __('Image Border Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => ['min' => 0, 'max' => 100],
                '%'  => ['min' => 0, 'max' => 50],
            ],
            'default' => ['size' => 0, 'unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-gallery-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-gallery-item img' => 'border-radius: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-gallery-item .absl-overlay' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        /* ================= STYLE : LOAD MORE ================= */

        $this->start_controls_section('style_load_more', [
            'label' => __('Load More Button', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->start_controls_tabs('lm_tabs');

        $this->start_controls_tab('lm_tab_normal', [
            'label' => __('Normal', 'absl-ew'),
        ]);

        $this->add_control('lm_text', [
            'label' => __('Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-load-more' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('lm_bg', [
            'label' => __('Background Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-load-more' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('lm_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .absl-load-more' =>
                'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('lm_tab_hover', [
            'label' => __('Hover', 'absl-ew'),
        ]);

        $this->add_control('lm_hover_text', [
            'label' => __('Hover Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-load-more:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('lm_hover_bg', [
            'label' => __('Hover Background Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-load-more:hover' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_responsive_control('lm_hover_radius', [
            'label' => __('Hover Border Radius', 'absl-ew'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} .absl-load-more:hover' =>
                'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        if ( empty($s['items']) ) return;

        $per = (int) $s['items_per_page'];
        $lightbox = ( $s['enable_lightbox'] === 'yes' ) ? 'yes' : 'no';
        $load_mode = $s['load_mode'] ?? 'load_more';
        $gallery_id = 'absl-gallery-' . $this->get_id();
        $mode_cls = ($load_mode === 'infinite') ? ' absl-load-infinite' : '';

        $cat_counts = [];
        foreach ($s['items'] as $it) {
            $c = sanitize_title($it['category']);
            $cat_counts[$c] = ($cat_counts[$c] ?? 0) + 1;
        }
        ?>

        <div class="absl-image-gallery<?php echo esc_attr($mode_cls); ?>"
             data-per-page="<?php echo esc_attr($per); ?>"
             data-load-mode="<?php echo esc_attr($load_mode); ?>"
             data-hover="<?php echo esc_attr($s['hover_anim']); ?>"
             data-hover-speed="<?php echo esc_attr($s['hover_speed']); ?>"
             data-ul="<?php echo esc_attr($s['tab_underline']); ?>"
             data-ul-color="<?php echo esc_attr($s['tab_underline_color']); ?>"
             data-ul-height="<?php echo esc_attr($s['tab_underline_height']); ?>">

            <div class="absl-filter">
                <button class="active" data-filter="*">
                    <?php esc_html_e('All','absl-ew'); ?>
                    <span class="absl-count"><?php echo count($s['items']); ?></span>
                </button>
                <?php foreach ($cat_counts as $cat => $count): ?>
                    <button data-filter="<?php echo esc_attr($cat); ?>">
                        <?php echo esc_html(ucfirst($cat)); ?>
                        <span class="absl-count"><?php echo esc_html($count); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="absl-gallery-grid layout-<?php echo esc_attr($s['layout']); ?>">
                <?php foreach ($s['items'] as $item):
                    $cat = sanitize_title($item['category']);
                ?>
                <div class="absl-gallery-item" data-category="<?php echo esc_attr($cat); ?>">
                    <a href="<?php echo esc_url($item['image']['url']); ?>"
                       data-elementor-open-lightbox="<?php echo esc_attr($lightbox); ?>"
                       <?php if ( $lightbox === 'yes' ) : ?>
                       data-elementor-lightbox-type="image"
                       data-elementor-lightbox-slideshow="<?php echo esc_attr($gallery_id); ?>"
                       <?php if ( !empty($item['title']) ) : ?>
                       data-elementor-lightbox-title="<?php echo esc_attr($item['title']); ?>"
                       <?php endif; ?>
                       <?php endif; ?>>
                        <img src="<?php echo esc_url($item['image']['url']); ?>" alt="">
                        <?php if ($item['title']): ?>
                            <div class="absl-overlay"><span><?php echo esc_html($item['title']); ?></span></div>
                        <?php endif; ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>

            <button class="absl-load-more"><?php esc_html_e('Load More','absl-ew'); ?></button>
            <div class="absl-load-sentinel" aria-hidden="true"></div>

        </div>
        <?php
    }
}
