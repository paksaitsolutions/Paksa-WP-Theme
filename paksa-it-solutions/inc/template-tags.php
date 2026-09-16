<?php
/**
 * Paksa IT Solutions — Template Tags
 *
 * @package paksa-it-solutions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display Post Meta
 */
function paksa_post_meta($args = array()) {
    $defaults = array(
        'show_date' => true,
        'show_author' => true,
        'show_categories' => false,
        'show_tags' => false,
        'separator' => ' • ',
    );
    $args = wp_parse_args($args, $defaults);

    $output = '';
    $sep = '';

    if ($args['show_date']) {
        $output .= sprintf(
            '<time datetime="%s" itemprop="datePublished">%s</time>',
            esc_attr(get_the_date('c')),
            esc_html(get_the_date())
        );
        $sep = $args['separator'];
    }

    if ($args['show_author'] && !is_page()) {
        $output .= $sep . sprintf(
            '<span class="pk-post-author">%s</span>',
            esc_html(get_the_author_meta('display_name'))
        );
        $sep = $args['separator'];
    }

    if ($args['show_categories'] && is_single()) {
        $cats = get_the_category();
        if (!empty($cats)) {
            $cat_names = array();
            foreach ($cats as $cat) {
                $cat_names[] = sprintf(
                    '<a href="%s">%s</a>',
                    esc_url(get_category_link($cat->term_id)),
                    esc_html($cat->name)
                );
            }
            $output .= $sep . '<span class="pk-post-categories">' . implode(', ', $cat_names) . '</span>';
            $sep = $args['separator'];
        }
    }

    if ($args['show_tags'] && is_single()) {
        $tags = get_the_tags();
        if (!empty($tags)) {
            $tag_names = array();
            foreach ($tags as $tag) {
                $tag_names[] = sprintf(
                    '<a href="%s">%s</a>',
                    esc_url(get_tag_link($tag->term_id)),
                    esc_html($tag->name)
                );
            }
            $output .= $sep . '<span class="pk-post-tags">' . implode(', ', $tag_names) . '</span>';
        }
    }

    if (!empty($output)) {
        echo '<div class="pk-post-meta">' . $output . '</div>';
    }
}

/**
 * Post Thumbnail with Fallback
 */
function paksa_post_thumbnail($size = 'post-thumbnail', $attr = array()) {
    if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
        return;
    }

    $attr = wp_parse_args($attr, array(
        'class' => 'pk-post-thumbnail',
        'loading' => 'lazy',
        'decoding' => 'async',
    ));

    the_post_thumbnail($size, $attr);
}

/**
 * Custom Excerpt Length
 */
function paksa_excerpt_length($length) {
    if (is_admin()) {
        return $length;
    }
    return 55;
}
add_filter('excerpt_length', 'paksa_excerpt_length');

/**
 * Custom Excerpt "Read More"
 */
function paksa_excerpt_more($more) {
    if (is_admin()) {
        return $more;
    }
    return ' <a href="' . esc_url(get_permalink()) . '" class="pk-read-more">' . esc_html__('Read More', 'paksa-it-solutions') . '</a>';
}
add_filter('excerpt_more', 'paksa_excerpt_more');

/**
 * Display Post Content with Read More Link
 */
function paksa_the_content($more_link_text = null, $strip_teaser = false) {
    $content = get_the_content($more_link_text, $strip_teaser);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    echo $content;
}

/**
 * Content Navigation (previous/next)
 */
function paksa_post_navigation() {
    if (!is_singular('post')) {
        return;
    }

    $prev = is_attachment() ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
    $next = get_adjacent_post(false, '', false);

    if (empty($prev) && empty($next)) {
        return;
    }

    ?>
    <nav class="pk-post-navigation" aria-label="<?php esc_attr_e('Post navigation', 'paksa-it-solutions'); ?>">
        <?php if (!empty($prev)): ?>
            <div class="pk-post-nav-prev">
                <?php previous_post_link('%link', '<span class="pk-post-nav-label">' . esc_html__('Previous', 'paksa-it-solutions') . '</span> %title'); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($next)): ?>
            <div class="pk-post-nav-next">
                <?php next_post_link( '%link', '%title <span class="pk-post-nav-label">' . esc_html__( 'Next', 'paksa-it-solutions' ) . '</span>' ); ?>
            </div>
        <?php endif; ?>
    </nav>
    <?php
}

/**
 * Comments Template Wrapper
 */
function paksa_render_comments() {
    if (post_password_required()) {
        echo '<p class="pk-comments-locked">' . esc_html__('This post is password protected. Enter the password to view any comments.', 'paksa-it-solutions') . '</p>';
        return;
    }

    if (have_comments() || comments_open()) {
        comments_template();
    }
}
