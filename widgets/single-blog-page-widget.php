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

class ABSL_Single_Blog_Page_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'absl_single_blog_page';
    }

    public function get_title()
    {
        return __('Single Blog Page', 'absl-ew');
    }

    public function get_icon()
    {
        return 'eicon-post-content';
    }

    public function get_categories()
    {
        return ['absoftlab'];
    }

    public function get_style_depends()
    {
        return ['absl-single-blog-page'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('section_content', [
            'label' => __('Content', 'absl-ew'),
        ]);

        $this->add_control('use_current_post', [
            'label' => __('Use Current Post', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('post_id', [
            'label' => __('Post ID', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'condition' => [
                'use_current_post!' => 'yes',
            ],
        ]);

        $this->add_control('show_category', [
            'label' => __('Show Category', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('show_meta', [
            'label' => __('Show Meta (Author, Date, Read Time)', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('read_time_wpm', [
            'label' => __('Words Per Minute', 'absl-ew'),
            'type' => Controls_Manager::NUMBER,
            'default' => 200,
            'min' => 100,
            'condition' => [
                'show_meta' => 'yes',
            ],
        ]);

        $this->add_control('show_tags', [
            'label' => __('Show Tags', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('show_share', [
            'label' => __('Show Share Icons', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('show_author_box', [
            'label' => __('Show Author Box', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('author_fallback', [
            'label' => __('Author Bio Fallback', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Professional writer and creator.', 'absl-ew'),
            'condition' => [
                'show_author_box' => 'yes',
            ],
        ]);

        $this->add_control('show_back_link', [
            'label' => __('Show Back Link', 'absl-ew'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);

        $this->add_control('back_link_text', [
            'label' => __('Back Link Text', 'absl-ew'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Back to Blog', 'absl-ew'),
            'condition' => [
                'show_back_link' => 'yes',
            ],
        ]);

        $this->add_control('back_link_url', [
            'label' => __('Back Link URL', 'absl-ew'),
            'type' => Controls_Manager::URL,
            'placeholder' => __('https://your-site.com/blog', 'absl-ew'),
            'condition' => [
                'show_back_link' => 'yes',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_global', [
            'label' => __('Global', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('accent_color', [
            'label' => __('Accent Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-single-blog' => '--absl-sb-accent: {{VALUE}};',
            ],
        ]);

        $this->add_control('text_color', [
            'label' => __('Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-single-blog' => '--absl-sb-text: {{VALUE}};',
            ],
        ]);

        $this->add_control('muted_color', [
            'label' => __('Muted Text Color', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-single-blog' => '--absl-sb-muted: {{VALUE}};',
            ],
        ]);

        $this->add_control('card_bg_color', [
            'label' => __('Card Background', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-single-blog' => '--absl-sb-card-bg: {{VALUE}};',
            ],
        ]);

        $this->add_control('card_border_color', [
            'label' => __('Card Border', 'absl-ew'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .absl-single-blog' => '--absl-sb-border: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('card_radius', [
            'label' => __('Card Radius', 'absl-ew'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => ['min' => 0, 'max' => 40],
            ],
            'selectors' => [
                '{{WRAPPER}} .absl-single-blog' => '--absl-sb-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'title_typo',
            'selector' => '{{WRAPPER}} .absl-sb-title',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'body_typo',
            'selector' => '{{WRAPPER}} .absl-sb-body',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_card', [
            'label' => __('Cards', 'absl-ew'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'card_bg',
            'selector' => '{{WRAPPER}} .absl-sb-card',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'card_border',
            'selector' => '{{WRAPPER}} .absl-sb-card',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'card_shadow',
            'selector' => '{{WRAPPER}} .absl-sb-card',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        if (function_exists('absl_ew_register_assets')) {
            absl_ew_register_assets();
        }
        wp_enqueue_style('absl-single-blog-page');

        $s = $this->get_settings_for_display();
        $post_id = 0;

        if (($s['use_current_post'] ?? 'yes') === 'yes') {
            $post_id = get_the_ID();
        } elseif (! empty($s['post_id'])) {
            $post_id = (int) $s['post_id'];
        }

        if (! $post_id || 'post' !== get_post_type($post_id)) {
            echo '<div class="absl-single-blog">' . esc_html__('No post selected.', 'absl-ew') . '</div>';
            return;
        }

        $title = get_the_title($post_id);
        $permalink = get_permalink($post_id);
        $thumb_url = get_the_post_thumbnail_url($post_id, 'full');
        $categories = get_the_category($post_id);
        $category = ! empty($categories) ? $categories[0]->name : '';
        $author_id = (int) get_post_field('post_author', $post_id);
        $author_name = get_the_author_meta('display_name', $author_id);
        $author_desc = get_the_author_meta('description', $author_id);
        $date = get_the_date('', $post_id);
        $content = get_post_field('post_content', $post_id);
        $read_time = $this->get_read_time($content, (int) ($s['read_time_wpm'] ?? 200));
        $tags = get_the_tags($post_id);

        $full_content = apply_filters('the_content', get_post_field('post_content', $post_id));

        $share_links = [
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode($permalink),
            'x' => 'https://twitter.com/intent/tweet?url=' . rawurlencode($permalink) . '&text=' . rawurlencode($title),
            'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url=' . rawurlencode($permalink) . '&title=' . rawurlencode($title),
        ];

        $hero_style = $thumb_url ? ' style="background-image:url(' . esc_url($thumb_url) . ');"' : '';
        ?>
        <div class="absl-single-blog">
            <div class="absl-sb-hero absl-sb-card"<?php echo $hero_style; ?>>
                <div class="absl-sb-hero-content">
                    <?php if (($s['show_category'] ?? 'yes') === 'yes' && ! empty($category)) : ?>
                        <span class="absl-sb-chip"><?php echo esc_html($category); ?></span>
                    <?php endif; ?>

                    <h1 class="absl-sb-title"><?php echo esc_html($title); ?></h1>

                    <?php if (($s['show_meta'] ?? 'yes') === 'yes') : ?>
                        <div class="absl-sb-meta">
                            <?php if (! empty($author_name)) : ?>
                                <span class="absl-sb-meta-item">
                                    <?php echo $this->get_icon_svg('user'); ?>
                                    <span><?php echo esc_html($author_name); ?></span>
                                </span>
                            <?php endif; ?>
                            <?php if (! empty($date)) : ?>
                                <span class="absl-sb-meta-item">
                                    <?php echo $this->get_icon_svg('calendar'); ?>
                                    <span><?php echo esc_html($date); ?></span>
                                </span>
                            <?php endif; ?>
                            <?php if (! empty($read_time)) : ?>
                                <span class="absl-sb-meta-item">
                                    <?php echo $this->get_icon_svg('clock'); ?>
                                    <span><?php echo esc_html($read_time); ?></span>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="absl-sb-card absl-sb-body">
                <div class="absl-sb-content">
                    <?php echo wp_kses_post($full_content); ?>
                </div>

                <?php if (($s['show_tags'] ?? 'yes') === 'yes' && ! empty($tags)) : ?>
                    <div class="absl-sb-tags">
                        <?php foreach ($tags as $tag) : ?>
                            <span class="absl-sb-tag">#<?php echo esc_html($tag->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (($s['show_share'] ?? 'yes') === 'yes') : ?>
                    <div class="absl-sb-share">
                        <span class="absl-sb-share-label"><?php esc_html_e('Share this article', 'absl-ew'); ?></span>
                        <div class="absl-sb-share-icons">
                            <?php foreach ($share_links as $network => $link) : ?>
                                <a class="absl-sb-share-link" href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($network); ?>">
                                    <?php echo $this->get_icon_svg($network); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (($s['show_author_box'] ?? 'yes') === 'yes') : ?>
                <div class="absl-sb-card absl-sb-author">
                    <div class="absl-sb-author-avatar">
                        <?php echo wp_kses_post(get_avatar($author_id, 64)); ?>
                    </div>
                    <div class="absl-sb-author-info">
                        <span class="absl-sb-author-label"><?php esc_html_e('Written by', 'absl-ew'); ?></span>
                        <span class="absl-sb-author-name"><?php echo esc_html($author_name); ?></span>
                        <p class="absl-sb-author-desc">
                            <?php
                            $bio = ! empty($author_desc) ? $author_desc : ($s['author_fallback'] ?? '');
                            echo esc_html($bio);
                            ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="absl-sb-card absl-sb-comments">
                <div class="absl-sb-comments-header">
                    <?php esc_html_e('Leave a comment', 'absl-ew'); ?>
                </div>
                <?php
                if (comments_open($post_id)) {
                    comment_form([
                        'title_reply' => '',
                        'label_submit' => __('Post Comment', 'absl-ew'),
                        'comment_notes_before' => '',
                        'comment_notes_after' => '',
                        'class_submit' => 'absl-sb-comment-submit',
                        'comment_field' =>
                            '<textarea id="comment" name="comment" rows="5" required="required" placeholder="' .
                            esc_attr__('Write your comment...', 'absl-ew') .
                            '"></textarea>',
                        'fields' => [
                            'author' =>
                                '<input id="author" name="author" type="text" required="required" placeholder="' .
                                esc_attr__('Your name', 'absl-ew') .
                                '">',
                            'email' =>
                                '<input id="email" name="email" type="email" required="required" placeholder="' .
                                esc_attr__('Your email', 'absl-ew') .
                                '">',
                        ],
                    ], $post_id);
                } else {
                    echo '<p class="absl-sb-comments-closed">' . esc_html__('Comments are closed.', 'absl-ew') . '</p>';
                }
                ?>
            </div>

            <?php if (($s['show_back_link'] ?? 'yes') === 'yes') : ?>
                <?php
                $back_url = $s['back_link_url']['url'] ?? '';
                if (empty($back_url)) {
                    $back_url = get_post_type_archive_link('post');
                }
                ?>
                <?php if (! empty($back_url)) : ?>
                    <a class="absl-sb-back" href="<?php echo esc_url($back_url); ?>">
                        &larr; <?php echo esc_html($s['back_link_text'] ?? __('Back to Blog', 'absl-ew')); ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php
    }

    private function get_read_time($content, $wpm)
    {
        $wpm = max(100, (int) $wpm);
        $word_count = str_word_count(wp_strip_all_tags($content));
        $minutes = max(1, (int) ceil($word_count / $wpm));
        return sprintf(__('%d min read', 'absl-ew'), $minutes);
    }

    private function get_icon_svg($name)
    {
        switch ($name) {
            case 'calendar':
                return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2a1 1 0 0 1 1 1v1h8V3a1 1 0 1 1 2 0v1h1a3 3 0 0 1 3 3v11a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h1V3a1 1 0 0 1 1-1Zm0 6h10a1 1 0 0 0 0-2H7a1 1 0 0 0 0 2Z"/></svg>';
            case 'clock':
                return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20Zm1 5a1 1 0 0 0-2 0v5c0 .265.105.52.293.707l3 3a1 1 0 1 0 1.414-1.414L13 11.586V7Z"/></svg>';
            case 'facebook':
                return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 8.5V7.2c0-.9.6-1.1 1-1.1h1.8V3.2h-2.5c-2.8 0-3.8 1.7-3.8 3.7v1.6H8v2.8h2v9h3v-9h2.5l.6-2.8h-3.1Z"/></svg>';
            case 'linkedin':
                return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5ZM3.5 9h3v12h-3V9Zm7 0h2.9v1.6h.1c.4-.8 1.5-1.7 3.1-1.7 3.3 0 3.9 2.1 3.9 4.9V21h-3v-5.7c0-1.4 0-3.1-2-3.1-2 0-2.3 1.5-2.3 3V21h-3V9Z"/></svg>';
            case 'x':
                return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h4.1l4 5.6L16.7 4H20l-6.4 8.7L20 20h-4.1l-4.4-6.1L7 20H3.7l6.8-9.2L4 4Z"/></svg>';
            case 'user':
            default:
                return '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm0 2c-4 0-7 2.2-7 5v1h14v-1c0-2.8-3-5-7-5Z"/></svg>';
        }
    }
}
