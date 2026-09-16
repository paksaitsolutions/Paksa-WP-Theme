<?php
/**
 * Paksa IT Solutions — Template Functions
 *
 * @package paksa-it-solutions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if an SEO plugin is active
 *
 * @return bool
 */
function paksa_seo_plugin_active() {
    return function_exists( 'rank_math' )
        || defined( 'WPSEO_VERSION' )
        || defined( 'AIOSEO_VERSION' )
        || function_exists( 'bcn_display' );
}

/**
 * Get Theme Logo
 */
function paksa_get_logo($args = array()) {
    $defaults = array(
        'class'     => 'site-logo',
        'show_text' => true,
        'link'      => home_url('/'),
    );
    $args = wp_parse_args($args, $defaults);

    // get_custom_logo() already returns a full <a> element — do not double-wrap.
    if ( has_custom_logo() ) {
        return get_custom_logo();
    }

    if ( $args['show_text'] ) {
        return sprintf(
            '<a href="%s" class="%s" rel="home" aria-label="%s"><span class="site-logo-text">%s</span></a>',
            esc_url( $args['link'] ),
            esc_attr( $args['class'] ),
            esc_attr( sprintf(
                /* translators: %s: site name */
                __( 'Home — %s', 'paksa-it-solutions' ),
                get_bloginfo( 'name', 'display' )
            ) ),
            esc_html( get_bloginfo( 'name' ) )
        );
    }

    return '';
}

/**
 * Get Theme Favicon
 */
function paksa_get_favicon() {
    if (paksa_seo_plugin_active()) {
        return;
    }

    $favicon = get_site_icon_url(512);
    if ($favicon) {
        echo '<link rel="icon" href="' . esc_url($favicon) . '" sizes="any">' . "\n";
        echo '<link rel="icon" href="' . esc_url($favicon) . '" type="image/svg+xml">' . "\n";
    }
}
add_action('wp_head', 'paksa_get_favicon', 1);

/**
 * Open Graph Meta Tags
 * Only outputs if no SEO plugin is active.
 */
function paksa_opengraph() {
    if (is_admin()) {
        return;
    }

    if (paksa_seo_plugin_active()) {
        return;
    }
    ?>
    <meta property="og:type" content="<?php echo is_singular() ? 'article' : 'website'; ?>">
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>">
    <?php if (is_singular() && has_post_thumbnail()): ?>
        <meta property="og:image" content="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>">
    <?php else: ?>
        <meta property="og:image" content="<?php echo esc_url(get_site_icon_url(1200)); ?>">
    <?php endif; ?>
    <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <?php
}
add_action('wp_head', 'paksa_opengraph', 1);

/**
 * Schema.org JSON-LD — Organization
 * Only outputs if no SEO plugin is active.
 */
function paksa_organization_schema() {
    if (!is_front_page() && !is_home()) {
        return;
    }

    if (paksa_seo_plugin_active()) {
        return;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => get_bloginfo('name', 'display'),
        'url' => home_url('/'),
        'description' => get_bloginfo('description', 'display'),
        'sameAs' => array_values( array_filter( array(
            paksa_get_option( 'paksa_social_facebook', '' ),
            paksa_get_option( 'paksa_social_twitter', '' ),
            paksa_get_option( 'paksa_social_linkedin', '' ),
            paksa_get_option( 'paksa_social_github', '' ),
        ) ) ),
    );
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
add_action('wp_head', 'paksa_organization_schema', 2);

/**
 * Schema.org JSON-LD — WebSite with SearchAction
 * Only outputs if no SEO plugin is active.
 */
function paksa_website_schema() {
    if (paksa_seo_plugin_active()) {
        return;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name', 'display'),
        'url' => home_url('/'),
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => home_url('/?s={search_term_string}'),
            'query-input' => 'required name=search_term_string',
        ),
    );
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
add_action('wp_head', 'paksa_website_schema', 2);

/**
 * Breadcrumbs (compatible with SEO plugins)
 * Falls back to Breadcrumb NavXT if active, otherwise theme-built.
 */
function paksa_breadcrumbs() {
    if (is_admin()) {
        return;
    }

    if (paksa_seo_plugin_active()) {
        return;
    }

    if (function_exists('bcn_display')) {
        bcn_display();
        return;
    }

    $sep    = '<li class="pk-breadcrumb-sep" aria-hidden="true"><span>/</span></li>';
    $home   = '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'paksa-it-solutions' ) . '</a></li>';
    $items  = array( $home );

    if ( is_singular( 'paksa_product' ) ) {
        $archive_url = get_post_type_archive_link( 'paksa_product' );
        if ( $archive_url ) {
            $items[] = $sep;
            $items[] = '<li><a href="' . esc_url( $archive_url ) . '">' . esc_html__( 'Solutions', 'paksa-it-solutions' ) . '</a></li>';
        }
        // Primary taxonomy term
        $terms = get_the_terms( get_the_ID(), 'paksa_product_cat' );
        if ( $terms && ! is_wp_error( $terms ) ) {
            $items[] = $sep;
            $items[] = '<li><a href="' . esc_url( get_term_link( $terms[0] ) ) . '">' . esc_html( $terms[0]->name ) . '</a></li>';
        }
        $items[] = $sep;
        $items[] = '<li aria-current="page">' . esc_html( get_the_title() ) . '</li>';

    } elseif ( is_singular( 'paksa_service' ) ) {
        $archive_url = get_post_type_archive_link( 'paksa_service' );
        if ( $archive_url ) {
            $items[] = $sep;
            $items[] = '<li><a href="' . esc_url( $archive_url ) . '">' . esc_html__( 'Services', 'paksa-it-solutions' ) . '</a></li>';
        }
        $terms = get_the_terms( get_the_ID(), 'paksa_service_cat' );
        if ( $terms && ! is_wp_error( $terms ) ) {
            $items[] = $sep;
            $items[] = '<li><a href="' . esc_url( get_term_link( $terms[0] ) ) . '">' . esc_html( $terms[0]->name ) . '</a></li>';
        }
        $items[] = $sep;
        $items[] = '<li aria-current="page">' . esc_html( get_the_title() ) . '</li>';

    } elseif ( is_post_type_archive( 'paksa_product' ) ) {
        $items[] = $sep;
        $items[] = '<li aria-current="page">' . esc_html__( 'Solutions', 'paksa-it-solutions' ) . '</li>';

    } elseif ( is_post_type_archive( 'paksa_service' ) ) {
        $items[] = $sep;
        $items[] = '<li aria-current="page">' . esc_html__( 'Services', 'paksa-it-solutions' ) . '</li>';

    } elseif ( is_tax( 'paksa_product_cat' ) ) {
        $archive_url = get_post_type_archive_link( 'paksa_product' );
        if ( $archive_url ) {
            $items[] = $sep;
            $items[] = '<li><a href="' . esc_url( $archive_url ) . '">' . esc_html__( 'Solutions', 'paksa-it-solutions' ) . '</a></li>';
        }
        $items[] = $sep;
        $items[] = '<li aria-current="page">' . esc_html( get_queried_object()->name ) . '</li>';

    } elseif ( is_tax( 'paksa_service_cat' ) ) {
        $archive_url = get_post_type_archive_link( 'paksa_service' );
        if ( $archive_url ) {
            $items[] = $sep;
            $items[] = '<li><a href="' . esc_url( $archive_url ) . '">' . esc_html__( 'Services', 'paksa-it-solutions' ) . '</a></li>';
        }
        $items[] = $sep;
        $items[] = '<li aria-current="page">' . esc_html( get_queried_object()->name ) . '</li>';

    } elseif ( is_category() || is_tag() ) {
        $term    = get_queried_object();
        $items[] = $sep;
        $items[] = '<li aria-current="page">' . esc_html( $term->name ) . '</li>';

    } elseif ( is_single() ) {
        $items[] = $sep;
        $items[] = '<li aria-current="page">' . esc_html( get_the_title() ) . '</li>';

    } elseif ( is_page() ) {
        $queried = get_queried_object();
        if ( $queried->post_parent ) {
            foreach ( array_reverse( get_post_ancestors( $queried ) ) as $parent_id ) {
                $items[] = $sep;
                $items[] = '<li><a href="' . esc_url( get_permalink( $parent_id ) ) . '">' . esc_html( get_the_title( $parent_id ) ) . '</a></li>';
            }
        }
        $items[] = $sep;
        $items[] = '<li aria-current="page">' . esc_html( $queried->post_title ) . '</li>';

    } elseif ( is_archive() ) {
        $items[] = $sep;
        $items[] = '<li aria-current="page">' . esc_html( get_the_archive_title() ) . '</li>';

    } elseif ( is_search() ) {
        $items[] = $sep;
        $items[] = '<li aria-current="page">' . sprintf(
            /* translators: %s: search query */
            esc_html__( 'Search: %s', 'paksa-it-solutions' ),
            esc_html( get_search_query() )
        ) . '</li>';

    } elseif ( is_404() ) {
        $items[] = $sep;
        $items[] = '<li aria-current="page">' . esc_html__( 'Page Not Found', 'paksa-it-solutions' ) . '</li>';
    }

    echo '<nav class="pk-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'paksa-it-solutions' ) . '">';
    echo '<ol class="pk-breadcrumbs-list">';
    echo implode( '', $items );
    echo '</ol></nav>';
}
