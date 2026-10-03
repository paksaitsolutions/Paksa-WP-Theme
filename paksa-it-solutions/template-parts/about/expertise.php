<?php
/**
 * Paksa IT Solutions — About: Our Expertise
 * Uses product features-style icon cards with colour palettes.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$page_id = get_the_ID();
$content = paksa_page_meta_textarea( 'expertise_content', '', $page_id );

if ( ! $content ) { return; }

// Same 6-colour palette as product benefits
$palettes = [
    [ 'bg' => '#eef3fe', 'color' => '#6192f8' ],
    [ 'bg' => '#edfaf3', 'color' => '#12b76a' ],
    [ 'bg' => '#fff8ec', 'color' => '#f79009' ],
    [ 'bg' => '#f3f0ff', 'color' => '#7c3aed' ],
    [ 'bg' => '#e8f9fb', 'color' => '#0891b2' ],
    [ 'bg' => '#fdf2f8', 'color' => '#e11d8f' ],
];

$expertise_items = [
    [
        'title' => 'Data Science',
        'desc'  => 'Advanced analytics, statistical modelling, and data pipeline engineering to turn raw data into actionable intelligence.',
        'icon'  => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
    ],
    [
        'title' => 'Artificial Intelligence',
        'desc'  => 'Machine learning models, deep learning, NLP, and computer vision solutions tailored to your business domain.',
        'icon'  => '<rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/>',
    ],
    [
        'title' => 'AI Automation',
        'desc'  => 'Intelligent workflow automation, AI chatbots, RPA, and process orchestration that eliminate manual bottlenecks.',
        'icon'  => '<line x1="6" y1="3" x2="6" y2="15"/><circle cx="18" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M18 9a9 9 0 0 1-9 9"/>',
    ],
    [
        'title' => 'Software Development',
        'desc'  => 'Custom desktop, web, and enterprise software built with modern architectures for scalability and long-term value.',
        'icon'  => '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>',
    ],
    [
        'title' => 'Web & E-Commerce',
        'desc'  => 'High-performance websites, e-commerce platforms, and digital storefronts optimised for conversion and growth.',
        'icon'  => '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
    ],
    [
        'title' => 'IT Consultancy',
        'desc'  => 'Strategic technology advisory, digital transformation roadmaps, and IT HR services for growing organisations.',
        'icon'  => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
    ],
];
?>
<section class="section section-alt pk-about-expertise" aria-labelledby="pk-about-expertise-heading">
    <div class="container">
        <div class="section-header">
            <span class="pk-about-eyebrow">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Our Expertise
            </span>
            <h2 id="pk-about-expertise-heading">Data, Intelligence &amp; Automation</h2>
            <?php foreach ( array_filter( array_map( 'trim', explode( "\n", $content ) ) ) as $para ) : ?>
                <p><?php echo esc_html( $para ); ?></p>
            <?php endforeach; ?>
        </div>
        <div class="pk-about-expertise-grid">
            <?php foreach ( $expertise_items as $i => $item ) :
                $pal = $palettes[ $i % count( $palettes ) ];
            ?>
                <div class="pk-about-expertise-card pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>">
                    <div class="pk-about-expertise-icon" style="background:<?php echo esc_attr( $pal['bg'] ); ?>;color:<?php echo esc_attr( $pal['color'] ); ?>" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><?php echo $item['icon']; // phpcs:ignore ?></svg>
                    </div>
                    <div class="pk-about-expertise-body">
                        <h3 class="pk-about-expertise-title"><?php echo esc_html( $item['title'] ); ?></h3>
                        <p class="pk-about-expertise-desc"><?php echo esc_html( $item['desc'] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
