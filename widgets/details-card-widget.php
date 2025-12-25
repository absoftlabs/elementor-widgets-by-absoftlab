<?php
    if (! defined('ABSPATH')) {
        exit;
    }

    use Elementor\Controls_Manager;
    use Elementor\Group_Control_Background;
    use Elementor\Group_Control_Border;
    use Elementor\Group_Control_Box_Shadow;
    use Elementor\Group_Control_Typography;
    use Elementor\Repeater;
    use Elementor\Widget_Base;

    class ABSL_Details_Card_Widget extends Widget_Base
    {

        public function get_name()
        {
            return 'absl_details_card';
        }

        public function get_title()
        {
            return __('Details Card', 'absl-ew');
        }

        public function get_icon()
        {
            return 'eicon-post-list';
        }

        public function get_categories()
        {
            return ['absoftlab'];
        }

        public function get_style_depends()
        {
            return ['absl-details-card'];
        }

        /* ================= CONTENT ================= */
        protected function register_controls()
        {

            /* Top Image */
            $this->start_controls_section('section_image', [
                'label' => __('Top Image', 'absl-ew'),
            ]);

            $this->add_control('image', [
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]);

            $this->end_controls_section();

            /* Details */
            $this->start_controls_section('section_details', [
                'label' => __('Details', 'absl-ew'),
            ]);

            $repeater = new Repeater();

            $repeater->add_control('label', [
                'label'   => __('Heading', 'absl-ew'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Product Size', 'absl-ew'),
            ]);

            $repeater->add_control('value', [
                'label'   => __('Description', 'absl-ew'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('3" x 63"', 'absl-ew'),
            ]);

            $this->add_control('items', [
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ label }}}',
            ]);

            $this->end_controls_section();

            /* ================= STYLE ================= */

            /* Card */
            $this->start_controls_section('style_card', [
                'label' => __('Card', 'absl-ew'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]);

            $this->add_group_control(Group_Control_Background::get_type(), [
                'name'     => 'card_bg',
                'selector' => '{{WRAPPER}} .absl-details-card',
            ]);

            $this->add_responsive_control('card_padding', [
                'label'     => __('Padding', 'absl-ew'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .absl-details-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]);

            $this->add_group_control(Group_Control_Border::get_type(), [
                'name'     => 'card_border',
                'selector' => '{{WRAPPER}} .absl-details-card',
            ]);

            $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
                'name'     => 'card_shadow',
                'selector' => '{{WRAPPER}} .absl-details-card',
            ]);

            $this->end_controls_section();

            /* Rows – Responsive */
            $this->start_controls_section('style_rows', [
                'label' => __('Rows (Responsive)', 'absl-ew'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]);

            $this->add_responsive_control('row_gap', [
                'label'     => __('Row Gap', 'absl-ew'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => ['min' => 0, 'max' => 40],
                ],
                'selectors' => [
                    '{{WRAPPER}} .absl-row' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]);

            $this->add_control('stack_mobile', [
                'label'        => __('Stack on Mobile', 'absl-ew'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            ]);

            $this->end_controls_section();

            /* Left Heading */
            $this->start_controls_section('style_label', [
                'label' => __('Left Heading', 'absl-ew'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]);

            $this->add_control('label_color', [
                'label'     => __('Color', 'absl-ew'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-label' => 'color: {{VALUE}};',
                ],
            ]);

            $this->add_group_control(Group_Control_Typography::get_type(), [
                'name'     => 'label_typo',
                'selector' => '{{WRAPPER}} .absl-label',
            ]);

            $this->add_responsive_control('label_width', [
                'label'     => __('Width (%)', 'absl-ew'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    '%' => ['min' => 20, 'max' => 50],
                ],
                'selectors' => [
                    '{{WRAPPER}} .absl-label' => 'flex: 0 0 {{SIZE}}%;',
                ],
            ]);

            $this->end_controls_section();

            /* Right Description */
            $this->start_controls_section('style_value', [
                'label' => __('Right Description', 'absl-ew'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]);

            $this->add_control('value_color', [
                'label'     => __('Color', 'absl-ew'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absl-value' => 'color: {{VALUE}};',
                ],
            ]);

            $this->add_group_control(Group_Control_Typography::get_type(), [
                'name'     => 'value_typo',
                'selector' => '{{WRAPPER}} .absl-value',
            ]);

            $this->end_controls_section();
        }

        /* ================= RENDER ================= */
        protected function render()
        {
            $s = $this->get_settings_for_display();
        ?>
        <div class="absl-details-card">

            <?php if (! empty($s['image']['url'])): ?>
                <img src="<?php echo esc_url($s['image']['url']); ?>" alt="">
            <?php endif; ?>

            <?php foreach ($s['items'] as $item): ?>
                <div class="absl-row">
                    <div class="absl-label"><?php echo esc_html($item['label']); ?></div>
                    <div class="absl-value"><?php echo esc_html($item['value']); ?></div>
                </div>
            <?php endforeach; ?>

        </div>
        <?php
            }
        }
