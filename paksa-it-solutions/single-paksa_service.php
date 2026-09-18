<?php
/**
 * Paksa IT Solutions — Single Service Template
 * Template: single-paksa_service.php
 *
 * All content is managed via the "Service Details" meta box in WP Admin.
 * Go to Services > All Services > Edit to update any service page.
 *
 * @package paksa-it-solutions
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
if ( ! have_posts() ) { get_footer(); return; }
the_post();

$post_id = get_the_ID();
$slug    = get_post_field( 'post_name', $post_id );
$title   = get_the_title();

/* ── Helper: read _paksa_svc_ meta ── */
function _svc( $key, $fallback = '' ) {
    global $post_id;
    $v = get_post_meta( $post_id, '_paksa_svc_' . $key, true );
    return ( $v !== '' && $v !== false ) ? $v : $fallback;
}

/* ── Helper: parse "Title | Desc" textarea into array ── */
function _svc_pipe( $key, $fallback_raw = '' ) {
    global $post_id;
    $raw = get_post_meta( $post_id, '_paksa_svc_' . $key, true );
    if ( ! $raw ) $raw = $fallback_raw;
    if ( ! $raw ) return array();
    $items = array();
    foreach ( array_filter( array_map( 'trim', explode( "\n", $raw ) ) ) as $line ) {
        $parts   = array_map( 'trim', explode( '|', $line, 2 ) );
        $items[] = array(
            'title' => sanitize_text_field( $parts[0] ),
            'desc'  => isset( $parts[1] ) ? sanitize_text_field( $parts[1] ) : '',
        );
    }
    return $items;
}

/* ── Helper: parse "Q | A" FAQ textarea ── */
function _svc_faq( $key ) {
    global $post_id;
    $raw = get_post_meta( $post_id, '_paksa_svc_' . $key, true );
    if ( ! $raw ) return array();
    $items = array();
    foreach ( array_filter( array_map( 'trim', explode( "\n", $raw ) ) ) as $line ) {
        $parts = array_map( 'trim', explode( '|', $line, 2 ) );
        if ( ! empty( $parts[0] ) && ! empty( $parts[1] ) ) {
            $items[] = array( 'q' => sanitize_text_field( $parts[0] ), 'a' => sanitize_text_field( $parts[1] ) );
        }
    }
    return $items;
}

/* ── Read all meta ── */
$eyebrow    = _svc( 'hero_eyebrow',     _svc( 'category_label', 'Our Services' ) );
$hero_h1    = _svc( 'hero_heading',     $title );
$hero_desc  = _svc( 'hero_description', get_the_excerpt() );
$stat1_val  = _svc( 'stat1_val',  '50+' );
$stat1_lbl  = _svc( 'stat1_label','Projects delivered' );
$stat2_val  = _svc( 'stat2_val',  '8+' );
$stat2_lbl  = _svc( 'stat2_label','Industries served' );
$stat3_val  = _svc( 'stat3_val',  '100%' );
$stat3_lbl  = _svc( 'stat3_label','In-house team' );
$stat4_val  = _svc( 'stat4_val',  '5★' );
$stat4_lbl  = _svc( 'stat4_label','Client satisfaction' );

$trust_raw  = _svc( 'trust_items', "In-house team — no outsourcing\nProduction-ready delivery\nOngoing support included" );
$trust      = array_filter( array_map( 'trim', explode( "\n", $trust_raw ) ) );

$ov_label   = _svc( 'overview_eyebrow', 'Overview' );
$ov_h2      = _svc( 'overview_heading', 'About This Service' );
$ov_raw     = _svc( 'overview_content', get_the_excerpt() );
$ov_paras   = array_filter( array_map( 'trim', explode( "\n", $ov_raw ) ) );

$ov_points  = _svc_pipe( 'overview_points' );

$caps_h2    = _svc( 'features_heading', 'What We Build' );
$caps_desc  = _svc( 'features_eyebrow', '' );
$caps       = _svc_pipe( 'features_list' );

/* Capabilities with metrics: stored as "Title | Desc | metric_val | metric_label | del1; del2; del3; del4" */
$caps_rich_raw = get_post_meta( $post_id, '_paksa_svc_capabilities', true );
$caps_rich = array();
if ( $caps_rich_raw ) {
    foreach ( array_filter( array_map( 'trim', explode( "\n", $caps_rich_raw ) ) ) as $line ) {
        $p = array_map( 'trim', explode( '|', $line ) );
        $caps_rich[] = array(
            'title'        => isset( $p[0] ) ? sanitize_text_field( $p[0] ) : '',
            'desc'         => isset( $p[1] ) ? sanitize_text_field( $p[1] ) : '',
            'metric_val'   => isset( $p[2] ) ? sanitize_text_field( $p[2] ) : '',
            'metric_label' => isset( $p[3] ) ? sanitize_text_field( $p[3] ) : '',
            'deliverables' => isset( $p[4] ) ? array_map( 'trim', explode( ';', $p[4] ) ) : array(),
        );
    }
}

$usecases_h2   = _svc( 'usecases_heading', 'Where Businesses Use This' );
$usecases_desc = _svc( 'usecases_desc', '' );
$usecases      = _svc_pipe( 'usecases' );

/* Tech stack: stored as "Group | tag1; tag2; tag3" one per line */
$tech_raw = get_post_meta( $post_id, '_paksa_svc_tech_stack', true );
$tech = array();
if ( $tech_raw ) {
    foreach ( array_filter( array_map( 'trim', explode( "\n", $tech_raw ) ) ) as $line ) {
        $p = array_map( 'trim', explode( '|', $line, 2 ) );
        if ( ! empty( $p[0] ) && ! empty( $p[1] ) ) {
            $tech[ sanitize_text_field( $p[0] ) ] = array_map( 'trim', explode( ';', $p[1] ) );
        }
    }
}

$faq  = _svc_faq( 'faq_items' );

$cta_h2   = _svc( 'cta_heading',     'Ready to get started?' );
$cta_desc = _svc( 'cta_description', 'Tell us what you are trying to solve. We will give you an honest assessment and a clear path forward.' );
$cta_btn1 = _svc( 'cta_btn1_text',   'Book a Free Discovery Call' );
$cta_url1 = _svc( 'cta_btn1_url',    home_url( '/contact/' ) );
$cta_btn2 = _svc( 'cta_btn2_text',   'info@paksa.com.pk' );
$cta_url2 = _svc( 'cta_btn2_url',    'mailto:info@paksa.com.pk' );

/* Related services: stored as "Title | /url/" one per line */
$related_raw = get_post_meta( $post_id, '_paksa_svc_related_links', true );
$related = array();
if ( $related_raw ) {
    foreach ( array_filter( array_map( 'trim', explode( "\n", $related_raw ) ) ) as $line ) {
        $p = array_map( 'trim', explode( '|', $line, 2 ) );
        if ( ! empty( $p[0] ) ) {
            $related[] = array( 'title' => sanitize_text_field( $p[0] ), 'url' => isset( $p[1] ) ? esc_url_raw( $p[1] ) : '' );
        }
    }
}

/* Use rich caps if available, fall back to simple caps */
$display_caps = ! empty( $caps_rich ) ? $caps_rich : array_map( function( $c ) {
    return array( 'title' => $c['title'], 'desc' => $c['desc'], 'metric_val' => '', 'metric_label' => '', 'deliverables' => array() );
}, $caps );
?>
<main id="main-content" class="pk-single-service">

    <?php /* ── Admin notice for editors ── */
    if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) :
        $edit_url = get_edit_post_link( $post_id );
    ?>
    <div style="background:#1d2327;color:#f0f0f1;padding:12px 24px;font-size:13px;display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
        <span style="color:#72aee6;font-weight:600;">&#9432; Edit this service page content in the WordPress admin.</span>
        <a href="<?php echo esc_url( $edit_url ); ?>" style="background:#2271b1;color:#fff;padding:5px 14px;border-radius:4px;text-decoration:none;font-weight:600;">Edit Service Details &rarr;</a>
        <span style="color:#8c8f94;font-size:12px;">Use the "Service Details" meta box — scroll down past the block editor.</span>
    </div>
    <?php endif; ?>

    <?php /* ── Breadcrumb ── */ ?>
    <nav class="pk-breadcrumb" aria-label="Breadcrumb">
        <div class="container">
            <ol class="pk-breadcrumb-list">
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                <li class="sep" aria-hidden="true">/</li>
                <li><a href="<?php echo esc_url( home_url( '/our-services/' ) ); ?>">Services</a></li>
                <li class="sep" aria-hidden="true">/</li>
                <li class="current" aria-current="page"><?php echo esc_html( $title ); ?></li>
            </ol>
        </div>
    </nav>

    <?php /* ── Hero ── */ ?>
    <section class="pk-ssvc-hero" aria-labelledby="pk-ssvc-h1">
        <div class="pk-ssvc-hero-dots" aria-hidden="true"></div>
        <div class="pk-ssvc-hero-glow" aria-hidden="true"></div>
        <div class="container">
            <div class="pk-ssvc-hero-inner">
                <div class="pk-ssvc-hero-left pk-fade-up">
                    <div class="pk-ssvc-hero-eyebrow">
                        <?php echo paksa_icon( 'ai', 14 ); ?>
                        <?php echo esc_html( $eyebrow ); ?>
                    </div>
                    <h1 id="pk-ssvc-h1" class="pk-ssvc-hero-h1"><?php echo esc_html( $hero_h1 ); ?></h1>
                    <p class="pk-ssvc-hero-desc"><?php echo esc_html( $hero_desc ); ?></p>
                    <div class="pk-ssvc-hero-actions">
                        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="pk-btn-primary">
                            Start a Conversation <?php echo paksa_icon( 'arrow', 16 ); ?>
                        </a>
                        <?php if ( ! empty( $display_caps ) ) : ?>
                            <a href="#pk-ssvc-caps" class="pk-btn-ghost-inv">See Capabilities</a>
                        <?php endif; ?>
                    </div>
                    <?php if ( ! empty( $trust ) ) : ?>
                    <div class="pk-ssvc-hero-trust">
                        <?php foreach ( $trust as $t ) : ?>
                            <span class="pk-ssvc-hero-trust-item">
                                <?php echo paksa_icon( 'check', 14 ); ?>
                                <?php echo esc_html( $t ); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="pk-ssvc-hero-stats pk-fade-up" data-delay="150" aria-hidden="true">
                    <div class="pk-ssvc-stat-card">
                        <div class="pk-ssvc-stat-value"><?php echo esc_html( $stat1_val ); ?></div>
                        <div class="pk-ssvc-stat-label"><?php echo esc_html( $stat1_lbl ); ?></div>
                    </div>
                    <div class="pk-ssvc-stat-card">
                        <div class="pk-ssvc-stat-value"><?php echo esc_html( $stat2_val ); ?></div>
                        <div class="pk-ssvc-stat-label"><?php echo esc_html( $stat2_lbl ); ?></div>
                    </div>
                    <div class="pk-ssvc-stat-card">
                        <div class="pk-ssvc-stat-value"><?php echo esc_html( $stat3_val ); ?></div>
                        <div class="pk-ssvc-stat-label"><?php echo esc_html( $stat3_lbl ); ?></div>
                    </div>
                    <div class="pk-ssvc-stat-card">
                        <div class="pk-ssvc-stat-value"><?php echo esc_html( $stat4_val ); ?></div>
                        <div class="pk-ssvc-stat-label"><?php echo esc_html( $stat4_lbl ); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php /* ── Overview ── */ ?>
    <section class="pk-ssvc-overview" aria-labelledby="pk-ssvc-overview-h2">
        <div class="container">
            <div class="pk-ssvc-overview-inner">
                <div class="pk-fade-up">
                    <span class="pk-ssvc-overview-label"><?php echo esc_html( $ov_label ); ?></span>
                    <h2 id="pk-ssvc-overview-h2" class="pk-ssvc-overview-h2"><?php echo esc_html( $ov_h2 ); ?></h2>
                    <div class="pk-ssvc-overview-body">
                        <?php if ( ! empty( $ov_paras ) ) : ?>
                            <?php foreach ( $ov_paras as $para ) : ?>
                                <p><?php echo esc_html( $para ); ?></p>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <?php the_content(); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ( ! empty( $ov_points ) ) : ?>
                <ul class="pk-ssvc-overview-points pk-fade-up" data-delay="100">
                    <?php foreach ( $ov_points as $pt ) : ?>
                        <li class="pk-ssvc-overview-point">
                            <div class="pk-ssvc-overview-point-icon" aria-hidden="true">
                                <?php echo paksa_icon( 'check', 18 ); ?>
                            </div>
                            <div>
                                <p class="pk-ssvc-overview-point-title"><?php echo esc_html( $pt['title'] ); ?></p>
                                <?php if ( $pt['desc'] ) : ?>
                                    <p class="pk-ssvc-overview-point-desc"><?php echo esc_html( $pt['desc'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php /* ── Capabilities ── */ ?>
    <?php if ( ! empty( $display_caps ) ) : ?>
    <section class="pk-ssvc-caps" id="pk-ssvc-caps" aria-labelledby="pk-ssvc-caps-h2">
        <div class="container">
            <div class="pk-ssvc-section-header pk-fade-up">
                <span class="pk-ssvc-section-label">Capabilities</span>
                <h2 id="pk-ssvc-caps-h2" class="pk-ssvc-section-h2"><?php echo esc_html( $caps_h2 ); ?></h2>
                <?php if ( $caps_desc ) : ?>
                    <p class="pk-ssvc-section-desc"><?php echo esc_html( $caps_desc ); ?></p>
                <?php endif; ?>
            </div>
            <div class="pk-ssvc-caps-grid">
                <?php foreach ( $display_caps as $i => $cap ) : ?>
                <div class="pk-ssvc-cap-card pk-fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>">
                    <div class="pk-ssvc-cap-top">
                        <div class="pk-ssvc-cap-icon" aria-hidden="true"><?php echo paksa_icon( 'gear', 20 ); ?></div>
                        <?php if ( ! empty( $cap['metric_val'] ) ) : ?>
                        <div class="pk-ssvc-cap-metric">
                            <div class="pk-ssvc-cap-metric-val"><?php echo esc_html( $cap['metric_val'] ); ?></div>
                            <div class="pk-ssvc-cap-metric-label"><?php echo esc_html( $cap['metric_label'] ); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <h3 class="pk-ssvc-cap-title"><?php echo esc_html( $cap['title'] ); ?></h3>
                    <?php if ( $cap['desc'] ) : ?>
                        <p class="pk-ssvc-cap-desc"><?php echo esc_html( $cap['desc'] ); ?></p>
                    <?php endif; ?>
                    <?php if ( ! empty( $cap['deliverables'] ) ) : ?>
                    <ul class="pk-ssvc-cap-deliverables" aria-label="Deliverables">
                        <?php foreach ( $cap['deliverables'] as $d_item ) : ?>
                            <?php if ( trim( $d_item ) ) : ?>
                                <li><?php echo esc_html( trim( $d_item ) ); ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php /* ── Use Cases ── */ ?>
    <?php if ( ! empty( $usecases ) ) : ?>
    <section class="pk-ssvc-usecases" aria-labelledby="pk-ssvc-uc-h2">
        <div class="container">
            <div class="pk-ssvc-section-header pk-fade-up">
                <span class="pk-ssvc-section-label">Real Applications</span>
                <h2 id="pk-ssvc-uc-h2" class="pk-ssvc-section-h2"><?php echo esc_html( $usecases_h2 ); ?></h2>
                <?php if ( $usecases_desc ) : ?>
                    <p class="pk-ssvc-section-desc"><?php echo esc_html( $usecases_desc ); ?></p>
                <?php endif; ?>
            </div>
            <div class="pk-ssvc-usecases-grid">
                <?php foreach ( $usecases as $i => $uc ) : ?>
                <div class="pk-ssvc-usecase pk-fade-up" data-delay="<?php echo esc_attr( ( $i % 2 ) * 80 ); ?>">
                    <div class="pk-ssvc-usecase-num" aria-hidden="true"><?php printf( '%02d', $i + 1 ); ?></div>
                    <div>
                        <h3 class="pk-ssvc-usecase-title"><?php echo esc_html( $uc['title'] ); ?></h3>
                        <?php if ( $uc['desc'] ) : ?>
                            <p class="pk-ssvc-usecase-desc"><?php echo esc_html( $uc['desc'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php /* ── Tech Stack ── */ ?>
    <?php if ( ! empty( $tech ) ) : ?>
    <section class="pk-ssvc-tech" aria-labelledby="pk-ssvc-tech-h2">
        <div class="container">
            <div class="pk-ssvc-section-header pk-fade-up">
                <span class="pk-ssvc-section-label">Technology</span>
                <h2 id="pk-ssvc-tech-h2" class="pk-ssvc-section-h2">Tools &amp; Technologies We Use</h2>
            </div>
            <div class="pk-ssvc-tech-groups pk-fade-up" data-delay="100">
                <?php foreach ( $tech as $group => $tags ) : ?>
                <div class="pk-ssvc-tech-row">
                    <p class="pk-ssvc-tech-label"><?php echo esc_html( $group ); ?></p>
                    <ul class="pk-ssvc-tech-tags">
                        <?php foreach ( $tags as $tag ) : ?>
                            <?php if ( trim( $tag ) ) : ?>
                                <li class="pk-ssvc-tech-tag"><?php echo esc_html( trim( $tag ) ); ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php /* ── FAQ ── */ ?>
    <?php if ( ! empty( $faq ) ) : ?>
    <section class="pk-ssvc-faq" aria-labelledby="pk-ssvc-faq-h2">
        <div class="container">
            <div class="pk-ssvc-section-header pk-fade-up">
                <span class="pk-ssvc-section-label">FAQ</span>
                <h2 id="pk-ssvc-faq-h2" class="pk-ssvc-section-h2">Questions We Get Asked</h2>
                <p class="pk-ssvc-section-desc">Straight answers — no sales language.</p>
            </div>
            <div class="pk-ssvc-faq-list pk-fade-up" data-delay="100">
                <?php foreach ( $faq as $i => $item ) : ?>
                <div class="pk-ssvc-faq-item">
                    <button class="pk-ssvc-faq-q" aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-controls="faq-a-<?php echo esc_attr( $post_id . '-' . $i ); ?>">
                        <?php echo esc_html( $item['q'] ); ?>
                        <svg class="pk-ssvc-faq-chevron" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div id="faq-a-<?php echo esc_attr( $post_id . '-' . $i ); ?>" class="pk-ssvc-faq-a<?php echo $i === 0 ? ' is-open' : ''; ?>"><?php echo esc_html( $item['a'] ); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php /* ── CTA ── */ ?>
    <section class="pk-ssvc-cta" aria-labelledby="pk-ssvc-cta-h2">
        <div class="pk-ssvc-cta-dots" aria-hidden="true"></div>
        <div class="container">
            <div class="pk-ssvc-cta-inner">
                <div class="pk-fade-up">
                    <h2 id="pk-ssvc-cta-h2" class="pk-ssvc-cta-h2"><?php echo esc_html( $cta_h2 ); ?></h2>
                    <p class="pk-ssvc-cta-desc"><?php echo esc_html( $cta_desc ); ?></p>
                </div>
                <div class="pk-ssvc-cta-actions pk-fade-up" data-delay="100">
                    <a href="<?php echo esc_url( $cta_url1 ); ?>" class="pk-btn-primary">
                        <?php echo esc_html( $cta_btn1 ); ?>
                        <?php echo paksa_icon( 'arrow', 16 ); ?>
                    </a>
                    <a href="<?php echo esc_url( $cta_url2 ); ?>" class="pk-btn-ghost-inv"><?php echo esc_html( $cta_btn2 ); ?></a>
                </div>
            </div>
        </div>
    </section>

    <?php /* ── Related Services ── */ ?>
    <?php if ( ! empty( $related ) ) : ?>
    <section class="pk-ssvc-related" aria-label="Related services">
        <div class="container">
            <span class="pk-ssvc-related-label">Also from Paksa IT Solutions</span>
            <div class="pk-ssvc-related-grid">
                <?php foreach ( $related as $rel ) : ?>
                <a href="<?php echo esc_url( $rel['url'] ? home_url( $rel['url'] ) : '#' ); ?>" class="pk-ssvc-related-link">
                    <?php echo paksa_icon( 'arrow', 14 ); ?>
                    <?php echo esc_html( $rel['title'] ); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</main>
<?php get_footer(); ?>
