<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class ABSL_Image_Overlay_Card_Widget extends Widget_Base {
    public function get_name() { return 'absl_image_overlay_card'; }
    public function get_title() { return __('Image Overlay', 'absl-ew'); }
    public function get_icon() { return 'eicon-image-box'; }
    public function get_categories() { return ['absoftlab']; }

    /* -----------------------
     * CONTROLS
     * ---------------------*/
    protected function register_controls() {

        /* CONTENT: Images */
        $this->start_controls_section('sec_images', [
            'label' => __('Images', 'absl-ew')
        ]);
        $this->add_control('image_normal', [
            'label'   => __('Normal Image', 'absl-ew'),
            'type'    => Controls_Manager::MEDIA,
            'default' => ['url' => \Elementor\Utils::get_placeholder_image_src()],
        ]);
        $this->add_control('image_hover', [
            'label'   => __('Hover Image (optional)', 'absl-ew'),
            'type'    => Controls_Manager::MEDIA,
            'description' => __('If not set, normal image will be used on hover too.', 'absl-ew'),
        ]);
        $this->add_responsive_control('image_ratio', [
            'label' => __('Image Ratio', 'absl-ew'),
            'type'  => Controls_Manager::SELECT,
            'default' => '16-9',
            'options' => [
                '21-9' => '21:9',
                '16-9' => '16:9',
                '4-3'  => '4:3',
                '1-1'  => '1:1',
                'custom' => __('Custom (by height)', 'absl-ew'),
            ],
        ]);
        $this->add_responsive_control('custom_height', [
            'label' => __('Custom Height', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','vh'],
            'range' => [
                'px' => ['min'=>120, 'max'=>1200],
                'vh' => ['min'=>10, 'max'=>100],
            ],
            'condition' => ['image_ratio' => 'custom'],
            'selectors' => [
                '{{WRAPPER}} .absl-io-card' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();

        /* CONTENT: Normal Texts */
        $this->start_controls_section('sec_content_normal', [
            'label' => __('Content – Normal', 'absl-ew')
        ]);
        $this->add_control('title_normal', [
            'label' => __('Title', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'default' => __('Now That’s Lake Living!', 'absl-ew'),
        ]);
        $this->add_control('position_normal', [
            'label' => __('Position', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'default' => __('Outdoor kitchen', 'absl-ew'),
        ]);
        $this->add_control('location_normal', [
            'label' => __('Location', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'default' => __('Seneca, SC', 'absl-ew'),
        ]);
        $this->end_controls_section();

        /* CONTENT: Hover Texts */
        $this->start_controls_section('sec_content_hover', [
            'label' => __('Content – Hover', 'absl-ew')
        ]);
        $this->add_control('title_hover_text', [
            'label' => __('Title (Hover)', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'placeholder' => __('Leave empty to reuse normal title', 'absl-ew'),
        ]);
        $this->add_control('position_hover', [
            'label' => __('Position (Hover)', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'placeholder' => __('Leave empty to reuse normal position', 'absl-ew'),
        ]);
        $this->add_control('location_hover', [
            'label' => __('Location (Hover)', 'absl-ew'),
            'type'  => Controls_Manager::TEXT,
            'placeholder' => __('Leave empty to reuse normal location', 'absl-ew'),
        ]);
        $this->end_controls_section();

        /* CONTENT: Link */
        $this->start_controls_section('sec_link', [
            'label' => __('Link', 'absl-ew')
        ]);
        $this->add_control('card_link', [
            'label' => __('Card Link', 'absl-ew'),
            'type'  => Controls_Manager::URL,
            'placeholder' => __('https://example.com', 'absl-ew'),
            'options'     => ['url','is_external','nofollow'],
        ]);
        $this->end_controls_section();

        /* STYLE: Overlay & Layout */
        $this->start_controls_section('sec_style_overlay', [
            'label' => __('Overlay & Layout', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name'     => 'overlay_bg',
            'label'    => __('Overlay Color', 'absl-ew'),
            'types'    => ['classic','gradient'],
            'selector' => '{{WRAPPER}} .absl-io-card .absl-ovl',
        ]);
        $this->add_control('hover_transition', [
            'label' => __('Hover Transition (ms)', 'absl-ew'),
            'type'  => Controls_Manager::NUMBER,
            'min'   => 100, 'max'=>2000, 'step'=>50,
            'default'=> 350,
        ]);
        $this->add_responsive_control('content_align', [
            'label'   => __('Content Alignment', 'absl-ew'),
            'type'    => Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => ['title'=>__('Left','absl-ew'),'icon'=>'eicon-h-align-left'],
                'center'     => ['title'=>__('Center','absl-ew'),'icon'=>'eicon-h-align-center'],
                'flex-end'   => ['title'=>__('Right','absl-ew'),'icon'=>'eicon-h-align-right'],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .absl-io-card .absl-ovl-inner' => 'align-items: {{VALUE}}; text-align: {{VALUE:IF(center,center,left)}};',
            ],
        ]);
        $this->add_responsive_control('content_padding', [
            'label' => __('Content Padding', 'absl-ew'),
            'type'  => Controls_Manager::DIMENSIONS,
            'size_units' => ['px','%','em'],
            'selectors' => [
                '{{WRAPPER}} .absl-io-card .absl-ovl-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'card_border',
            'selector' => '{{WRAPPER}} .absl-io-card',
        ]);
        $this->add_responsive_control('card_radius', [
            'label' => __('Border Radius', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','%'],
            'selectors' => [
                '{{WRAPPER}} .absl-io-card, {{WRAPPER}} .absl-io-card img, {{WRAPPER}} .absl-io-card .absl-ovl' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_shadow',
            'selector' => '{{WRAPPER}} .absl-io-card',
        ]);
        $this->end_controls_section();

        /* STYLE: Title */
        $this->start_controls_section('sec_style_title', [
            'label' => __('Title', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('title_color', [
            'label' => __('Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-io-card .absl-title' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('title_hover_color', [
            'label' => __('Color (Hover)', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .absl-io-card:hover .absl-title' => 'color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'title_typo',
            'selector' => '{{WRAPPER}} .absl-io-card .absl-title',
        ]);
        $this->end_controls_section();

        /* STYLE: Position & Location + Dividers */
        $this->start_controls_section('sec_style_meta', [
            'label' => __('Position & Location + Dividers', 'absl-ew'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);
        $this->add_control('meta_color', [
            'label' => __('Text Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-io-card .absl-meta span' => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_control('meta_hover_color', [
            'label' => __('Text Color (Hover)', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-io-card:hover .absl-meta span' => 'color: {{VALUE}};',
            ],
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'meta_typo',
            'selector' => '{{WRAPPER}} .absl-io-card .absl-meta span',
        ]);
        $this->add_control('divider_color', [
            'label' => __('Divider Color', 'absl-ew'),
            'type'  => Controls_Manager::COLOR,
            'default' => '#FFFFFF',
            'selectors' => [
                '{{WRAPPER}} .absl-io-card .absl-title-divider' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .absl-io-card .absl-meta .vdiv'    => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->add_responsive_control('divider_thickness', [
            'label' => __('Divider Thickness', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => ['px'=>['min'=>1,'max'=>10]],
            'default' => ['size'=>2,'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-io-card .absl-title-divider' => 'height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .absl-io-card .absl-meta .vdiv'    => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->add_responsive_control('meta_gap', [
            'label' => __('Meta Spacing', 'absl-ew'),
            'type'  => Controls_Manager::SLIDER,
            'size_units' => ['px','em'],
            'range' => ['px'=>['min'=>0,'max'=>60],'em'=>['min'=>0,'max'=>6]],
            'default' => ['size'=>16,'unit'=>'px'],
            'selectors' => [
                '{{WRAPPER}} .absl-io-card .absl-meta' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->end_controls_section();
    }

    /* -----------------------
     * RENDER
     * ---------------------*/
    protected function render() {
        $s = $this->get_settings_for_display();

        // Images
        $img_normal = !empty($s['image_normal']['url']) ? $s['image_normal']['url'] : '';
        $img_hover  = !empty($s['image_hover']['url'])  ? $s['image_hover']['url']  : $img_normal;

        // Texts (hover fallback to normal if empty)
        $title_norm = $s['title_normal'] ?? '';
        $pos_norm   = $s['position_normal'] ?? '';
        $loc_norm   = $s['location_normal'] ?? '';

        $title_hov = !empty($s['title_hover_text']) ? $s['title_hover_text'] : $title_norm;
        $pos_hov   = !empty($s['position_hover'])   ? $s['position_hover']   : $pos_norm;
        $loc_hov   = !empty($s['location_hover'])   ? $s['location_hover']   : $loc_norm;

        // Link attrs
        $link = $s['card_link'] ?? [];
        $url  = !empty($link['url']) ? esc_url($link['url']) : '';
        $target = !empty($link['is_external']) ? ' target="_blank"' : '';
        $rel = [];
        if ( !empty($link['nofollow']) ) $rel[] = 'nofollow';
        if ( !empty($link['is_external']) ) $rel[] = 'noopener noreferrer';
        $rel_attr = $rel ? ' rel="'.esc_attr(implode(' ',$rel)).'"' : '';

        // Ratio
        $ratio = $s['image_ratio'] ?? '16-9';
        $ratio_map = [
            '21-9' => (9/21*100),
            '16-9' => (9/16*100),
            '4-3'  => (3/4*100),
            '1-1'  => 100,
        ];
        $padding_bottom = isset($ratio_map[$ratio]) ? $ratio_map[$ratio] : null;

        // Transition
        $tr = !empty($s['hover_transition']) ? intval($s['hover_transition']) : 350;

        ?>
        <div class="absl-io-card" style="<?php
            if ($ratio !== 'custom' && $padding_bottom) {
                echo 'position:relative;';
            }
        ?>">
            <?php if ($url): ?><a class="absl-io-link" href="<?php echo $url; ?>"<?php echo $target.$rel_attr; ?>><?php endif; ?>

            <div class="absl-img-wrap" style="<?php
                if ($ratio !== 'custom' && $padding_bottom) {
                    echo 'position:relative; width:100%; padding-bottom:'.$padding_bottom.'%; overflow:hidden;';
                }
            ?>">
                <img class="absl-img normal" src="<?php echo esc_url($img_normal); ?>" alt="">
                <img class="absl-img hover"  src="<?php echo esc_url($img_hover);  ?>" alt="">
                <div class="absl-ovl" style="transition: opacity <?php echo $tr; ?>ms ease, visibility <?php echo $tr; ?>ms ease;">
                    <div class="absl-ovl-inner">
                        <?php if ( $title_hov ): ?>
                            <div class="absl-title"><?php echo esc_html($title_hov); ?></div>
                            <div class="absl-title-divider"></div>
                        <?php endif; ?>

                        <div class="absl-meta">
                            <?php if ($pos_hov): ?><span class="pos"><?php echo esc_html($pos_hov); ?></span><?php endif; ?>
                            <span class="vdiv" aria-hidden="true"></span>
                            <?php if ($loc_hov): ?><span class="loc"><?php echo esc_html($loc_hov); ?></span><?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if ($title_norm || $pos_norm || $loc_norm): ?>
                <div class="absl-base-content">
                    <?php if ($title_norm): ?><div class="absl-title"><?php echo esc_html($title_norm); ?></div><?php endif; ?>
                    <div class="absl-meta">
                        <?php if ($pos_norm): ?><span class="pos"><?php echo esc_html($pos_norm); ?></span><?php endif; ?>
                        <span class="vdiv" aria-hidden="true"></span>
                        <?php if ($loc_norm): ?><span class="loc"><?php echo esc_html($loc_norm); ?></span><?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <?php if ($url): ?></a><?php endif; ?>
        </div>

        <style>
        .absl-io-card{display:block; width:100%;}
        .absl-io-card .absl-img-wrap{width:100%;}
        .absl-io-card img.absl-img{
            width:100%; height:100%; object-fit:cover; display:block; position:absolute; inset:0;
            transition: opacity <?php echo $tr; ?>ms ease;
        }
        .absl-io-card img.absl-img.normal{opacity:1; z-index:1;}
        .absl-io-card img.absl-img.hover {opacity:0; z-index:2;}
        .absl-io-card:hover img.absl-img.hover{opacity:1;}
        .absl-io-card:hover img.absl-img.normal{opacity:0;}

        /* Overlay */
        .absl-io-card .absl-ovl{
            position:absolute; inset:0; z-index:3;
            display:flex; align-items:center; justify-content:center;
            opacity:0; visibility:hidden;
        }
        .absl-io-card:hover .absl-ovl{opacity:1; visibility:visible;}

        .absl-io-card .absl-ovl-inner{
            width:100%;
            display:flex; flex-direction:column; align-items:center; text-align:center;
            padding:24px;
        }

        /* Title + horizontal divider */
        .absl-io-card .absl-title{font-weight:700; margin:0 0 10px; color:#fff; text-shadow:0 1px 2px rgba(0,0,0,.25);}
        .absl-io-card .absl-title-divider{
            width:100%; max-width:420px; height:2px; background:#fff; opacity:.9; margin:6px auto 14px;
        }

        /* Meta row (position | location with vertical divider) */
        .absl-io-card .absl-meta{display:flex; align-items:center; justify-content:center; gap:16px;}
        .absl-io-card .absl-meta span{color:#fff;}
        .absl-io-card .absl-meta .vdiv{display:inline-block; height:20px; width:2px; background:#fff; opacity:.9;}

        /* Base (non-hover) content – shown lightly over image */
        .absl-io-card .absl-base-content{
            position:absolute; left:0; right:0; bottom:0; z-index:2;
            padding:16px 20px; color:#fff; text-shadow:0 1px 2px rgba(0,0,0,.2);
            display:flex; flex-direction:column; align-items:center; text-align:center;
        }
        </style>
        <?php
    }
}
