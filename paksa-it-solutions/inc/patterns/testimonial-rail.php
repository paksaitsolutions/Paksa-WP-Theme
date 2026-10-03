<?php
/**
 * Paksa — Block Pattern: Testimonial Rail
 *
 * A horizontal scrollable rail of testimonials using paksa/testimonial-rail.
 * Fully editable: add, remove, or duplicate testimonial items inside the rail.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/testimonial-rail',
    array(
        'title'      => __( 'Testimonials — Rail Carousel', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-testimonials-v2' ),
        'keywords'   => array( 'testimonials', 'carousel', 'rail', 'slider' ),
        'viewport'   => array( 'width' => 1280, 'height' => 400 ),
        'content'    => '<!-- wp:paksa/section {"variant":"alt"} -->'
        . '<div class="wp-block-paksa-section pk-section pk-section--alt">'
        . paksa_visual_heading( 'What clients say', 2 )
        . paksa_visual_paragraph( 'Real feedback from the people we have helped.' )
        . '<!-- wp:paksa/testimonial-rail {"variant":"card","showNavigation":true,"showDots":true,"itemsToShow":1,"autoplay":false} -->'
        . '<!-- wp:paksa/testimonial {"quote":"The team transformed how we think about our digital strategy. Their insights were invaluable.","author":"Alex Johnson","role":"Head of Product","company":"TechFlow Inc","rating":5,"showRating":true,"variant":"default"} /-->'
        . '<!-- wp:paksa/testimonial {"quote":"An adaptable system that our team can own and extend. Delivered exactly what we needed.","author":"Maria Santos","role":"CTO","company":"DataStream Co","rating":5,"showRating":true,"variant":"default"} /-->'
        . '<!-- wp:paksa/testimonial {"quote":"From discovery to launch, the process was clear, collaborative, and effective.","author":"Sam Lee","role":"Marketing Director","company":"GrowthLab","rating":4,"showRating":true,"variant":"default"} /-->'
        . '<!-- /wp:paksa/testimonial-rail -->'
        . '</div><!-- /wp:paksa/section -->',
    )
);
