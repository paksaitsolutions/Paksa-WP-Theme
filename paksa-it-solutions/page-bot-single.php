<?php
/**
 * Template Name: Bot Single Page
 * @package paksa-it-solutions
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
if ( ! have_posts() ) { get_footer(); return; }
the_post();

$id           = get_the_ID();
$name         = get_post_meta( $id, '_bot_name',         true ) ?: get_the_title();
$tagline      = get_post_meta( $id, '_bot_tagline',      true );
$badge        = get_post_meta( $id, '_bot_badge',        true );
$color        = get_post_meta( $id, '_bot_color',        true ) ?: '#6192f8';
$market       = get_post_meta( $id, '_bot_market',       true );
$version      = get_post_meta( $id, '_bot_version',      true );
$overview     = get_post_meta( $id, '_bot_overview',     true );
$status       = get_post_meta( $id, '_bot_status',       true ) ?: 'Coming Soon';
$github_url   = get_post_meta( $id, '_bot_github_url',   true );
$docs_url     = get_post_meta( $id, '_bot_docs_url',     true );

$features_arr     = json_decode( get_post_meta( $id, '_bot_features',      true ) ?: '[]', true );
$exchanges_arr    = json_decode( get_post_meta( $id, '_bot_exchanges',     true ) ?: '[]', true );
$tech_arr         = json_decode( get_post_meta( $id, '_bot_tech_stack',    true ) ?: '[]', true );
$pricing_arr      = json_decode( get_post_meta( $id, '_bot_pricing',       true ) ?: '[]', true );
$stats_arr        = json_decode( get_post_meta( $id, '_bot_stats',         true ) ?: '[]', true );
$pipeline_arr     = json_decode( get_post_meta( $id, '_bot_pipeline',      true ) ?: '[]', true );
$problems_arr     = json_decode( get_post_meta( $id, '_bot_problems',      true ) ?: '[]', true );
$comparison       = json_decode( get_post_meta( $id, '_bot_comparison',    true ) ?: '{}', true );
$modes_arr        = json_decode( get_post_meta( $id, '_bot_modes',         true ) ?: '[]', true );
$states_arr       = json_decode( get_post_meta( $id, '_bot_market_states', true ) ?: '[]', true );
$presets_arr      = json_decode( get_post_meta( $id, '_bot_presets',       true ) ?: '[]', true );

$bots_page = get_page_by_path( 'trading-bots' );
$bots_url  = $bots_page ? get_permalink( $bots_page->ID ) : home_url( '/trading-bots/' );
?>
<main id="main-content" tabindex="-1" class="pk-bot-single" style="--bot-color:<?php echo esc_attr($color); ?>">

<!-- ═══════════════════════════════════════════════════════════
     HERO
════════════════════════════════════════════════════════════ -->
<section class="pk-bot-hero">
    <div class="pk-bot-hero__dots" aria-hidden="true"></div>
    <div class="pk-bot-hero__glow" aria-hidden="true"></div>
    <div class="container">
        <nav class="pk-bot-hero__breadcrumb" aria-label="Breadcrumb">
            <ol>
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="<?php echo esc_url(home_url('/solutions/')); ?>">Solutions</a></li>
                <li aria-hidden="true">/</li>
                <li><a href="<?php echo esc_url($bots_url); ?>">Trading Bots</a></li>
                <li aria-hidden="true">/</li>
                <li aria-current="page"><?php echo esc_html($name); ?></li>
            </ol>
        </nav>
        <div class="pk-bot-hero__layout">
            <div class="pk-bot-hero__left">
                <?php if ($badge): ?>
                <span class="pk-bot-hero__eyebrow">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    <?php echo esc_html($badge); ?>
                    <?php if ($version): ?><span class="pk-bot-hero__ver"><?php echo esc_html($version); ?></span><?php endif; ?>
                </span>
                <?php endif; ?>
                <h1 class="pk-bot-hero__heading"><?php echo esc_html($name); ?></h1>
                <?php if ($tagline): ?>
                <p class="pk-bot-hero__tagline"><?php echo esc_html($tagline); ?></p>
                <?php endif; ?>
                <div class="pk-bot-hero__actions">
                    <a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="pk-bot-hero__btn-primary">
                        Request Access
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <?php if ($github_url): ?>
                    <a href="<?php echo esc_url($github_url); ?>" class="pk-bot-hero__btn-ghost" target="_blank" rel="noopener noreferrer">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                        GitHub
                    </a>
                    <?php endif; ?>
                    <?php if ($docs_url): ?>
                    <a href="<?php echo esc_url($docs_url); ?>" class="pk-bot-hero__btn-ghost" target="_blank" rel="noopener noreferrer">Docs</a>
                    <?php endif; ?>
                </div>
                <?php if (!empty($stats_arr)): ?>
                <div class="pk-bot-hero__stats">
                    <?php foreach ($stats_arr as $s): ?>
                    <div class="pk-bot-hero__stat">
                        <span class="pk-bot-hero__stat-val"><?php echo esc_html($s['val']); ?></span>
                        <span class="pk-bot-hero__stat-label"><?php echo esc_html($s['label']); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="pk-bot-hero__right">
                <div class="pk-bot-hero__card">
                    <div class="pk-bot-hero__card-status">
                        <span class="pk-bot-hero__card-dot"></span>
                        <?php echo esc_html($status); ?>
                    </div>
                    <?php if ($market): ?>
                    <div class="pk-bot-hero__card-row">
                        <span>Market</span>
                        <strong><?php echo esc_html($market); ?></strong>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($exchanges_arr)): ?>
                    <div class="pk-bot-hero__card-row">
                        <span>Platforms</span>
                        <strong><?php echo esc_html(implode(', ', $exchanges_arr)); ?></strong>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($tech_arr)): ?>
                    <div class="pk-bot-hero__card-tags">
                        <?php foreach ($tech_arr as $t): ?>
                        <span class="pk-bot-hero__card-tag"><?php echo esc_html($t); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="pk-bot-hero__card-cta">
                        Get Early Access
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     OVERVIEW
════════════════════════════════════════════════════════════ -->
<?php if ($overview): ?>
<section class="pk-bot-overview">
    <div class="container">
        <div class="pk-bot-overview__inner">
            <div class="pk-bot-overview__label">Overview</div>
            <div class="pk-bot-overview__body">
                <?php
                $paras = array_filter(explode("\n\n", trim($overview)));
                foreach ($paras as $p): ?>
                <p><?php echo esc_html(trim($p)); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════
     DECISION PIPELINE
════════════════════════════════════════════════════════════ -->
<?php if (!empty($pipeline_arr)): ?>
<section class="pk-bot-pipeline">
    <div class="container">
        <div class="pk-bot-section-header">
            <span class="pk-bot-section-label">Architecture</span>
            <h2 class="pk-bot-section-heading">Decision Pipeline</h2>
            <p class="pk-bot-section-sub">Every trade candidate passes through every stage. Any stage can reject and record why.</p>
        </div>
        <div class="pk-bot-pipeline__track">
            <?php foreach ($pipeline_arr as $i => $step): ?>
            <div class="pk-bot-pipeline__step">
                <div class="pk-bot-pipeline__step-num"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></div>
                <div class="pk-bot-pipeline__step-name"><?php echo esc_html($step); ?></div>
                <?php if ($i < count($pipeline_arr) - 1): ?>
                <div class="pk-bot-pipeline__arrow" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <p class="pk-bot-pipeline__note">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <?php
            $pipeline_note = get_post_meta($id, '_bot_pipeline_note', true);
            echo esc_html($pipeline_note ?: 'No-trade is a valid terminal state. The system records rejection reasons — not just the absence of an order.');
            ?>
        </p>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════
     FEATURES GRID
════════════════════════════════════════════════════════════ -->
<?php if (!empty($features_arr)): ?>
<section class="pk-bot-features">
    <div class="container">
        <div class="pk-bot-section-header">
            <span class="pk-bot-section-label">Capabilities</span>
            <h2 class="pk-bot-section-heading">What <?php echo esc_html($name); ?> Does</h2>
        </div>
        <div class="pk-bot-features__grid">
            <?php foreach ($features_arr as $feat): ?>
            <div class="pk-bot-features__item">
                <?php if (!empty($feat['icon'])): ?>
                <div class="pk-bot-features__icon" aria-hidden="true"><?php echo $feat['icon']; ?></div>
                <?php endif; ?>
                <h3 class="pk-bot-features__title"><?php echo esc_html($feat['title']); ?></h3>
                <p class="pk-bot-features__desc"><?php echo esc_html($feat['desc']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════
     COMPARISON TABLE
════════════════════════════════════════════════════════════ -->
<?php if (!empty($comparison['rows'])): ?>
<section class="pk-bot-compare">
    <div class="container">
        <div class="pk-bot-section-header">
            <span class="pk-bot-section-label">Why <?php echo esc_html($name); ?></span>
            <h2 class="pk-bot-section-heading">How It Compares</h2>
        </div>
        <div class="pk-bot-compare__table-wrap">
            <table class="pk-bot-compare__table">
                <thead>
                    <tr>
                        <th class="pk-bot-compare__th pk-bot-compare__th--bad"><?php echo esc_html($comparison['headers'][0]); ?></th>
                        <th class="pk-bot-compare__th pk-bot-compare__th--good"><?php echo esc_html($comparison['headers'][1]); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comparison['rows'] as $row): ?>
                    <tr>
                        <td class="pk-bot-compare__td pk-bot-compare__td--bad">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            <?php echo esc_html($row[0]); ?>
                        </td>
                        <td class="pk-bot-compare__td pk-bot-compare__td--good">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                            <?php echo esc_html($row[1]); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════
     PROBLEMS SOLVED
════════════════════════════════════════════════════════════ -->
<?php if (!empty($problems_arr)): ?>
<section class="pk-bot-problems">
    <div class="container">
        <div class="pk-bot-section-header">
            <span class="pk-bot-section-label">Use Cases</span>
            <h2 class="pk-bot-section-heading">Problems <?php echo esc_html($name); ?> Solves</h2>
        </div>
        <div class="pk-bot-problems__grid">
            <?php foreach ($problems_arr as $i => $item): ?>
            <div class="pk-bot-problems__item">
                <div class="pk-bot-problems__num"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></div>
                <div class="pk-bot-problems__body">
                    <h3 class="pk-bot-problems__problem">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <?php echo esc_html($item['problem']); ?>
                    </h3>
                    <p class="pk-bot-problems__solution"><?php echo esc_html($item['solution']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════
     OPERATING MODES (Liquidity Hunter Pro)
════════════════════════════════════════════════════════════ -->
<?php if (!empty($modes_arr)): ?>
<section class="pk-bot-modes">
    <div class="container">
        <div class="pk-bot-section-header">
            <span class="pk-bot-section-label">Flexibility</span>
            <h2 class="pk-bot-section-heading">Operating Modes</h2>
        </div>
        <div class="pk-bot-modes__grid">
            <?php foreach ($modes_arr as $i => $m): ?>
            <div class="pk-bot-modes__item">
                <div class="pk-bot-modes__badge"><?php echo esc_html($m['mode']); ?></div>
                <p class="pk-bot-modes__desc"><?php echo esc_html($m['desc']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════
     MARKET STATES (Paksa Hunter Pro)
════════════════════════════════════════════════════════════ -->
<?php if (!empty($states_arr)): ?>
<section class="pk-bot-states">
    <div class="container">
        <div class="pk-bot-section-header">
            <span class="pk-bot-section-label">Context Intelligence</span>
            <h2 class="pk-bot-section-heading">7 Market Context States</h2>
            <p class="pk-bot-section-sub">The EA explicitly distinguishes these states — they are descriptive, not automatic trade signals.</p>
        </div>
        <div class="pk-bot-states__grid">
            <?php foreach ($states_arr as $s): ?>
            <div class="pk-bot-states__item">
                <div class="pk-bot-states__name"><?php echo esc_html($s['state']); ?></div>
                <p class="pk-bot-states__desc"><?php echo esc_html($s['desc']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════
     PRESETS (Paksa Hunter Pro)
════════════════════════════════════════════════════════════ -->
<?php if (!empty($presets_arr)): ?>
<section class="pk-bot-presets">
    <div class="container">
        <div class="pk-bot-section-header">
            <span class="pk-bot-section-label">Ready to Use</span>
            <h2 class="pk-bot-section-heading">Configuration Presets</h2>
            <p class="pk-bot-section-sub">Pre-built .set files for common trading scenarios. Load and go.</p>
        </div>
        <div class="pk-bot-presets__list">
            <?php foreach ($presets_arr as $preset): ?>
            <div class="pk-bot-presets__item">
                <div class="pk-bot-presets__icon" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div>
                    <div class="pk-bot-presets__name"><?php echo esc_html($preset['name']); ?></div>
                    <div class="pk-bot-presets__desc"><?php echo esc_html($preset['desc']); ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════
     PRICING
════════════════════════════════════════════════════════════ -->
<?php if (!empty($pricing_arr)): ?>
<section class="pk-bot-pricing">
    <div class="container">
        <div class="pk-bot-section-header">
            <span class="pk-bot-section-label">Pricing</span>
            <h2 class="pk-bot-section-heading">Simple, Transparent Pricing</h2>
            <p class="pk-bot-section-sub">Subscription based on authorized trading capital. Your capital stays on your exchange.</p>
        </div>
        <div class="pk-bot-pricing__grid">
            <?php foreach ($pricing_arr as $tier): ?>
            <div class="pk-bot-pricing__card <?php echo !empty($tier['featured']) ? 'is-featured' : ''; ?>">
                <?php if (!empty($tier['featured'])): ?>
                <span class="pk-bot-pricing__popular">Most Popular</span>
                <?php endif; ?>
                <div class="pk-bot-pricing__tier"><?php echo esc_html($tier['tier']); ?></div>
                <div class="pk-bot-pricing__price"><?php echo esc_html($tier['price']); ?></div>
                <p class="pk-bot-pricing__desc"><?php echo esc_html($tier['desc']); ?></p>
                <a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="pk-bot-pricing__cta">Get Started</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════
     CONNECTOR STATUS (Apex Hunter only)
════════════════════════════════════════════════════════════ -->
<?php
$connectors_arr = json_decode( get_post_meta($id, '_bot_connectors', true) ?: '[]', true );
if (!empty($connectors_arr)):
?>
<section class="pk-bot-connectors">
    <div class="container">
        <div class="pk-bot-section-header">
            <span class="pk-bot-section-label">Exchange Support</span>
            <h2 class="pk-bot-section-heading">Connector Certification Status</h2>
            <p class="pk-bot-section-sub">Each connector must pass its own API-contract, authentication, market-data, order, reconciliation, rate-limit, and runtime validation before it is enabled for customers.</p>
        </div>
        <div class="pk-bot-connectors__grid">
            <?php foreach ($connectors_arr as $conn): ?>
            <div class="pk-bot-connectors__item">
                <div class="pk-bot-connectors__header">
                    <span class="pk-bot-connectors__name"><?php echo esc_html($conn['name']); ?></span>
                    <span class="pk-bot-connectors__status pk-bot-connectors__status--<?php echo esc_attr(strtolower($conn['status'])); ?>">
                        <?php echo esc_html($conn['status']); ?>
                    </span>
                </div>
                <p class="pk-bot-connectors__detail"><?php echo esc_html($conn['detail']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════
     DISCLAIMER
════════════════════════════════════════════════════════════ -->
<section class="pk-bot-disclaimer">
    <div class="container">
        <div class="pk-bot-disclaimer__inner">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <p>Algorithmic trading involves substantial risk of loss. Past performance does not guarantee future results. <?php echo esc_html($name); ?> is a technical system, not financial advice. Always validate with paper trading before live deployment.</p>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     CTA
════════════════════════════════════════════════════════════ -->
<section class="pk-prod-single-cta">
    <div class="pk-prod-cta-dots" aria-hidden="true"></div>
    <div class="pk-prod-cta-glow" aria-hidden="true"></div>
    <div class="container">
        <div class="pk-prod-cta-inner">
            <div>
                <p class="pk-prod-cta-eyebrow">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    Get Started
                </p>
                <h2 class="pk-prod-cta-heading">Ready to trade smarter with <span><?php echo esc_html($name); ?>?</span></h2>
                <p class="pk-prod-cta-desc">Contact us to request early access or learn more about how <?php echo esc_html($name); ?> can work for your trading strategy.</p>
            </div>
            <div class="pk-prod-cta-actions">
                <a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="pk-btn-primary">
                    Request Access
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="<?php echo esc_url($bots_url); ?>" class="pk-btn-ghost-inv">All Trading Bots</a>
            </div>
        </div>
    </div>
</section>

</main>
<?php get_footer(); ?>
