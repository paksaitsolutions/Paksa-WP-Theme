<?php
/**
 * Paksa IT Solutions — Accessibility
 *
 * @package paksa-it-solutions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Skip Link
 */
function paksa_skip_link() {
    ?>
    <a href="#main-content" class="skip-link">
        <?php esc_html_e('Skip to main content', 'paksa-it-solutions'); ?>
    </a>
    <?php
}

/**
 * Accessibility Wrapper Open
 */
function paksa_a11y_wrapper_open() {
    ?>
    <div class="pk-a11y-wrapper">
    <?php
}

/**
 * Accessibility Wrapper Close
 */
function paksa_a11y_wrapper_close() {
    ?>
    </div>
    <?php
}

/**
 * Document Title Filter
 */
function paksa_document_title($title_parts) {
    if (!is_feed()) {
        if (get_query_var('paged')) {
            $title_parts['title'] .= ' ' . sprintf(
                __('Page %s', 'paksa-it-solutions'),
                get_query_var('paged')
            );
        }
    }
    return $title_parts;
}
add_filter('document_title_parts', 'paksa_document_title');

/**
 * Add ARIA Label to Body for Search Results
 */
function paksa_body_class($classes) {
    if (is_search()) {
        $classes[] = 'search-results';
    }
    if (is_paged()) {
        $classes[] = 'paged';
    }
    return $classes;
}
add_filter('body_class', 'paksa_body_class');
