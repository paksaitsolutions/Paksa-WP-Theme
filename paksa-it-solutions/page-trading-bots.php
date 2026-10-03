<?php
/**
 * Template Name: Trading Bots Listing
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$bots = array(
    array(
        'slug'     => 'apex-hunter',
        'name'     => 'Apex Hunter',
        'tagline'  => 'Adaptive Multi-Exchange SPOT Trading Engine',
        'desc'     => 'Exchange-agnostic SPOT trading engine that connects your own exchange account, analyzes the eligible market universe, and allocates capital under strict risk controls across Binance, OKX, Bybit, Bitget, and Coinbase.',
        'badge'    => 'Crypto',
        'color'    => '#f79009',
        'icon'     => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
        'tags'     => array( 'Binance', 'OKX', 'Bybit', 'Bitget', 'Coinbase' ),
        'stats'    => array(
            array( 'val' => '5+',    'label' => 'Exchanges' ),
            array( 'val' => '$20',   'label' => 'Min Capital' ),
            array( 'val' => '100%',  'label' => 'Auditable' ),
        ),
    ),
    array(
        'slug'     => 'liquidity-hunter-pro',
        'name'     => 'Liquidity Hunter Pro',
        'tagline'  => 'Institutional Forex Decision Intelligence Platform',
        'desc'     => 'Full-stack trading intelligence platform built around SMC, 3CS pattern analysis, AI/ML decision intelligence, risk governance, MT5 broker execution, and DEX order-flow analysis for Forex and synthetic indices.',
        'badge'    => 'Forex / MT5',
        'color'    => '#6192f8',
        'icon'     => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>',
        'tags'     => array( 'SMC', '3CS', 'AI/ML', 'MT5', 'DEX' ),
        'stats'    => array(
            array( 'val' => 'SMC',   'label' => 'Smart Money' ),
            array( 'val' => 'AI',    'label' => 'Gemini Intel' ),
            array( 'val' => 'MT5',   'label' => 'Live Broker' ),
        ),
    ),
    array(
        'slug'     => 'paksa-hunter-pro',
        'name'     => 'Paksa Hunter Pro',
        'tagline'  => 'Native MT5 Expert Advisor',
        'desc'     => 'Native MQL5 Expert Advisor built around supply/demand zones, order blocks, FVGs, liquidity sweeps, 3CS setups, and adaptive market-context intelligence. Runs directly inside MetaTrader 5 with no external dependencies.',
        'badge'    => 'MT5 EA',
        'color'    => '#12b76a',
        'icon'     => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><path d="M7 8l3 3 2-2 3 3"/></svg>',
        'tags'     => array( 'MQL5', 'Supply/Demand', 'Order Blocks', 'FVG', '3CS' ),
        'stats'    => array(
            array( 'val' => 'MQL5',  'label' => 'Native EA' ),
            array( 'val' => '3CS',   'label' => 'Pattern Logic' ),
            array( 'val' => 'Auto',  'label' => 'Risk Governor' ),
        ),
    ),
);

// Find page slugs for each bot
$bot_pages = array();
foreach ( $bots as $bot ) {
    $p = get_page_by_path( $bot['slug'] );
    $bot_pages[ $bot['slug'] ] = $p ? get_permalink( $p->ID ) : '#';
}
?>
<main id="main-content" tabindex="-1" class="pk-trading-bots-listing">

    <!-- HERO -->
    <section class="pk-bots-hero">
        <div class="pk-bots-hero__dots" aria-hidden="true"></div>
        <div class="pk-bots-hero__glow" aria-hidden="true"></div>
        <div class="container">
            <div class="pk-bots-hero__inner">
                <div class="pk-bots-hero__content">
                    <span class="pk-bots-hero__eyebrow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Algorithmic Trading
                    </span>
                    <h1 class="pk-bots-hero__heading">Trading Bots &amp; Automation</h1>
                    <p class="pk-bots-hero__desc">Professional-grade algorithmic trading systems for crypto exchanges and Forex markets. Built on real exchange data, strict risk governance, and auditable decision pipelines.</p>
                    <div class="pk-bots-hero__actions">
                        <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="pk-btn-primary">
                            Get Early Access
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#bots-grid" class="pk-btn-ghost-inv">Explore Bots</a>
                    </div>
                </div>
                <div class="pk-bots-hero__trust">
                    <?php
                    $trust = array(
                        array( 'val' => '3', 'label' => 'Trading Bots' ),
                        array( 'val' => '5+', 'label' => 'Exchanges' ),
                        array( 'val' => 'AI', 'label' => 'Powered' ),
                        array( 'val' => '0', 'label' => 'Fake Data' ),
                    );
                    foreach ( $trust as $t ) : ?>
                        <div class="pk-bots-hero__trust-item">
                            <span class="pk-bots-hero__trust-val"><?php echo esc_html( $t['val'] ); ?></span>
                            <span class="pk-bots-hero__trust-label"><?php echo esc_html( $t['label'] ); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- BOTS GRID -->
    <section id="bots-grid" class="pk-bots-grid-section">
        <div class="container">
            <div class="pk-bots-grid">
                <?php foreach ( $bots as $bot ) :
                    $url = $bot_pages[ $bot['slug'] ];
                ?>
                <article class="pk-bot-card" style="--bot-color: <?php echo esc_attr( $bot['color'] ); ?>">
                    <div class="pk-bot-card__header">
                        <div class="pk-bot-card__icon" aria-hidden="true"><?php echo $bot['icon']; ?></div>
                        <span class="pk-bot-card__badge"><?php echo esc_html( $bot['badge'] ); ?></span>
                    </div>
                    <h2 class="pk-bot-card__name"><?php echo esc_html( $bot['name'] ); ?></h2>
                    <p class="pk-bot-card__tagline"><?php echo esc_html( $bot['tagline'] ); ?></p>
                    <p class="pk-bot-card__desc"><?php echo esc_html( $bot['desc'] ); ?></p>
                    <div class="pk-bot-card__tags">
                        <?php foreach ( $bot['tags'] as $tag ) : ?>
                            <span class="pk-bot-card__tag"><?php echo esc_html( $tag ); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="pk-bot-card__stats">
                        <?php foreach ( $bot['stats'] as $stat ) : ?>
                            <div class="pk-bot-card__stat">
                                <span class="pk-bot-card__stat-val"><?php echo esc_html( $stat['val'] ); ?></span>
                                <span class="pk-bot-card__stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="<?php echo esc_url( $url ); ?>" class="pk-bot-card__cta">
                        Learn More
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- DISCLAIMER -->
    <section class="pk-bots-disclaimer">
        <div class="container">
            <div class="pk-bots-disclaimer__inner">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <p>Algorithmic trading involves substantial risk of loss. Past performance does not guarantee future results. These systems are technical tools, not financial advice. Always validate with paper trading before live deployment.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="pk-prod-single-cta">
        <div class="pk-prod-cta-dots" aria-hidden="true"></div>
        <div class="pk-prod-cta-glow" aria-hidden="true"></div>
        <div class="container">
            <div class="pk-prod-cta-inner">
                <div>
                    <p class="pk-prod-cta-eyebrow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Early Access
                    </p>
                    <h2 class="pk-prod-cta-heading">Ready to automate your <span>trading strategy?</span></h2>
                    <p class="pk-prod-cta-desc">Join the waitlist for early access to our trading bots. We'll notify you when subscriptions open.</p>
                </div>
                <div class="pk-prod-cta-actions">
                    <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="pk-btn-primary">
                        Request Early Access
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>
<?php get_footer(); ?>
