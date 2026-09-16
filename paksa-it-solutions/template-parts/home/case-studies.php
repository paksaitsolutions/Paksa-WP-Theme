<?php
/**
 * Paksa IT Solutions — Homepage: Case Studies / Selected Work
 *
 * Content: apply_filters( 'paksa_case_studies_items', array() )
 * Default is empty — section is hidden until real case studies are added via the filter.
 * No fabricated case study data.
 *
 * To add case studies, hook into 'paksa_case_studies_items' from a child theme or plugin:
 *   add_filter( 'paksa_case_studies_items', function( $items ) {
 *       $items[] = array(
 *           'title'     => 'Project Title',
 *           'industry'  => 'Industry',
 *           'challenge' => 'The challenge description.',
 *           'solution'  => 'The solution description.',
 *           'url'       => 'https://example.com/case-study',
 *       );
 *       return $items;
 *   } );
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Filter: paksa_case_studies_items
 * Default empty — section hidden until real case studies are provided.
 */
$case_studies = apply_filters( 'paksa_case_studies_items', array() );

if ( empty( $case_studies ) ) {
    return;
}
?>
<section class="section pk-case-studies" aria-labelledby="pk-case-studies-heading">
    <div class="container">
        <header class="section-header">
            <span class="eyebrow"><?php esc_html_e( 'Selected Work', 'paksa-it-solutions' ); ?></span>
            <h2 id="pk-case-studies-heading"><?php esc_html_e( 'Technology Applied to Real Business Problems', 'paksa-it-solutions' ); ?></h2>
        </header>

        <div class="pk-case-studies-grid">
            <?php foreach ( $case_studies as $index => $study ) : ?>
                <article class="pk-case-study-card pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( $index * 100 ); ?>">
                    <div class="pk-case-study-meta">
                        <span class="pk-case-study-industry"><?php echo esc_html( $study['industry'] ); ?></span>
                    </div>
                    <h3 class="pk-case-study-title"><?php echo esc_html( $study['title'] ); ?></h3>
                    <div class="pk-case-study-details">
                        <div class="pk-case-study-block">
                            <span class="pk-case-study-label"><?php esc_html_e( 'Challenge', 'paksa-it-solutions' ); ?></span>
                            <p><?php echo esc_html( $study['challenge'] ); ?></p>
                        </div>
                        <div class="pk-case-study-block">
                            <span class="pk-case-study-label"><?php esc_html_e( 'Solution', 'paksa-it-solutions' ); ?></span>
                            <p><?php echo esc_html( $study['solution'] ); ?></p>
                        </div>
                    </div>
                    <?php if ( ! empty( $study['url'] ) ) : ?>
                        <a href="<?php echo esc_url( $study['url'] ); ?>" class="pk-case-study-link">
                            <?php esc_html_e( 'View Case Study', 'paksa-it-solutions' ); ?>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <line x1="3" y1="8" x2="13" y2="8"></line>
                                <polyline points="9,4 13,8 9,12"></polyline>
                            </svg>
                        </a>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
