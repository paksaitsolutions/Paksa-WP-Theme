<?php
/**
 * Paksa — Block Pattern: FAQ Accordion
 *
 * A set of FAQ items using core/details blocks with Paksa styling.
 * Fully editable: questions and answers are native block content.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/faq-accordion',
    array(
        'title'      => __( 'FAQ — Accordion', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-faq-advanced' ),
        'keywords'   => array( 'faq', 'accordion', 'questions', 'help' ),
        'viewport'   => array( 'width' => 1280, 'height' => 400 ),
        'content'    => '<!-- wp:paksa/section {"variant":"alt"} -->'
        . '<div class="wp-block-paksa-section pk-section pk-section--alt">'
        . paksa_visual_heading( 'Frequently asked questions', 2 )
        . paksa_visual_paragraph( 'Answers to the most common questions about our services.' )
        . '<!-- wp:details {"className":"pk-pattern-faq","showContent":true} -->'
        . '<details class="wp-block-details pk-pattern-faq" open>'
        . '<summary>What services do you offer?</summary>'
        . paksa_visual_paragraph( 'We specialise in enterprise software, AI automation, cloud solutions, and business intelligence.' )
        . '</details><!-- /wp:details -->'
        . '<!-- wp:details {"className":"pk-pattern-faq"} -->'
        . '<details class="wp-block-details pk-pattern-faq">'
        . '<summary>How long does a project take?</summary>'
        . paksa_visual_paragraph( 'Typical projects range from 6 to 16 weeks. We scope and estimate based on your specific requirements.' )
        . '</details><!-- /wp:details -->'
        . '<!-- wp:details {"className":"pk-pattern-faq"} -->'
        . '<details class="wp-block-details pk-pattern-faq">'
        . '<summary>Do you provide ongoing support?</summary>'
        . paksa_visual_paragraph( 'Yes. We offer retainers, SLA-backed support, and continuous improvement packages.' )
        . '</details><!-- /wp:details -->'
        . '<!-- /wp:paksa/section -->',
    )
);
