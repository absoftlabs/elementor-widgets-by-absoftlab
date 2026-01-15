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

class ABSL_Accordion_Widget extends Widget_Base {
    public function get_name() { return 'absl_accordion'; }
    public function get_title() { return __( 'Accordion', 'absl-ew' ); }
    public function get_icon() { return 'eicon-accordion'; }
    public function get_categories() { return [ 'absoftlab' ]; }
    public function get_style_depends() { return [ 'absl-accordion' ]; }
    public function get_script_depends() { return [ 'absl-accordion' ]; }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Items', 'absl-ew' ),
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'title',
            [
                'label' => __( 'Question', 'absl-ew' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Is this course beginner friendly?', 'absl-ew' ),
            ]
        );
        $repeater->add_control(
            'content',
            [
                'label' => __( 'Answer', 'absl-ew' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Absolutely! This course is designed for complete beginners with no prior video editing experience. We start from the very basics and progressively build your skills. By the end, you\'ll be editing like a pro.', 'absl-ew' ),
                'rows' => 4,
            ]
        );
        $repeater->add_control(
            'open_by_default',
            [
                'label' => __( 'Open by Default', 'absl-ew' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => __( 'Accordion Items', 'absl-ew' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __( 'Is this course beginner friendly?', 'absl-ew' ),
                        'content' => __( 'Absolutely! This course is designed for complete beginners with no prior video editing experience. We start from the very basics and progressively build your skills. By the end, you\'ll be editing like a pro.', 'absl-ew' ),
                        'open_by_default' => 'yes',
                    ],
                    [
                        'title' => __( 'What software is required?', 'absl-ew' ),
                        'content' => __( 'You can follow along with any modern video editing tool. We include examples using popular editors and explain concepts that apply universally.', 'absl-ew' ),
                        'open_by_default' => '',
                    ],
                    [
                        'title' => __( 'Do I get lifetime access?', 'absl-ew' ),
                        'content' => __( 'Yes. Once enrolled, you can access all lessons and updates at any time.', 'absl-ew' ),
                        'open_by_default' => '',
                    ],
                    [
                        'title' => __( 'What\'s the refund policy?', 'absl-ew' ),
                        'content' => __( 'We offer a 14-day refund window if the course isn\'t the right fit for you.', 'absl-ew' ),
                        'open_by_default' => '',
                    ],
                    [
                        'title' => __( 'How long do I have to complete the course?', 'absl-ew' ),
                        'content' => __( 'There is no deadline. Learn at your own pace and revisit lessons anytime.', 'absl-ew' ),
                        'open_by_default' => '',
                    ],
                    [
                        'title' => __( 'Will I get a certificate?', 'absl-ew' ),
                        'content' => __( 'Yes. You\'ll receive a certificate of completion after finishing all lessons.', 'absl-ew' ),
                        'open_by_default' => '',
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_control(
            'allow_multiple',
            [
                'label' => __( 'Allow Multiple Open', 'absl-ew' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'toggle_icon',
            [
                'label' => __( 'Toggle Icon', 'absl-ew' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-down',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_wrapper',
            [
                'label' => __( 'Wrapper', 'absl-ew' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'wrapper_gap',
            [
                'label' => __( 'Item Gap', 'absl-ew' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
                'selectors' => [
                    '{{WRAPPER}} .absl-accordion' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_item',
            [
                'label' => __( 'Item', 'absl-ew' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_bg',
                'selector' => '{{WRAPPER}} .absl-accordion-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .absl-accordion-item',
            ]
        );

        $this->add_control(
            'item_border_active',
            [
                'label' => __( 'Active Border Color', 'absl-ew' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-accordion' => '--absl-accordion-border-active: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow',
                'selector' => '{{WRAPPER}} .absl-accordion-item',
            ]
        );

        $this->add_responsive_control(
            'item_radius',
            [
                'label' => __( 'Border Radius', 'absl-ew' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 40 ],
                    '%' => [ 'min' => 0, 'max' => 50 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .absl-accordion-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'header_padding',
            [
                'label' => __( 'Header Padding', 'absl-ew' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .absl-accordion-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __( 'Content Padding', 'absl-ew' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .absl-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_title',
            [
                'label' => __( 'Title', 'absl-ew' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'absl-ew' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .absl-accordion-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_content',
            [
                'label' => __( 'Content', 'absl-ew' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => __( 'Color', 'absl-ew' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-accordion-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typo',
                'selector' => '{{WRAPPER}} .absl-accordion-content',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_toggle',
            [
                'label' => __( 'Toggle Icon', 'absl-ew' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'toggle_color',
            [
                'label' => __( 'Color', 'absl-ew' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-accordion-toggle' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'toggle_bg',
            [
                'label' => __( 'Background', 'absl-ew' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-accordion-toggle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'toggle_size',
            [
                'label' => __( 'Size', 'absl-ew' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [ 'px' => [ 'min' => 12, 'max' => 48 ] ],
                'selectors' => [
                    '{{WRAPPER}} .absl-accordion-toggle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .absl-accordion-toggle i, {{WRAPPER}} .absl-accordion-toggle svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'toggle_radius',
            [
                'label' => __( 'Border Radius', 'absl-ew' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 30 ],
                    '%' => [ 'min' => 0, 'max' => 50 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .absl-accordion-toggle' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $items = ! empty( $s['items'] ) && is_array( $s['items'] ) ? $s['items'] : [];
        if ( empty( $items ) ) {
            return;
        }
        $allow_multiple = ( ! empty( $s['allow_multiple'] ) && 'yes' === $s['allow_multiple'] ) ? 'yes' : 'no';
        ?>
        <div class="absl-accordion" data-allow-multiple="<?php echo esc_attr( $allow_multiple ); ?>">
            <?php foreach ( $items as $item ) :
                $title = $item['title'] ?? '';
                $content = $item['content'] ?? '';
                $is_open = ! empty( $item['open_by_default'] ) && 'yes' === $item['open_by_default'];
                ?>
                <div class="absl-accordion-item<?php echo $is_open ? ' is-open' : ''; ?>">
                    <div class="absl-accordion-header" role="button" tabindex="0" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>">
                        <div class="absl-accordion-title"><?php echo esc_html( $title ); ?></div>
                        <div class="absl-accordion-toggle">
                            <?php if ( ! empty( $s['toggle_icon']['value'] ) ) { Icons_Manager::render_icon( $s['toggle_icon'], [ 'aria-hidden' => 'true' ] ); } ?>
                        </div>
                    </div>
                    <div class="absl-accordion-body">
                        <div class="absl-accordion-content"><?php echo esc_html( $content ); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}

