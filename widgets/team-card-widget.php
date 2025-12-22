<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

class ABSL_Team_Card_Widget extends Widget_Base {
    public function get_name() { return 'absl_team_card'; }
    public function get_title() { return __('Team Card', 'absl-ew'); }
    public function get_icon() { return 'eicon-person'; }
    public function get_categories() { return ['absoftlab']; }

    protected function register_controls() {

        /* -----------------------
         * CONTENT
         * ---------------------*/
        $this->start_controls_section('content_section', [
            'label' => __('Content', 'absl-ew')
        ]);

        $this->add_control('preset', [
            'label'   => __('Card Preset', 'absl-ew'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'centered_circle',
            'options' => [
                'centered_circle' => __('Centered Circle (Default)', 'absl-ew'),
                'left_compact'    => __('Left Compact', 'absl-ew'),
                'overlay_hover'   => __('Overlay Hover', 'absl-ew'),
                'bordered_header' => __('Bordered Header', 'absl-ew'),
                'minimal'         => __('Minimal', 'absl-ew'),
            ],
            'description' => __('Choose a modern preset layout style.', 'absl-ew'),
        ]);

        $this->add_control('photo', [
            'label'   => __('Photo', 'absl-ew'),
            'type'    => Controls_Manager::MEDIA,
            'default' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
        ]);

        $this->add_control('name', [
            'label'   => __('Name', 'absl-ew'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('John Doe', 'absl-ew'),
            'label_block' => true,
        ]);

        $this->add_control('designation', [
            'label'   => __('Designation', 'absl-ew'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('Senior Developer', 'absl-ew'),
            'label_block' => true,
        ]);

        $this->add_control('description', [
            'label'   => __('Description', 'absl-ew'),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __('Passionate about building delightful user experiences and scalable systems.', 'absl-ew'),
        ]);

        // Social Links
        $rep = new Repeater();
        $rep->add_control('icon', [
            'label' => __('Icon', 'absl-ew'),
            'type'  => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fab fa-facebook-f',
                'library' => 'fa-brands',
            ],
        ]);
        $rep->add_control('url', [
            'label'       => __('URL', 'absl-ew'),
            'type'        => Controls_Manager::URL,
            'placeholder' => __('https://facebook.com/username', 'absl-ew'),
            'options'     => ['url','is_external','nofollow'],
        ]);
        $rep->add_control('aria_label', [
            'label' => __('Accessible Label (optional)', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'placeholder' => __('Facebook profile', 'absl-ew'),
        ]);

        $this->add_control('social_links', [
            'label'       => __('Social Icons', 'absl-ew'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $rep->get_controls(),
            'default'     => [
                ['icon' => ['value'=>'fab fa-facebook-f','library'=>'fa-brands']],
                ['icon' => ['value'=>'fab fa-x-twitter','library'=>'fa-brands']],
                ['icon' => ['value'=>'fab fa-linkedin-in','library'=>'fa-brands']],
            ],
            'title_field' => '{{{ aria_label || url.url || "Social" }}}',
        ]);

        // Link whole card (optional)
        $this->add_control('profile_link', [
            'label'       => __('Profile Link (optional)', 'absl-ew'),
            'type'        => Controls_Manager::URL,
            'placeholder' => __('https://example.com/member', 'absl-ew'),
            'options'     => ['url','is_external','nofollow'],
            'separator'   => 'before',
        ]);

        $this->end_controls_section();

        /* -----------------------
         * LAYOUT & ALIGNMENT
         * ---------------------*/
        $this->start_controls_section('layout_section', [
            'label' => __('Layout & Alignment', 'absl-ew')
        ]);

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
                '{{WRAPPER}} .absl-team-card' => 'text-align: {{VALUE}};',
                '{{WRAPPER}} .absl-team-card .desc' => 'text-align: {{VALUE}};',
                '{{WRAPPER}} .absl-team-card .meta' => 'justify-content: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('equal_height', [
            'label' => __('Equal Height', 'absl-ew'),
            'type'  => Controls_Manager::SWITCHER,
            'label_on' => __('On', 'absl-ew'),
            'label_off'=> __('Off', 'absl-ew'),
            'return_value' => 'yes',
            'default' => 'yes',
            'selectors' => [
                '{{WRAPPER}}' => 'height:100%;',
                '{{WRAPPER}} .elementor-widget-container' => 'height:100%; display:flex;',
                '{{WRAPPER}} .elementor-widget-container > .absl-team-card' => 'height:100%; flex:1 1 auto;',
            ],
        ]);

        // Gaps between items
        $this->add_responsive_control('stack_gap', [
            'label' => __('Stack Gap', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','em'],
            'range' => ['px'=>['min'=>0,'max'=>60],'em'=>['min'=>0,'max'=>6]],
            'default' => ['size'=>10,'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-team-card .name'        => 'margin-top: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-team-card .designation' => 'margin-top: calc({{SIZE}}{{UNIT}} / 2);',
                '{{WRAPPER}} .absl-team-card .desc'        => 'margin-top: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-team-card .socials'     => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        /* -----------------------
         * STYLE: CARD
         * ---------------------*/
        $this->start_controls_section('card_style', [
            'label' => __('Card', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'card_bg',
            'label'    => __('Background (Normal)', 'absl-ew'),
            'selector' => '{{WRAPPER}} .absl-team-card',
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'card_bg_hover',
            'label'    => __('Background (Hover)', 'absl-ew'),
            'selector' => '{{WRAPPER}} .absl-team-card:hover',
        ]);
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'card_border',
            'selector' => '{{WRAPPER}} .absl-team-card',
        ]);
        $this->add_responsive_control('card_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','%'],
            'selectors' => [
                '{{WRAPPER}} .absl-team-card' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_shadow',
            'selector' => '{{WRAPPER}} .absl-team-card',
        ]);
        $this->add_responsive_control('card_padding', [
            'label' => __('Padding', 'absl-ew'),
            'type'  => Controls_Manager::DIMENSIONS,
            'size_units' => ['px','em','%'],
            'default' => [ 'top'=>20,'right'=>20,'bottom'=>20,'left'=>20, 'unit'=>'px' ], // default 20px padding
            'selectors' => [
                '{{WRAPPER}} .absl-team-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('card_margin', [
            'label' => __('Margin', 'absl-ew'),
            'type'  => Controls_Manager::DIMENSIONS,
            'size_units' => ['px','em','%'],
            'selectors' => [
                '{{WRAPPER}} .absl-team-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        /* -----------------------
         * STYLE: PHOTO
         * ---------------------*/
        $this->start_controls_section('photo_style', [
            'label' => __('Photo', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        // Avatar size (square box; inside image object-fit: cover)
        $this->add_responsive_control('photo_size', [
            'label' => __('Size', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px'=>['min'=>40,'max'=>300]],
            'default' => ['size'=>120,'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-team-card .avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Shape presets
        $this->add_control('photo_shape', [
            'label' => __('Shape', 'absl-ew'),
            'type'  => Controls_Manager::SELECT,
            'default' => 'circle',
            'options' => [
                'circle'  => __('Circle', 'absl-ew'),
                'rounded' => __('Rounded', 'absl-ew'),
                'square'  => __('Square', 'absl-ew'),
            ],
        ]);

        $this->add_responsive_control('photo_radius_override', [
            'label' => __('Radius (override shape)', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','%'],
            'range' => ['px'=>['min'=>0,'max'=>150], '%'=>['min'=>0,'max'=>50]],
            'selectors' => [
                '{{WRAPPER}} .absl-team-card .avatar' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
            'description' => __('If set, this will override selected shape.', 'absl-ew'),
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'photo_border',
            'selector' => '{{WRAPPER}} .absl-team-card .avatar',
        ]);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'photo_shadow',
            'selector' => '{{WRAPPER}} .absl-team-card .avatar',
        ]);

        // Hover effects (simple)
        $this->add_control('photo_hover_scale', [
            'label' => __('Hover Scale (%)', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range' => ['%'=>['min'=>90,'max'=>120]],
            'default' => ['size'=>100,'unit'=>'%'],
        ]);
        $this->add_control('photo_hover_opacity', [
            'label' => __('Hover Opacity', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px'=>['min'=>0,'max'=>1, 'step'=>0.05]],
            'default' => ['size'=>1,'unit'=>'px'],
        ]);

        $this->end_controls_section();

        /* -----------------------
         * STYLE: TEXT (Name, Designation, Description)
         * ---------------------*/
        // Name
        $this->start_controls_section('name_style', [
            'label' => __('Name', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('name_color', [
            'label' => __('Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-team-card .name' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('name_hover_color', [
            'label' => __('Hover Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-team-card:hover .name' => 'color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'name_typo',
            'selector' => '{{WRAPPER}} .absl-team-card .name',
        ]);
        $this->end_controls_section();

        // Designation
        $this->start_controls_section('designation_style', [
            'label' => __('Designation', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('designation_color', [
            'label' => __('Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-team-card .designation' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('designation_hover_color', [
            'label' => __('Hover Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-team-card:hover .designation' => 'color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'designation_typo',
            'selector' => '{{WRAPPER}} .absl-team-card .designation',
        ]);
        $this->end_controls_section();

        // Description
        $this->start_controls_section('desc_style', [
            'label' => __('Description', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('desc_color', [
            'label' => __('Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-team-card .desc' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('desc_hover_color', [
            'label' => __('Hover Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-team-card:hover .desc' => 'color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'desc_typo',
            'selector' => '{{WRAPPER}} .absl-team-card .desc',
        ]);
        $this->end_controls_section();

        /* -----------------------
         * STYLE: SOCIAL ICONS
         * ---------------------*/
        $this->start_controls_section('social_style', [
            'label' => __('Social Icons', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        // View & Shape (like icon/image earlier)
        $this->add_control('social_view', [
            'label'   => __('View', 'absl-ew'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => __('Default', 'absl-ew'),
                'stacked' => __('Stacked', 'absl-ew'),
                'framed'  => __('Framed', 'absl-ew'),
            ],
        ]);
        $this->add_control('social_shape', [
            'label'   => __('Shape', 'absl-ew'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'rounded',
            'options' => [
                'square'  => __('Square', 'absl-ew'),
                'circle'  => __('Circle', 'absl-ew'),
                'rounded' => __('Rounded', 'absl-ew'),
            ],
            'condition' => ['social_view!' => 'default'],
        ]);

        $this->add_responsive_control('social_icon_size', [
            'label' => __('Icon Size', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px'=>['min'=>10,'max'=>40]],
            'default' => ['size'=>16,'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-team-card .socials a i'  => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-team-card .socials a svg'=> 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('social_box', [
            'label' => __('Icon Box (Stacked/Framed)', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px'=>['min'=>24,'max'=>64]],
            'default' => ['size'=>36,'unit'=>'px'],
            'condition' => ['social_view!' => 'default'],
            'selectors' => [
                '{{WRAPPER}} .absl-team-card .socials a.is-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('social_gap', [
            'label' => __('Spacing', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','em'],
            'range' => ['px'=>['min'=>0,'max'=>40],'em'=>['min'=>0,'max'=>4]],
            'default' => ['size'=>10,'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-team-card .socials' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Colors
        $this->add_control('social_color', [
            'label' => __('Icon Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-team-card .socials a' => 'color: {{VALUE}};',
                '{{WRAPPER}} .absl-team-card .socials a svg' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('social_color_hover', [
            'label' => __('Icon Hover Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-team-card .socials a:hover' => 'color: {{VALUE}};',
                '{{WRAPPER}} .absl-team-card .socials a:hover svg' => 'fill: {{VALUE}};',
            ],
        ]);

        // BG for stacked
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'social_bg',
            'label'    => __('Icon Background (Normal)', 'absl-ew'),
            'selector' => '{{WRAPPER}} .absl-team-card .socials a.is-stacked',
            'condition'=> ['social_view' => 'stacked'],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'social_bg_hover',
            'label'    => __('Icon Background (Hover)', 'absl-ew'),
            'selector' => '{{WRAPPER}} .absl-team-card .socials a.is-stacked:hover',
            'condition'=> ['social_view' => 'stacked'],
        ]);

        // Border for framed
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'social_frame_border',
            'selector' => '{{WRAPPER}} .absl-team-card .socials a.is-framed',
            'condition'=> ['social_view' => 'framed'],
        ]);

        $this->add_responsive_control('social_radius_override', [
            'label' => __('Icon Radius (override shape)', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','%'],
            'range' => ['px'=>['min'=>0,'max'=>40], '%'=>['min'=>0,'max'=>50]],
            'selectors' => [
                '{{WRAPPER}} .absl-team-card .socials a.is-box' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
            'condition'=> ['social_view!' => 'default'],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $preset = $s['preset'] ?? 'centered_circle';
        $name   = $s['name'] ?? '';
        $desig  = $s['designation'] ?? '';
        $desc   = $s['description'] ?? '';
        $photo  = !empty($s['photo']['url']) ? $s['photo']['url'] : '';

        // Social classes by view/shape
        $social_view = $s['social_view'] ?? 'default';
        $social_shape = $s['social_shape'] ?? 'rounded';
        $social_cls_box = '';
        if ($social_view === 'stacked') $social_cls_box = 'is-box is-stacked';
        elseif ($social_view === 'framed') $social_cls_box = 'is-box is-framed';

        $social_shape_cls = '';
        if ($social_view !== 'default') {
            if ($social_shape === 'circle')      $social_shape_cls = 'shape-circle';
            elseif ($social_shape === 'square')  $social_shape_cls = 'shape-square';
            else                                  $social_shape_cls = 'shape-rounded';
        }

        // Profile link
        $link = $s['profile_link'] ?? [];
        $href = !empty($link['url']) ? esc_url($link['url']) : '';
        $target = !empty($link['is_external']) ? ' target="_blank"' : '';
        $rel = [];
        if (!empty($link['nofollow'])) $rel[] = 'nofollow';
        if (!empty($link['is_external'])) $rel[] = 'noopener noreferrer';
        $rel_attr = $rel ? ' rel="'.esc_attr(implode(' ', $rel)).'"' : '';

        // Photo shape class
        $photo_shape = $s['photo_shape'] ?? 'circle';
        $photo_shape_cls = ($photo_shape === 'circle') ? 'shape-circle' : (($photo_shape === 'square') ? 'shape-square' : 'shape-rounded');

        $card_cls = 'absl-team-card preset-'.$preset;

        // Hover effects
        $scale = !empty($s['photo_hover_scale']['size']) ? floatval($s['photo_hover_scale']['size'])/100.0 : 1;
        $opacity = isset($s['photo_hover_opacity']['size']) ? floatval($s['photo_hover_opacity']['size']) : 1;

        ?>
        <div class="<?php echo esc_attr($card_cls); ?>">
            <?php if ($href): ?><a class="card-link" href="<?php echo $href; ?>"<?php echo $target.$rel_attr; ?>><?php endif; ?>

            <div class="inner">
                <div class="avatar <?php echo esc_attr($photo_shape_cls); ?>">
                    <?php if ($photo): ?>
                        <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($name); ?>">
                    <?php endif; ?>
                </div>

                <div class="meta">
                    <?php if ($name): ?><div class="name"><?php echo esc_html($name); ?></div><?php endif; ?>
                    <?php if ($desig): ?><div class="designation"><?php echo esc_html($desig); ?></div><?php endif; ?>
                </div>

                <?php if ($desc): ?>
                    <div class="desc"><?php echo esc_html($desc); ?></div>
                <?php endif; ?>

                <?php if (!empty($s['social_links']) && is_array($s['social_links'])): ?>
                <div class="socials">
                    <?php foreach ($s['social_links'] as $item):
                        $u = $item['url'] ?? [];
                        $u_href = !empty($u['url']) ? esc_url($u['url']) : '#';
                        $u_target = !empty($u['is_external']) ? ' target="_blank"' : '';
                        $u_rel = [];
                        if (!empty($u['nofollow'])) $u_rel[] = 'nofollow';
                        if (!empty($u['is_external'])) $u_rel[] = 'noopener noreferrer';
                        $u_rel_attr = $u_rel ? ' rel="'.esc_attr(implode(' ', $u_rel)).'"' : '';
                        $aria = !empty($item['aria_label']) ? ' aria-label="'.esc_attr($item['aria_label']).'"' : '';
                        $box_cls = ($social_view==='default') ? '' : trim($social_cls_box.' '.$social_shape_cls);
                    ?>
                    <a class="<?php echo esc_attr($box_cls); ?><?php echo $box_cls ? ' is-box' : ''; ?>" href="<?php echo $u_href; ?>"<?php echo $u_target.$u_rel_attr.$aria; ?>>
                        <?php \Elementor\Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <?php if ($href): ?></a><?php endif; ?>
        </div>

        <style>
        .absl-team-card{
            position:relative; display:flex; flex-direction:column; align-items:stretch;
            transition: all .3s ease;
        }
        .absl-team-card .inner{ display:flex; flex-direction:column; align-items:center; }
        .absl-team-card .avatar{
            display:inline-flex; align-items:center; justify-content:center;
            width:120px; height:120px; overflow:hidden; transition:all .3s ease;
        }
        .absl-team-card .avatar.shape-circle{ border-radius:50%; }
        .absl-team-card .avatar.shape-rounded{ border-radius:14px; }
        .absl-team-card .avatar.shape-square{ border-radius:0; }
        .absl-team-card .avatar img{ width:100%; height:100%; object-fit:cover; display:block; transition:all .35s ease; }

        .absl-team-card .meta{ display:flex; flex-direction:column; align-items:center; margin-top:10px; }
        .absl-team-card .name{ font-weight:700; line-height:1.2; }
        .absl-team-card .designation{ opacity:.9; }
        .absl-team-card .desc{ margin-top:10px; line-height:1.6; }

        .absl-team-card .socials{ display:flex; align-items:center; justify-content:center; gap:10px; margin-top:10px; flex-wrap:wrap; }
        .absl-team-card .socials a{
            display:inline-flex; align-items:center; justify-content:center; text-decoration:none;
            transition:all .25s ease; color:inherit;
        }
        .absl-team-card .socials a.is-box.shape-circle{ border-radius:50%; }
        .absl-team-card .socials a.is-box.shape-rounded{ border-radius:10px; }
        .absl-team-card .socials a.is-box.shape-square{ border-radius:0; }

        /* Hover interactions (photo) */
        .absl-team-card:hover .avatar img{
            transform: scale(<?php echo $scale ? $scale : 1; ?>);
            opacity: <?php echo $opacity !== '' ? $opacity : 1; ?>;
        }

        /* --------- PRESETS --------- */

        /* 1) Centered Circle (Default) */
        .absl-team-card.preset-centered_circle .inner{
            align-items:center; text-align:center;
        }

        /* 2) Left Compact: avatar left + text right */
        .absl-team-card.preset-left_compact .inner{
            width:100%; display:grid; grid-template-columns: auto 1fr; grid-column-gap:16px; align-items:center; text-align:left;
        }
        .absl-team-card.preset-left_compact .avatar{ grid-column:1; }
        .absl-team-card.preset-left_compact .meta,
        .absl-team-card.preset-left_compact .desc,
        .absl-team-card.preset-left_compact .socials{ align-items:flex-start; justify-content:flex-start; text-align:left; grid-column:2; }
        .absl-team-card.preset-left_compact .meta{ margin-top:0; }

        /* 3) Overlay Hover: photo wide top, overlay shows socials on hover */
        .absl-team-card.preset-overlay_hover .inner{ width:100%; }
        .absl-team-card.preset-overlay_hover .avatar{
            width:100%; height:220px; border-radius:12px; position:relative; overflow:hidden;
        }
        .absl-team-card.preset-overlay_hover .avatar::after{
            content:""; position:absolute; inset:0; background: rgba(0,0,0,.35);
            opacity:0; visibility:hidden; transition:all .3s ease;
        }
        .absl-team-card.preset-overlay_hover:hover .avatar::after{ opacity:1; visibility:visible; }
        .absl-team-card.preset-overlay_hover .socials{
            position:absolute; inset:auto 0 12px 0; z-index:2; opacity:0; visibility:hidden; transition:all .3s ease;
        }
        .absl-team-card.preset-overlay_hover:hover .socials{ opacity:1; visibility:visible; }
        .absl-team-card.preset-overlay_hover .meta, 
        .absl-team-card.preset-overlay_hover .desc{ text-align:center; }

        /* 4) Bordered Header: circle avatar overlaps top border */
        .absl-team-card.preset-bordered_header{
            border:1px solid rgba(0,0,0,.08);
            border-radius:14px; padding-top:54px;
        }
        .absl-team-card.preset-bordered_header .inner{ position:relative; }
        .absl-team-card.preset-bordered_header .avatar{
            position:absolute; top:-54px; left:50%; transform:translateX(-50%);
            box-shadow:0 6px 16px rgba(0,0,0,.08);
        }
        .absl-team-card.preset-bordered_header .meta{ margin-top:56px; }

        /* 5) Minimal: compact spacing, subtle text */
        .absl-team-card.preset-minimal .desc{ opacity:.9; }
        .absl-team-card.preset-minimal .socials a{ opacity:.85; }
        .absl-team-card.preset-minimal .socials a:hover{ opacity:1; }

        /* General helpers */
        .absl-team-card .card-link{ position:absolute; inset:0; z-index:5; }
        </style>
        <?php
    }
}
