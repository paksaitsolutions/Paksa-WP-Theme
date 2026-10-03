<?php
/**
 * Paksa IT Solutions — Open Source Page Template
 *
 * Template Name: Open Source Projects
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$page_id = get_the_ID();

// Projects data — stored as JSON meta or hardcoded fallback
$projects_raw = get_post_meta( $page_id, '_paksa_os_projects', true );
$projects     = $projects_raw ? json_decode( $projects_raw, true ) : [];

// Why section
$why_heading = get_post_meta( $page_id, '_paksa_os_why_heading', true ) ?: 'Why We Open Source Our Projects';
$why_content = get_post_meta( $page_id, '_paksa_os_why_content', true );

// Palette for project cards
$palettes = [
    [ 'bg' => '#eef3fe', 'icon' => '#6192f8', 'accent' => '#6192f8' ],
    [ 'bg' => '#edfaf3', 'icon' => '#12b76a', 'accent' => '#12b76a' ],
    [ 'bg' => '#fff8ec', 'icon' => '#f79009', 'accent' => '#f79009' ],
    [ 'bg' => '#f3f0ff', 'icon' => '#7c3aed', 'accent' => '#7c3aed' ],
    [ 'bg' => '#e8f9fb', 'icon' => '#0891b2', 'accent' => '#0891b2' ],
    [ 'bg' => '#fdf2f8', 'icon' => '#e11d8f', 'accent' => '#e11d8f' ],
];

$project_icons = [
    // Finance
    '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
    // Data/PDF
    '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>',
    // Cart/WooCommerce
    '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>',
    // AI/Video
    '<polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>',
    // Expense/Wallet
    '<rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>',
];
?>
<main id="main-content" tabindex="-1" class="pk-opensource-page">

    <!-- ── HERO ── -->
    <section class="pk-opensource-hero">
        <div class="pk-opensource-hero__dots" aria-hidden="true"></div>
        <div class="pk-opensource-hero__glow" aria-hidden="true"></div>
        <div class="container">
            <div class="pk-opensource-hero__inner">
                <div class="pk-opensource-hero__content">
                    <span class="pk-opensource-hero__eyebrow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        Paksa Engineering Labs
                    </span>
                    <h1 class="pk-opensource-hero__heading pk-animate-on-scroll" data-anim="fade-up">
                        Open Source Enterprise Software &amp; AI Projects
                    </h1>
                    <p class="pk-opensource-hero__desc pk-animate-on-scroll" data-anim="fade-up" data-delay="80">
                        At Paksa IT Solutions, we believe in innovation, collaboration, and the power of open-source technology. Our GitHub repositories showcase a growing collection of enterprise software, AI systems, automation tools, and industry-specific products developed to solve real-world challenges.
                    </p>
                    <div class="pk-opensource-hero__actions pk-animate-on-scroll" data-anim="fade-up" data-delay="120">
                        <a href="https://github.com/paksaitsolutions" target="_blank" rel="noopener noreferrer" class="pk-btn-primary">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                            View on GitHub
                        </a>
                        <a href="/contact-us/" class="pk-btn-ghost-inv">Collaborate With Us</a>
                    </div>
                </div>
                <div class="pk-opensource-hero__stats pk-animate-on-scroll" data-anim="fade-up" data-delay="160">
                    <div class="pk-opensource-hero__stat">
                        <div class="pk-opensource-hero__stat-val">5+</div>
                        <div class="pk-opensource-hero__stat-label">Open Source Projects</div>
                    </div>
                    <div class="pk-opensource-hero__stat">
                        <div class="pk-opensource-hero__stat-val">AI</div>
                        <div class="pk-opensource-hero__stat-label">Powered Systems</div>
                    </div>
                    <div class="pk-opensource-hero__stat pk-opensource-hero__stat--featured">
                        <div class="pk-opensource-hero__stat-val">Free</div>
                        <div class="pk-opensource-hero__stat-label">Open Source · MIT Licensed · Community Driven</div>
                    </div>
                    <div class="pk-opensource-hero__stat">
                        <div class="pk-opensource-hero__stat-val">ERP</div>
                        <div class="pk-opensource-hero__stat-label">Enterprise Grade</div>
                    </div>
                    <div class="pk-opensource-hero__stat">
                        <div class="pk-opensource-hero__stat-val">WP</div>
                        <div class="pk-opensource-hero__stat-label">WordPress Plugins</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── PROJECTS GRID ── -->
    <section class="section pk-opensource-projects" aria-labelledby="pk-os-projects-heading">
        <div class="container">
            <div class="section-header">
                <span class="pk-about-eyebrow">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    Popular Repositories
                </span>
                <h2 id="pk-os-projects-heading">What We Offer</h2>
                <p>Explore our open-source repositories — enterprise software, AI tools, WordPress plugins, and automation systems built to solve real business problems.</p>
            </div>

            <div class="pk-os-projects-grid">
                <?php
                // Use meta projects if available, otherwise use hardcoded defaults
                $display_projects = ! empty( $projects ) ? $projects : [
                    [
                        'name'    => 'Paksa Financial System',
                        'desc'    => 'A comprehensive, enterprise-grade financial management platform designed to streamline all aspects of business finance. Built with modern technologies and best practices, it provides a robust, scalable solution for organizations of all sizes.',
                        'tags'    => ['Finance', 'ERP', 'Enterprise'],
                        'github'  => 'https://github.com/paksaitsolutions',
                        'icon_i'  => 0,
                    ],
                    [
                        'name'    => 'Lab-PDF-To-Dataset',
                        'desc'    => 'An intelligent data extraction system that automatically converts medical laboratory test reports (PDF and Word documents) into structured, machine-readable CSV and Excel datasets. Eliminates tedious manual data entry for analysis and research.',
                        'tags'    => ['AI', 'Data Extraction', 'Healthcare'],
                        'github'  => 'https://github.com/paksaitsolutions',
                        'icon_i'  => 1,
                    ],
                    [
                        'name'    => 'Paksa Cart Recovery',
                        'desc'    => 'A powerful standalone WooCommerce abandoned cart recovery plugin designed for markets like Pakistan where customers primarily use mobile phone numbers and Cash on Delivery (COD) for online purchases.',
                        'tags'    => ['WordPress', 'WooCommerce', 'E-Commerce'],
                        'github'  => 'https://github.com/paksaitsolutions',
                        'icon_i'  => 2,
                    ],
                    [
                        'name'    => 'PaksaTalker',
                        'desc'    => 'An enterprise-grade AI framework for generating hyper-realistic talking head videos with perfect lip-sync, natural facial expressions, and life-like gestures. Built on cutting-edge AI research for production-ready video synthesis.',
                        'tags'    => ['AI', 'Deep Learning', 'Video Synthesis'],
                        'github'  => 'https://github.com/paksaitsolutions',
                        'icon_i'  => 3,
                    ],
                    [
                        'name'    => 'Paksa Daily Expense',
                        'desc'    => 'A comprehensive, professional-grade pocket accountant application with advanced income tracking, expense management, financial analytics, and tax optimization. Built with modern web technologies for optimal performance.',
                        'tags'    => ['Finance', 'Personal', 'Analytics'],
                        'github'  => 'https://github.com/paksaitsolutions',
                        'icon_i'  => 4,
                    ],
                ];

                foreach ( $display_projects as $i => $proj ) :
                    $pal  = $palettes[ $i % count( $palettes ) ];
                    $icon = $project_icons[ $proj['icon_i'] ?? ( $i % count( $project_icons ) ) ];
                    $tags = $proj['tags'] ?? [];
                ?>
                    <div class="pk-os-card pk-animate-on-scroll" data-anim="fade-up"
                         data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>"
                         style="--os-bg:<?php echo esc_attr( $pal['bg'] ); ?>;--os-icon:<?php echo esc_attr( $pal['icon'] ); ?>;--os-accent:<?php echo esc_attr( $pal['accent'] ); ?>">
                        <div class="pk-os-card__header">
                            <div class="pk-os-card__icon" aria-hidden="true">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><?php echo $icon; // phpcs:ignore ?></svg>
                            </div>
                            <div class="pk-os-card__github-icon" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                            </div>
                        </div>
                        <h3 class="pk-os-card__title"><?php echo esc_html( $proj['name'] ); ?></h3>
                        <p class="pk-os-card__desc"><?php echo esc_html( $proj['desc'] ); ?></p>
                        <?php if ( $tags ) : ?>
                            <div class="pk-os-card__tags">
                                <?php foreach ( $tags as $tag ) : ?>
                                    <span class="pk-os-tag"><?php echo esc_html( $tag ); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <a href="<?php echo esc_url( $proj['github'] ?? 'https://github.com/paksaitsolutions' ); ?>"
                           target="_blank" rel="noopener noreferrer" class="pk-os-card__link">
                            View Repository
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ── WHY OPEN SOURCE ── -->
    <?php if ( $why_content ) : ?>
    <section class="section section-alt pk-opensource-why" aria-labelledby="pk-os-why-heading">
        <div class="container">
            <div class="pk-opensource-why__inner">
                <div class="pk-opensource-why__content pk-animate-on-scroll" data-anim="fade-up">
                    <span class="pk-about-eyebrow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Our Philosophy
                    </span>
                    <h2 id="pk-os-why-heading"><?php echo esc_html( $why_heading ); ?></h2>
                    <?php foreach ( array_filter( array_map( 'trim', explode( "\n", $why_content ) ) ) as $para ) : ?>
                        <p><?php echo esc_html( $para ); ?></p>
                    <?php endforeach; ?>
                </div>
                <div class="pk-opensource-why__benefits pk-animate-on-scroll" data-anim="fade-up" data-delay="100">
                    <?php
                    $benefits = [
                        [ 'icon' => '<polyline points="20 6 9 17 4 12"/>', 'title' => 'Transparency', 'desc' => 'Open codebases mean full visibility into how our software works.' ],
                        [ 'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>', 'title' => 'Community Driven', 'desc' => 'Developers worldwide can contribute, improve, and extend our work.' ],
                        [ 'icon' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>', 'title' => 'Accelerate Innovation', 'desc' => 'Build on proven foundations instead of starting from scratch.' ],
                        [ 'icon' => '<rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>', 'title' => 'Learning Resource', 'desc' => 'Real-world codebases for developers to learn practical architecture patterns.' ],
                    ];
                    foreach ( $benefits as $b ) :
                    ?>
                        <div class="pk-opensource-benefit">
                            <div class="pk-opensource-benefit__icon" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo $b['icon']; // phpcs:ignore ?></svg>
                            </div>
                            <div>
                                <p class="pk-opensource-benefit__title"><?php echo esc_html( $b['title'] ); ?></p>
                                <p class="pk-opensource-benefit__desc"><?php echo esc_html( $b['desc'] ); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ── CTA ── -->
    <section class="pk-prod-single-cta" id="contact" aria-labelledby="pk-os-cta-heading">
        <div class="pk-prod-cta-dots" aria-hidden="true"></div>
        <div class="pk-prod-cta-glow" aria-hidden="true"></div>
        <div class="container">
            <div class="pk-prod-cta-inner pk-animate-on-scroll" data-anim="fade-up">
                <div class="pk-prod-cta-content">
                    <p class="pk-prod-cta-eyebrow">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><circle cx="7" cy="7" r="3" fill="currentColor"/><circle cx="7" cy="7" r="6" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
                        Collaborate
                    </p>
                    <h2 id="pk-os-cta-heading" class="pk-prod-cta-heading">Interested in Contributing or Collaborating?</h2>
                    <p class="pk-prod-cta-desc">Whether you want to contribute to our open-source projects, use them in your business, or partner with us on new initiatives — we'd love to hear from you.</p>
                </div>
                <div class="pk-prod-cta-actions">
                    <a href="https://github.com/paksaitsolutions" target="_blank" rel="noopener noreferrer" class="pk-btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                        GitHub Repositories
                    </a>
                    <a href="/contact-us/" class="pk-btn-ghost-inv">Get in Touch</a>
                </div>
            </div>
        </div>
    </section>

</main>
<?php get_footer(); ?>
