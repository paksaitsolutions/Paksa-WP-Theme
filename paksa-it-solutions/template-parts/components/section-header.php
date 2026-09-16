<?php
/**
 * Paksa IT Solutions — Component: Section Header
 *
 * Args:
 *   $args['eyebrow']     string  Small label above heading
 *   $args['heading']     string  Main section heading (h2 by default)
 *   $args['description'] string  Supporting paragraph
 *   $args['align']       string  'center' (default) | 'left'
 *   $args['heading_tag'] string  'h2' (default) | 'h3'
 *   $args['class']       string  Extra CSS classes
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$args        = isset( $args ) ? $args : array();
$eyebrow     = isset( $args['eyebrow'] ) ? $args['eyebrow'] : '';
$heading     = isset( $args['heading'] ) ? $args['heading'] : '';
$description = isset( $args['description'] ) ? $args['description'] : '';
$align       = isset( $args['align'] ) && $args['align'] === 'left' ? ' align-left' : '';
$tag         = isset( $args['heading_tag'] ) ? $args['heading_tag'] : 'h2';
$extra_class = isset( $args['class'] ) ? ' ' . $args['class'] : '';

if ( empty( $heading ) ) {
    return;
}

$allowed_tags = array( 'h2', 'h3', 'h4' );
$tag          = in_array( $tag, $allowed_tags, true ) ? $tag : 'h2';
?>
<header class="section-header<?php echo esc_attr( $align . $extra_class ); ?>">
    <?php if ( $eyebrow ) : ?>
        <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
    <?php endif; ?>
    <<?php echo $tag; ?>><?php echo esc_html( $heading ); ?></<?php echo $tag; ?>>
    <?php if ( $description ) : ?>
        <p><?php echo esc_html( $description ); ?></p>
    <?php endif; ?>
</header>
