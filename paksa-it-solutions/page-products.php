<?php
/**
 * Paksa IT Solutions — Our Products / Solutions Page
 * Template Name: Products / Solutions
 *
 * Products are managed via Products & Solutions CPT in WP Admin.
 * Add/edit/remove products there — this page updates automatically.
 *
 * @package paksa-it-solutions
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();

/* ── Admin notice: explain CPT-driven page to editors ── */
if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) :
    $add_url  = admin_url( 'post-new.php?post_type=paksa_product' );
    $list_url = admin_url( 'edit.php?post_type=paksa_product' );
?>
<div style="background:#1d2327;color:#f0f0f1;padding:14px 24px;font-size:13px;display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
    <span style="color:#72aee6;font-weight:600;">&#9432; This page is powered by the Products &amp; Solutions CPT.</span>
    <span style="color:#a7aaad;">To add or edit products, use the WordPress admin — not this page editor.</span>
    <a href="<?php echo esc_url( $add_url ); ?>" style="background:#2271b1;color:#fff;padding:5px 14px;border-radius:4px;text-decoration:none;font-weight:600;">+ Add New Product</a>
    <a href="<?php echo esc_url( $list_url ); ?>" style="color:#72aee6;text-decoration:none;">View All Products &rarr;</a>
</div>
<?php endif; ?>

/* ── Query all published products ordered by menu_order ── */
$products_query = new WP_Query( array(
    'post_type'      => 'paksa_product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
) );

/* ── Accent palette cycles through products ── */
$accent_palette = array(
    array( 'color' => '#6192F8', 'bg' => 'rgba(97,146,248,0.08)',  'border' => 'rgba(97,146,248,0.2)' ),
    array( 'color' => '#8b5cf6', 'bg' => 'rgba(139,92,246,0.08)', 'border' => 'rgba(139,92,246,0.2)' ),
    array( 'color' => '#0ea5e9', 'bg' => 'rgba(14,165,233,0.08)',  'border' => 'rgba(14,165,233,0.2)' ),
    array( 'color' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.08)',  'border' => 'rgba(245,158,11,0.2)' ),
    array( 'color' => '#10b981', 'bg' => 'rgba(16,185,129,0.08)',  'border' => 'rgba(16,185,129,0.2)' ),
    array( 'color' => '#ec4899', 'bg' => 'rgba(236,72,153,0.08)',  'border' => 'rgba(236,72,153,0.2)' ),
);

$product_count = $products_query->found_posts;
?>
<main id="main-content" class="pk-products-page">

    <?php /* ── Breadcrumb ── */ ?>
    <nav class="pk-breadcrumb" aria-label="Breadcrumb">
        <div class="container">
            <ol class="pk-breadcrumb-list">
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                <li class="sep" aria-hidden="true">/</li>
                <li class="current" aria-current="page">Our Products</li>
            </ol>
        </div>
    </nav>

    <?php /* ── Hero ── */ ?>
    <section class="pk-prods-hero" aria-labelledby="pk-prods-h1">
        <div class="pk-prods-hero-dots" aria-hidden="true"></div>
        <div class="pk-prods-hero-glow" aria-hidden="true"></div>
        <div class="container">
            <div class="pk-prods-hero-inner">
                <div class="pk-prods-hero-content pk-fade-up">
                    <div class="pk-prods-hero-eyebrow">
                        <?php echo paksa_icon( 'erp', 14 ); ?>
                        Software Products by Paksa IT Solutions
                    </div>
                    <h1 id="pk-prods-h1" class="pk-prods-hero-h1">
                        Industry-Specific Software <span>Built in Pakistan</span>, Used Across the Region
                    </h1>
                    <p class="pk-prods-hero-desc">We do not just build custom software for clients — we build and maintain our own products. Each one was created to solve a real operational problem in a specific industry, with the depth and flexibility that generic SaaS platforms cannot match.</p>
                    <div class="pk-prods-hero-actions">
                        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="pk-btn-primary">
                            Request a Demo <?php echo paksa_icon( 'arrow', 16 ); ?>
                        </a>
                        <a href="#pk-prods-grid" class="pk-btn-ghost-dark">Browse Products</a>
                    </div>
                </div>
                <div class="pk-prods-hero-stats pk-fade-up" data-delay="150" aria-hidden="true">
                    <div class="pk-prods-stat">
                        <div class="pk-prods-stat-val"><?php echo esc_html( $product_count ); ?></div>
                        <div class="pk-prods-stat-label">Products in active use</div>
                    </div>
                    <div class="pk-prods-stat">
                        <div class="pk-prods-stat-val">500+</div>
                        <div class="pk-prods-stat-label">Businesses using our software</div>
                    </div>
                    <div class="pk-prods-stat">
                        <div class="pk-prods-stat-val">8+</div>
                        <div class="pk-prods-stat-label">Years of product development</div>
                    </div>
                    <div class="pk-prods-stat">
                        <div class="pk-prods-stat-val">100%</div>
                        <div class="pk-prods-stat-label">In-house built and supported</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php /* ── Why Our Products ── */ ?>
    <section class="pk-prods-why" aria-labelledby="pk-prods-why-h2">
        <div class="container">
            <div class="pk-prods-why-header pk-fade-up">
                <span class="pk-prods-section-label">Why Choose Our Products</span>
                <h2 id="pk-prods-why-h2" class="pk-prods-section-h2">Built for How Pakistani Businesses Actually Operate</h2>
                <p class="pk-prods-section-desc">International software is designed for international markets. Our products are built with local tax structures, local workflows, local languages and local support in mind.</p>
            </div>
            <div class="pk-prods-why-grid">
                <div class="pk-prods-why-card pk-fade-up">
                    <div class="pk-prods-why-icon"><?php echo paksa_icon( 'gear', 20 ); ?></div>
                    <h3 class="pk-prods-why-title">Configurable, Not Rigid</h3>
                    <p class="pk-prods-why-desc">Every business operates differently. Our products are built with configuration depth that lets you adapt workflows, approval chains, reporting structures and user roles to match how your business actually works.</p>
                </div>
                <div class="pk-prods-why-card pk-fade-up" data-delay="80">
                    <div class="pk-prods-why-icon"><?php echo paksa_icon( 'integration', 20 ); ?></div>
                    <h3 class="pk-prods-why-title">Integrates With Your Stack</h3>
                    <p class="pk-prods-why-desc">Our products expose APIs and connect with the tools you already use — accounting software, e-commerce platforms, payment gateways, communication tools and custom internal systems.</p>
                </div>
                <div class="pk-prods-why-card pk-fade-up" data-delay="160">
                    <div class="pk-prods-why-icon"><?php echo paksa_icon( 'shield', 20 ); ?></div>
                    <h3 class="pk-prods-why-title">Local Support, Real Humans</h3>
                    <p class="pk-prods-why-desc">Support from the team that built the software — based in Lahore, available in your timezone, responsive in Urdu or English. No ticket queues routed to overseas call centres.</p>
                </div>
                <div class="pk-prods-why-card pk-fade-up" data-delay="240">
                    <div class="pk-prods-why-icon"><?php echo paksa_icon( 'lightning', 20 ); ?></div>
                    <h3 class="pk-prods-why-title">Fast Implementation</h3>
                    <p class="pk-prods-why-desc">Most of our products are live within 2–4 weeks. We handle data migration, staff training and go-live support — so you are not spending months on implementation before seeing any value.</p>
                </div>
            </div>
        </div>
    </section>

    <?php /* ── Product Cards (CPT-driven) ── */ ?>
    <section class="pk-prods-grid-section" id="pk-prods-grid" aria-labelledby="pk-prods-grid-h2">
        <div class="container">
            <div class="pk-prods-grid-header pk-fade-up">
                <span class="pk-prods-section-label">Our Products</span>
                <h2 id="pk-prods-grid-h2" class="pk-prods-section-h2">
                    <?php echo esc_html( $product_count ); ?> Products. Multiple Industries. One Team Behind All of Them.
                </h2>
                <p class="pk-prods-section-desc">Each product is managed from the WordPress admin — add, edit or remove products under <strong>Products &amp; Solutions</strong> in the dashboard.</p>
            </div>

            <?php if ( $products_query->have_posts() ) : ?>
            <div class="pk-prods-grid">
                <?php
                $prod_index = 0;
                while ( $products_query->have_posts() ) :
                    $products_query->the_post();
                    $pid      = get_the_ID();
                    $ac       = $accent_palette[ $prod_index % count( $accent_palette ) ];
                    $delay    = ( $prod_index % 2 ) * 100;

                    /* Meta values */
                    $tagline       = paksa_prod_meta( 'tagline',        get_the_excerpt(), $pid );
                    $cat_label     = paksa_prod_meta( 'category_label', '', $pid );
                    $badge         = paksa_prod_meta( 'badge',          '', $pid );
                    $features_raw  = get_post_meta( $pid, '_paksa_prod_features_list', true );
                    $features      = paksa_parse_pipe_list( $features_raw );
                    $cta1_text     = paksa_prod_meta( 'hero_cta1_text', 'Learn More', $pid );
                    $cta1_url      = paksa_prod_meta_url( 'hero_cta1_url', get_permalink(), $pid );
                    $desc          = paksa_prod_meta( 'hero_description', get_the_excerpt(), $pid );
                    if ( ! $desc ) $desc = get_the_excerpt();

                    /* Category label fallback from taxonomy */
                    if ( ! $cat_label ) {
                        $terms = get_the_terms( $pid, 'paksa_product_cat' );
                        if ( $terms && ! is_wp_error( $terms ) ) {
                            $cat_label = $terms[0]->name;
                        }
                    }
                ?>
                <article
                    class="pk-prod-card pk-fade-up<?php echo $prod_index === 0 ? ' pk-prod-card--featured' : ''; ?>"
                    data-delay="<?php echo esc_attr( $delay ); ?>"
                    style="--prod-color:<?php echo esc_attr( $ac['color'] ); ?>;--prod-bg:<?php echo esc_attr( $ac['bg'] ); ?>;--prod-border:<?php echo esc_attr( $ac['border'] ); ?>;"
                    aria-labelledby="prod-<?php echo esc_attr( $pid ); ?>"
                >
                    <div class="pk-prod-card-top">
                        <div class="pk-prod-card-icon" aria-hidden="true">
                            <?php
                            /* Use featured image if set, otherwise icon */
                            if ( has_post_thumbnail() ) {
                                echo get_the_post_thumbnail( $pid, array( 40, 40 ), array( 'class' => 'pk-prod-card-thumb' ) );
                            } else {
                                echo paksa_icon( 'erp', 22 );
                            }
                            ?>
                        </div>
                        <div class="pk-prod-card-meta">
                            <?php if ( $cat_label ) : ?>
                                <span class="pk-prod-card-category"><?php echo esc_html( $cat_label ); ?></span>
                            <?php endif; ?>
                            <?php if ( $badge ) : ?>
                                <span class="pk-prod-card-badge"><?php echo esc_html( $badge ); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <h3 id="prod-<?php echo esc_attr( $pid ); ?>" class="pk-prod-card-name"><?php the_title(); ?></h3>
                    <?php if ( $tagline ) : ?>
                        <p class="pk-prod-card-tagline"><?php echo esc_html( $tagline ); ?></p>
                    <?php endif; ?>
                    <?php if ( $desc ) : ?>
                        <p class="pk-prod-card-desc"><?php echo esc_html( $desc ); ?></p>
                    <?php endif; ?>
                    <?php if ( ! empty( $features ) ) : ?>
                        <ul class="pk-prod-card-features" aria-label="Key features">
                            <?php foreach ( array_slice( $features, 0, 6 ) as $feat ) : ?>
                                <li><?php echo esc_html( $feat['title'] ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="pk-prod-card-footer">
                        <a href="<?php echo esc_url( $cta1_url ?: get_permalink() ); ?>" class="pk-prod-card-cta">
                            <?php echo esc_html( $cta1_text ); ?>
                            <?php echo paksa_icon( 'arrow', 14 ); ?>
                        </a>
                    </div>
                </article>
                <?php
                    $prod_index++;
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

            <?php else : ?>
            <div class="pk-prods-empty">
                <p>No products found. <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=paksa_product' ) ); ?>">Add your first product</a> in the WordPress admin.</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php /* ── Industries We Serve ── */ ?>
    <section class="pk-prods-industries" aria-labelledby="pk-prods-ind-h2">
        <div class="container">
            <div class="pk-prods-ind-header pk-fade-up">
                <span class="pk-prods-section-label">Industries</span>
                <h2 id="pk-prods-ind-h2" class="pk-prods-section-h2">Software That Understands Your Industry</h2>
                <p class="pk-prods-section-desc">Each product was built after working closely with businesses in that sector — not adapted from a generic template.</p>
            </div>
            <div class="pk-prods-ind-grid">
                <?php
                $industries = array(
                    array( 'icon' => 'erp',       'name' => 'Manufacturing & Production',  'desc' => 'Production planning, job costing, inventory and dispatch — all connected.' ),
                    array( 'icon' => 'retail',     'name' => 'Retail & Distribution',       'desc' => 'Multi-branch stock management, POS and supplier operations.' ),
                    array( 'icon' => 'tour',       'name' => 'Travel & Tourism',             'desc' => 'Booking management, itineraries, supplier costs and agency accounting.' ),
                    array( 'icon' => 'eventlogic', 'name' => 'Events & Conferences',         'desc' => 'Registration, ticketing, check-in and post-event reporting.' ),
                    array( 'icon' => 'poultry',    'name' => 'Poultry & Livestock',          'desc' => 'Flock tracking, feed management and farm profitability analysis.' ),
                    array( 'icon' => 'salon',      'name' => 'Beauty & Wellness',            'desc' => 'Appointments, staff commissions, POS and client loyalty programmes.' ),
                    array( 'icon' => 'healthcare', 'name' => 'Healthcare & Clinics',         'desc' => 'Patient records, appointment scheduling and billing management.' ),
                    array( 'icon' => 'ecommerce',  'name' => 'E-commerce & Wholesale',       'desc' => 'B2B ordering portals, custom pricing engines and fulfilment tracking.' ),
                );
                foreach ( $industries as $j => $ind ) :
                ?>
                <div class="pk-prods-ind-card pk-fade-up" data-delay="<?php echo esc_attr( ( $j % 4 ) * 60 ); ?>">
                    <div class="pk-prods-ind-icon" aria-hidden="true"><?php echo paksa_icon( $ind['icon'], 20 ); ?></div>
                    <h3 class="pk-prods-ind-name"><?php echo esc_html( $ind['name'] ); ?></h3>
                    <p class="pk-prods-ind-desc"><?php echo esc_html( $ind['desc'] ); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php /* ── Implementation Process ── */ ?>
    <section class="pk-prods-process" aria-labelledby="pk-prods-proc-h2">
        <div class="container">
            <div class="pk-prods-proc-header pk-fade-up">
                <span class="pk-prods-section-label" style="color:rgba(255,255,255,0.45);">Implementation</span>
                <h2 id="pk-prods-proc-h2" class="pk-prods-section-h2" style="color:#fff;">Live in Weeks, Not Months</h2>
                <p class="pk-prods-section-desc" style="color:rgba(255,255,255,0.5);">We handle the full implementation — from initial setup to staff training and go-live support. Most clients are running on their new system within 2–4 weeks.</p>
            </div>
            <div class="pk-prods-proc-steps">
                <?php
                $steps = array(
                    array( 'num' => '01', 'title' => 'Discovery Call',     'desc' => 'We understand your current processes, pain points and requirements. No sales pitch — just an honest conversation about whether our product is the right fit.' ),
                    array( 'num' => '02', 'title' => 'Configuration',      'desc' => 'We configure the product to match your workflows — chart of accounts, approval chains, user roles, reporting structures and integrations with your existing tools.' ),
                    array( 'num' => '03', 'title' => 'Data Migration',     'desc' => 'We migrate your existing data — customers, suppliers, products, opening balances — so you start with a complete system, not an empty one.' ),
                    array( 'num' => '04', 'title' => 'Training & Go-Live', 'desc' => 'We train your team on the system and support your go-live day. We stay available for the first 30 days to handle any questions or adjustments.' ),
                    array( 'num' => '05', 'title' => 'Ongoing Support',    'desc' => 'Dedicated support from the team that built the software. Updates, new features and technical help — available in Urdu or English, in your timezone.' ),
                );
                foreach ( $steps as $k => $step ) :
                ?>
                <div class="pk-prods-proc-step pk-fade-up" data-delay="<?php echo esc_attr( ( $k % 3 ) * 80 ); ?>">
                    <div class="pk-prods-proc-num" aria-hidden="true"><?php echo esc_html( $step['num'] ); ?></div>
                    <div class="pk-prods-proc-body">
                        <h3 class="pk-prods-proc-title"><?php echo esc_html( $step['title'] ); ?></h3>
                        <p class="pk-prods-proc-desc"><?php echo esc_html( $step['desc'] ); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php /* ── Comparison Table ── */ ?>
    <section class="pk-prods-compare" aria-labelledby="pk-prods-cmp-h2">
        <div class="container">
            <div class="pk-prods-cmp-header pk-fade-up">
                <span class="pk-prods-section-label">Why Not Generic SaaS?</span>
                <h2 id="pk-prods-cmp-h2" class="pk-prods-section-h2">What You Get With Paksa vs Off-the-Shelf Software</h2>
            </div>
            <div class="pk-prods-cmp-table pk-fade-up" data-delay="80">
                <div class="pk-prods-cmp-head">
                    <div class="pk-prods-cmp-col-label">Feature</div>
                    <div class="pk-prods-cmp-col paksa">Paksa Products</div>
                    <div class="pk-prods-cmp-col generic">Generic SaaS</div>
                </div>
                <?php
                $rows = array(
                    'Built for Pakistani tax & compliance',
                    'Urdu language support',
                    'Local support team in your timezone',
                    'Configurable to your exact workflows',
                    'No per-user licensing fees',
                    'Data stays in Pakistan',
                    'Custom feature development available',
                    'Implementation in 2–4 weeks',
                );
                foreach ( $rows as $row ) : ?>
                <div class="pk-prods-cmp-row">
                    <div class="pk-prods-cmp-col-label"><?php echo esc_html( $row ); ?></div>
                    <div class="pk-prods-cmp-col paksa"><span class="pk-prods-cmp-yes" aria-label="Yes"><?php echo paksa_icon( 'check', 16 ); ?></span></div>
                    <div class="pk-prods-cmp-col generic"><span class="pk-prods-cmp-no" aria-label="No">&#x2715;</span></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php /* ── Custom Software CTA ── */ ?>
    <section class="pk-prods-custom" aria-labelledby="pk-prods-custom-h2">
        <div class="pk-prods-custom-dots" aria-hidden="true"></div>
        <div class="container">
            <div class="pk-prods-custom-inner pk-fade-up">
                <div class="pk-prods-custom-left">
                    <span class="pk-prods-section-label" style="color:rgba(255,255,255,0.45);">Don't See What You Need?</span>
                    <h2 id="pk-prods-custom-h2" class="pk-prods-custom-h2">We Also Build <span>Custom Software</span> From Scratch</h2>
                    <p class="pk-prods-custom-desc">If none of our products fit your industry or your requirements are too specific for an off-the-shelf solution, our software development team builds custom platforms, internal tools and enterprise systems tailored precisely to your business.</p>
                    <ul class="pk-prods-custom-points">
                        <li><?php echo paksa_icon( 'check', 14 ); ?> Full-stack web applications and portals</li>
                        <li><?php echo paksa_icon( 'check', 14 ); ?> Custom ERP and operations software</li>
                        <li><?php echo paksa_icon( 'check', 14 ); ?> AI-integrated business tools</li>
                        <li><?php echo paksa_icon( 'check', 14 ); ?> API development and system integration</li>
                    </ul>
                </div>
                <div class="pk-prods-custom-right">
                    <a href="<?php echo esc_url( home_url( '/services/software-development/' ) ); ?>" class="pk-btn-primary">
                        Explore Custom Development <?php echo paksa_icon( 'arrow', 16 ); ?>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="pk-btn-ghost-inv">Talk to Our Team</a>
                </div>
            </div>
        </div>
    </section>

    <?php /* ── Final CTA ── */ ?>
    <section class="pk-prods-final-cta" aria-labelledby="pk-prods-fcta-h2">
        <div class="container">
            <div class="pk-prods-fcta-inner pk-fade-up">
                <h2 id="pk-prods-fcta-h2" class="pk-prods-fcta-h2">Ready to See It in Action?</h2>
                <p class="pk-prods-fcta-desc">Book a free 30-minute demo. We will show you the product that fits your industry, walk through your specific use case and give you an honest assessment of whether it is the right fit — no pressure, no sales script.</p>
                <div class="pk-prods-fcta-actions">
                    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="pk-btn-primary pk-btn-lg">
                        Book a Free Demo <?php echo paksa_icon( 'arrow', 16 ); ?>
                    </a>
                    <a href="tel:+923057772572" class="pk-prods-fcta-phone">
                        <?php echo paksa_icon( 'lightning', 16 ); ?>
                        +92 305 777 2572
                    </a>
                </div>
                <p class="pk-prods-fcta-note">No commitment required &mdash; just an honest conversation about your business needs.</p>
            </div>
        </div>
    </section>

</main>
<?php get_footer(); ?>
