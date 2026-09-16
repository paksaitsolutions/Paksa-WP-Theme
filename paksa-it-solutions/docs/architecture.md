# Paksa IT Solutions — Theme Architecture

## Overview

Custom PHP/Hybrid WordPress theme for Paksa IT Solutions. Built with modern WordPress conventions combining block theme configuration with PHP template hierarchy.

## Theme Type

**Custom PHP/Hybrid Theme** with `theme.json` support for the block editor.

## Theme Structure

```
paksa-it-solutions/
├── style.css              # Theme header
├── theme.json             # Design tokens, settings, styles (block editor config)
├── functions.php          # Theme setup, loads inc/
├── index.php              # Index template (get_header + get_footer)
├── header.php             # Header template part
├── footer.php             # Footer template part
├── front-page.php         # Front page template
├── home.php               # Blog index template
├── page.php               # Default page template
├── single.php             # Single post template
├── archive.php            # Generic archive template
├── search.php             # Search results template
├── 404.php                # Not found template
├── .gitignore             # Git ignore rules
│
├── assets/
│   ├── css/
│   │   ├── variables.css  # Design tokens (CSS custom properties)
│   │   ├── main.css       # All styles (components, layout, header, footer, sections)
│   │   └── animations.css # Keyframes, animation classes, reduced motion
│   └── js/
│       ├── main.js        # Header scroll state, js class injection
│       ├── mobile-nav.js  # Mobile navigation with a11y
│       └── animations.js  # Scroll animations (IntersectionObserver)
│
├── inc/
│   ├── enqueue.php        # Asset loading
│   ├── theme-api.php      # Theme API helpers
│   ├── updater.php        # Theme updater
│   ├── security.php       # Theme-level security (version, embeds)
│   ├── performance.php    # Lazy loading, DNS prefetch, emoji removal, script optimization
│   ├── accessibility.php  # Skip link, body classes, title filter
│   ├── template-functions.php  # Logo, SEO (with plugin guards), breadcrumbs, schema
│   ├── template-tags.php  # Post meta, thumbnail, excerpt, navigation
│   ├── nav-walker.php     # Custom navigation walker
│   ├── icons.php          # SVG icon registry
│   ├── customizer.php     # Customizer settings and sanitization
│   ├── services-meta.php  # Services page post meta
│   ├── service-meta.php   # Service post meta
│   ├── service-cpt.php    # Service CPT and taxonomy registration
│   ├── product-meta.php   # Product post meta
│   ├── products-listing-meta.php # Products listing meta
│   ├── cpt.php            # Product CPT and taxonomy registration, rewrite flush
│   └── contact-form.php   # Contact form integration
│
│
├── header/                # (Empty — header.php moved to root)
├── footer/                # (Empty — footer.php moved to root)
│
├── template-parts/
│   ├── components/        # Reusable components (service-card, section-header, product-card, faq-item, breadcrumbs, whatsapp-fab)
│   ├── home/              # Home page sections (hero, capabilities, process, industries, technology, intelligence, outcomes, case-studies, differentiation, challenge, final-cta, faq, trust-strip)
│   ├── about/             # About page sections (hero, story, mission, values, cta)
│   ├── products/          # Products page sections (hero, industries, grid, faq, cta)
│   ├── contact/           # Contact page sections (hero, info, cta)
│   └── services/          # Services page sections (hero, overview, portfolio, capabilities, process, industries, technology, faq, cta)
│
│
├── docs/
│   ├── architecture.md    # This file
│   ├── design-system.md   # Design system documentation
│   ├── components.md      # Component library documentation
│   └── development-roadmap.md  # Phase roadmap
│
├── languages/             # Translation files (.pot)
├── parts/                 # Template parts (for future block editor use)
├── patterns/              # Block patterns (23 total)
│   ├── hero-standard.php
│   ├── hero-split.php
│   ├── hero-dark.php
│   ├── hero-minimal.php
│   ├── heading-display.php
│   ├── heading-section.php
│   ├── heading-section-left.php
│   ├── heading-compact.php
│   ├── paragraph-lead.php
│   ├── paragraph-callout.php
│   ├── paragraph-highlight.php
│   ├── paragraph-cta.php
│   ├── heading-paragraph-hero.php
│   ├── heading-paragraph-section.php
│   ├── services-grid.php
│   ├── services-process.php
│   ├── services-tabs.php
│   ├── services-features.php
│   ├── services-stats.php
│   ├── services-cta.php
│   ├── services-categories.php
│   ├── services-categories-grid.php
│   └── service-detail.php
├── templates/             # Page-specific templates
│   ├── page-services.php  # Services page (orchestrator)
│   ├── page-products.php  # Products page
│   ├── page-about.php     # About page
│   ├── page-contact.php   # Contact page
│   ├── single-paksa_service.php   # Single service
│   ├── single-paksa_product.php   # Single product
│   ├── archive-paksa_service.php  # Service archive
│   ├── archive-paksa_product.php  # Product archive
│   ├── taxonomy-paksa_service_cat.php # Service category taxonomy
│   └── taxonomy-paksa_product_cat.php # Product category taxonomy
├── styles/                # Theme styles (for future)
└── screenshot.png         # Theme preview image
```

## Key Decisions

| Decision | Rationale |
|---|---|
| Hybrid theme | Block editor config (theme.json) + PHP template hierarchy for maximum flexibility |
| CSS Custom Properties | Centralized design tokens in variables.css, mirrored in theme.json |
| No external JS libraries | Vanilla JS for performance, minimal dependencies |
| No external CSS frameworks | Custom CSS for performance, no framework bloat |
| IntersectionObserver for animations | Native browser API, no GSAP/animation library needed |
| Semantic HTML5 | Proper landmarks for accessibility and SEO |
| Mobile-first CSS | Responsive design starts from mobile |
| PHP template hierarchy | Standard WordPress templates for broad compatibility |

## Asset Loading Strategy

### CSS (loaded in order)
1. `variables.css` — Design tokens
2. `main.css` — Components, layout, header, footer, sections, animations dependencies
3. `animations.css` — Keyframes and animation rules

### JavaScript (loaded in footer, in order)
1. `main.js` — Header scroll state, js class injection
2. `mobile-nav.js` — Mobile navigation (depends on main.js)
3. `animations.js` — Scroll animations (depends on main.js)

All scripts use `defer` behavior (loaded in footer via `wp_enqueue_script` with `$in_footer = true`).

## Design Token Source of Truth

CSS Custom Properties in `assets/css/variables.css` are the primary design token source. `theme.json` mirrors these tokens for the block editor. When adding a new color, size, or spacing value, update both files.

## Template Hierarchy

The theme follows standard WordPress template hierarchy:
- `front-page.php` — Static front page
- `home.php` — Blog posts index
- `page.php` — Default page
- `single.php` — Single post
- `archive.php` — Archives
- `search.php` — Search results
- `404.php` — Not found
- `header.php` — Header template part
- `footer.php` — Footer template part

All templates use `get_header()` and `get_footer()`.

## SEO Plugin Compatibility

All SEO-related functions in `inc/template-functions.php` check for active SEO plugins (Rank Math, Yoast, AIOSEO) via `paksa_seo_plugin_active()`. When an SEO plugin is detected, theme SEO output is suppressed to prevent duplicate metadata.

## ACF

Not required at this stage. WordPress-native functionality is used. ACF may be added in a future phase for structured data fields.

## Block Editor Support

theme.json provides:
- Color palette (17 colors)
- Font families (Inter + serif + monospace)
- Font sizes (5 presets + custom)
- Layout widths (1280px, 1440px)
- Custom spacing units
- Border radius, shadow support

All design tokens are defined in theme.json for block editor compatibility and in assets/css/variables.css for frontend CSS.
