<?php
/**
 * Paksa IT Solutions — Component: Breadcrumbs
 *
 * Wraps paksa_breadcrumbs() from inc/template-functions.php.
 * Returns early if an SEO plugin is active (plugin handles its own breadcrumbs).
 * Returns early on the homepage (no breadcrumb needed).
 *
 * Supported contexts:
 *   - Pages (including nested pages)
 *   - Single posts
 *   - Single paksa_product  → Home > Solutions > Product Name
 *   - Single paksa_service  → Home > Services > Service Name
 *   - Product archive       → Home > Solutions
 *   - Product taxonomy      → Home > Solutions > Category Name
 *   - Service archive       → Home > Services
 *   - Service taxonomy      → Home > Services > Category Name
 *   - Blog archive / single → Home > Blog > Post Title
 *   - Search results        → Home > Search Results
 *   - 404                   → Home > Page Not Found
 *
 * The breadcrumb logic lives in paksa_breadcrumbs() (inc/template-functions.php).
 * This component is the presentation wrapper — it adds the container and CSS class.
 *
 * CSS: .pk-breadcrumbs-wrap in assets/css/archive.css
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// No breadcrumb on homepage
if ( is_front_page() ) {
    return;
}

// SEO plugin guard is inside paksa_breadcrumbs() — call it directly
if ( ! function_exists( 'paksa_breadcrumbs' ) ) {
    return;
}
?>
<div class="pk-breadcrumbs-wrap">
    <div class="container">
        <?php paksa_breadcrumbs(); ?>
    </div>
</div>
