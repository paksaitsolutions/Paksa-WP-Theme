<?php
/**
 * Nexus Business Theme — GitHub Update Checker
 *
 * Integrates with WordPress's native update system to detect new releases
 * published on GitHub and deliver the release ZIP as the update package.
 *
 * HOW IT WORKS:
 *   1. WordPress periodically checks for theme updates via the
 *      `pre_set_site_transient_update_themes` filter.
 *   2. This file hooks into that filter and queries the GitHub Releases API
 *      for the latest release of this repository.
 *   3. If the latest release version is newer than the installed version,
 *      WordPress is told an update is available and given the ZIP URL.
 *   4. WordPress's native Theme_Upgrader downloads and installs the ZIP.
 *
 * WHAT IS PRESERVED:
 *   WordPress database content (wp_options, wp_posts, wp_postmeta, wp_terms,
 *   wp_nav_menus, media) is never touched by a theme update. Only theme
 *   PHP/CSS/JS files are replaced.
 *
 * GITHUB REPOSITORY:
 *   https://github.com/paksaitsolutions/Paksa-WP-Theme
 *
 * RELEASE ZIP STRUCTURE REQUIREMENT:
 *   The release ZIP must contain the theme files directly inside a folder
 *   named `paksa-it-solutions/` so WordPress installs it to the correct
 *   theme directory. The GitHub Actions workflow enforces this structure.
 *
 * @package paksa-it-solutions
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * GitHub repository details.
 * These are constants so they cannot be accidentally overridden at runtime.
 */
define( 'PAKSA_GITHUB_USER',   'paksaitsolutions' );
define( 'PAKSA_GITHUB_REPO',   'Paksa-WP-Theme' );
define( 'PAKSA_THEME_SLUG',    'paksa-it-solutions' );
define( 'PAKSA_API_CACHE_KEY', 'paksa_github_release_cache' );
define( 'PAKSA_API_CACHE_TTL', 12 * HOUR_IN_SECONDS );

/**
 * Fetch the latest GitHub release data.
 *
 * Results are cached in a transient for PAKSA_API_CACHE_TTL to avoid
 * hammering the GitHub API on every WordPress admin page load.
 *
 * @return array|false Decoded release object or false on failure.
 */
function paksa_get_latest_release() {
    $cached = get_transient( PAKSA_API_CACHE_KEY );
    if ( false !== $cached ) {
        return $cached;
    }

    $api_url  = sprintf(
        'https://api.github.com/repos/%s/%s/releases/latest',
        PAKSA_GITHUB_USER,
        PAKSA_GITHUB_REPO
    );

    $response = wp_remote_get( $api_url, array(
        'timeout'    => 10,
        'user-agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . home_url(),
        'sslverify'  => true,
    ) );

    if ( is_wp_error( $response ) ) {
        return false;
    }

    $code = wp_remote_retrieve_response_code( $response );
    if ( 200 !== (int) $code ) {
        return false;
    }

    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );

    if ( empty( $data['tag_name'] ) ) {
        return false;
    }

    set_transient( PAKSA_API_CACHE_KEY, $data, PAKSA_API_CACHE_TTL );
    return $data;
}

/**
 * Normalise a version string by stripping a leading 'v'.
 *
 * GitHub tags are conventionally `v1.1.0`; style.css uses `1.1.0`.
 *
 * @param  string $version Raw version string.
 * @return string          Normalised version string.
 */
function paksa_normalise_version( $version ) {
    return ltrim( trim( $version ), 'v' );
}

/**
 * Inject update data into the WordPress themes transient.
 *
 * Hooked on `pre_set_site_transient_update_themes`.
 *
 * @param  object $transient WordPress update transient.
 * @return object             Modified transient.
 */
function paksa_check_for_update( $transient ) {
    if ( empty( $transient->checked ) ) {
        return $transient;
    }

    $release = paksa_get_latest_release();
    if ( ! $release ) {
        return $transient;
    }

    $latest_version    = paksa_normalise_version( $release['tag_name'] );
    $installed_version = paksa_normalise_version( PAKSA_THEME_VERSION );

    if ( ! version_compare( $latest_version, $installed_version, '>' ) ) {
        return $transient;
    }

    // Find the release asset named `paksa-it-solutions-theme.zip`.
    $package_url = '';
    if ( ! empty( $release['assets'] ) ) {
        foreach ( $release['assets'] as $asset ) {
            if ( isset( $asset['name'] ) && 'paksa-it-solutions-theme.zip' === $asset['name'] ) {
                $package_url = $asset['browser_download_url'];
                break;
            }
        }
    }

    // Fall back to the auto-generated source ZIP if no explicit asset found.
    // Note: GitHub source ZIPs have a nested directory structure that may not
    // match the expected WordPress theme directory name. The GitHub Actions
    // workflow always attaches an explicit asset, so this fallback should
    // rarely be reached in production.
    if ( empty( $package_url ) && ! empty( $release['zipball_url'] ) ) {
        $package_url = $release['zipball_url'];
    }

    if ( empty( $package_url ) ) {
        return $transient;
    }

    $transient->response[ PAKSA_THEME_SLUG ] = array(
        'theme'       => PAKSA_THEME_SLUG,
        'new_version' => $latest_version,
        'url'         => 'https://github.com/' . PAKSA_GITHUB_USER . '/' . PAKSA_GITHUB_REPO,
        'package'     => $package_url,
        'requires'    => '6.1',
        'requires_php'=> '7.4',
    );

    return $transient;
}
add_filter( 'pre_set_site_transient_update_themes', 'paksa_check_for_update' );

/**
 * Provide theme information to the WordPress "View version details" popup.
 *
 * Hooked on `themes_api`.
 *
 * @param  false|object $result Default result (false).
 * @param  string       $action API action being performed.
 * @param  object       $args   Request arguments.
 * @return false|object         Theme info object or original false.
 */
function paksa_themes_api( $result, $action, $args ) {
    if ( 'theme_information' !== $action ) {
        return $result;
    }

    if ( ! isset( $args->slug ) || PAKSA_THEME_SLUG !== $args->slug ) {
        return $result;
    }

    $release = paksa_get_latest_release();
    if ( ! $release ) {
        return $result;
    }

    $latest_version = paksa_normalise_version( $release['tag_name'] );
    $changelog      = ! empty( $release['body'] ) ? wp_kses_post( $release['body'] ) : '';

    $info = (object) array(
        'name'          => 'Nexus Business Theme',
        'slug'          => PAKSA_THEME_SLUG,
        'version'       => $latest_version,
        'author'        => 'Paksa IT Solutions',
        'homepage'      => 'https://github.com/' . PAKSA_GITHUB_USER . '/' . PAKSA_GITHUB_REPO,
        'requires'      => '6.1',
        'requires_php'  => '7.4',
        'sections'      => array(
            'description' => 'Reusable enterprise WordPress theme for technology, software, and service businesses.',
            'changelog'   => $changelog ?: 'See GitHub releases for changelog.',
        ),
        'download_link' => '',
    );

    return $info;
}
add_filter( 'themes_api', 'paksa_themes_api', 10, 3 );

/**
 * Clear the GitHub release cache when WordPress forces a manual update check.
 *
 * This ensures that clicking "Check Again" in Dashboard → Updates fetches
 * fresh data from the GitHub API rather than serving a stale transient.
 */
function paksa_clear_update_cache() {
    delete_transient( PAKSA_API_CACHE_KEY );
}
add_action( 'delete_site_transient_update_themes', 'paksa_clear_update_cache' );
