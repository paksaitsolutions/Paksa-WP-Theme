<?php
/**
 * Paksa IT Solutions — Block Pattern: Paragraph Lead
 *
 * Large introductory paragraph (body-large).
 * For opening sections and page intros.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/paragraph-lead',
    array(
        'title'      => __( 'Paragraph — Lead', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-paragraphs' ),
        'keywords'   => array( 'paragraph', 'lead', 'intro', 'large' ),
        'viewport'   => array(
            'width'  => 720,
            'height' => 150,
        ),
        'content'    => '<!-- wp:paragraph {"className":"body-large","style":{"color":{"text":"var(--pk-text-secondary)"},"typography":{"fontSize":"1.125rem","lineHeight":"1.7"}},"metadata":{"dxActionId":""}} -->
<p class="body-large" style="color:var(--pk-text-secondary);font-size:1.125rem;line-height:1.7;">' . esc_html__( 'Paksa IT Solutions builds enterprise software, AI-powered solutions and intelligent digital systems designed around real business challenges. We transform fragmented technology into connected, intelligent platforms that drive measurable results.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->',
    )
);
