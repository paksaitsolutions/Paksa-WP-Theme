<?php
/**
 * Paksa IT Solutions — Single Product Template
 *
 * Renders all product sections from post meta via template-parts/product/.
 * Section visibility controlled by _paksa_prod_show_* meta keys.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( ! have_posts() ) {
	get_footer();
	return;
}

the_post();

$prod_id = get_the_ID();

/**
 * Section visibility helper.
 * Returns true unless the meta key is explicitly set to '0'.
 */
function paksa_prod_section_visible( $key, $prod_id ) {
	$val = get_post_meta( $prod_id, '_paksa_prod_show_' . $key, true );
	return $val !== '0';
}
?>
<main id="main-content" tabindex="-1" class="pk-single-product">

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php get_template_part( 'template-parts/product/hero' ); ?>

		<?php if ( paksa_prod_section_visible( 'overview', $prod_id ) ) : ?>
			<?php get_template_part( 'template-parts/product/overview' ); ?>
		<?php endif; ?>

		<?php if ( paksa_prod_section_visible( 'features', $prod_id ) ) : ?>
			<?php get_template_part( 'template-parts/product/features' ); ?>
		<?php endif; ?>

		<?php if ( paksa_prod_section_visible( 'modules', $prod_id ) ) : ?>
			<?php get_template_part( 'template-parts/product/modules' ); ?>
		<?php endif; ?>

		<?php if ( paksa_prod_section_visible( 'benefits', $prod_id ) ) : ?>
			<?php get_template_part( 'template-parts/product/benefits' ); ?>
		<?php endif; ?>

		<?php if ( paksa_prod_section_visible( 'industries', $prod_id ) ) : ?>
			<?php get_template_part( 'template-parts/product/industries' ); ?>
		<?php endif; ?>

		<?php if ( paksa_prod_section_visible( 'faq', $prod_id ) ) : ?>
			<?php get_template_part( 'template-parts/product/faq' ); ?>
		<?php endif; ?>

		<?php if ( paksa_prod_section_visible( 'cta', $prod_id ) ) : ?>
			<?php get_template_part( 'template-parts/product/cta' ); ?>
		<?php endif; ?>

	</article>

</main>
<?php
get_footer();
