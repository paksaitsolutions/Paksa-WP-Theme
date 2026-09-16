# PAKSA IT SOLUTIONS — PROJECT SNAPSHOT
> **Purpose:** Single source of truth. Read this FIRST before writing any code.
> Prevents duplicate code, wrong class names, missing dependencies, and conflicts.
> **Last Updated:** Phase 7 Complete

---

## 1. THEME IDENTITY

| Field | Value |
|---|---|
| Theme folder | `paksa-it-solutions/` |
| Text domain | `paksa-it-solutions` |
| Function prefix | `paksa_` |
| CSS class prefix | `pk-` |
| CSS variable prefix | `--pk-` |
| Version constant | `PAKSA_THEME_VERSION` = `'1.0.0'` |
| Dir constant | `PAKSA_THEME_DIR` = `get_template_directory()` |
| URI constant | `PAKSA_THEME_URI` = `get_template_directory_uri()` |

---

## 2. PHASE STATUS

| Phase | Status |
|---|---|
| Phase 1 — Discovery | ✅ COMPLETE |
| Phase 2 — Foundation | ✅ COMPLETE |
| Phase 3 — Master Homepage | ✅ COMPLETE |
| Phase 4 — Master IT Solutions Template | ✅ COMPLETE |
| Phase 5 — Product Templates | ✅ COMPLETE |
| Phase 6 — Content Types (CPTs) | ✅ COMPLETE |
| Phase 7 — Page Templates | ✅ COMPLETE |
| Phase 8 — Testing & Optimization | ✅ COMPLETE |
| Phase 9 — Content Architecture & Admin Experience | ✅ COMPLETE |

---

## 3. FILE INVENTORY — WHAT EXISTS

### Root Templates
| File | Purpose | Notes |
|---|---|---|
| `style.css` | Theme header only | No styles here |
| `functions.php` | Theme setup + requires all `inc/` | Defines constants, registers menus/image sizes |
| `theme.json` | Block editor design tokens | Mirrors variables.css |
| `index.php` | Fallback template | Uses `get_header()` / `get_footer()` |
| `front-page.php` | Homepage | 15 sections via template-parts/home/ |
| `header.php` | Header template | Full header + mobile nav markup |
| `footer.php` | Footer template | Full footer 5-column layout |
| `page.php` | Default page | Basic loop |
| `single.php` | Single post | Meta + thumbnail + nav + comments |
| `archive.php` | Archives | Category/tag/author/date |
| `home.php` | Blog index | Excerpt loop + pagination |
| `search.php` | Search results | With fallback search form |
| `404.php` | Not found | Home + Search buttons |
| `screenshot.png` | Theme preview | Exists |
| `.gitignore` | Git ignore | WordPress-specific |

### Root Templates — Phase 4–7
| File | Purpose |
|---|---|
| `page-services.php` | Master services overview — Template Name: Services / IT Solutions |
| `page-products.php` | Products marketing landing — Template Name: Products / Solutions |
| `page-about.php` | About Us page — Template Name: About Us |
| `page-contact.php` | Contact Us page — Template Name: Contact Us |
| `single-paksa_product.php` | Individual product detail — /solutions/{slug}/ |
| `single-paksa_service.php` | Individual service detail — /services/{slug}/ |
| `archive-paksa_product.php` | Product CPT archive — /solutions/ — native WP loop + pagination |
| `taxonomy-paksa_product_cat.php` | Product taxonomy archive — /solutions/category/{slug}/ |
| `archive-paksa_service.php` | Service CPT archive — /services/ — native WP loop + pagination |
| `taxonomy-paksa_service_cat.php` | Service taxonomy archive — /services/category/{slug}/ |

### `inc/` Files
| File | Functions Defined |
|---|---|
| `enqueue.php` | `paksa_enqueue_assets()` |
| `security.php` | `paksa_security_headers()`, `paksa_remove_wp_version()`, `paksa_disable_embeds()`, `paksa_limit_login_protections()` |
| `performance.php` | `paksa_enable_lazy_loading()`, `paksa_remove_dns_prefetch()`, `paksa_disable_emojis()`, `paksa_script_loader_filter()` |
| `accessibility.php` | `paksa_skip_link()`, `paksa_a11y_wrapper_open()`, `paksa_a11y_wrapper_close()`, `paksa_document_title()`, `paksa_body_class()` |
| `template-functions.php` | `paksa_seo_plugin_active()`, `paksa_get_logo()`, `paksa_get_favicon()`, `paksa_opengraph()`, `paksa_organization_schema()`, `paksa_website_schema()`, `paksa_breadcrumbs()` |
| `template-tags.php` | `paksa_post_meta()`, `paksa_post_thumbnail()`, `paksa_excerpt_length()`, `paksa_excerpt_more()`, `paksa_the_content()`, `paksa_post_navigation()`, `paksa_render_comments()` |
| `customizer.php` | `paksa_customizer_register()`, `paksa_customizer_text()`, `paksa_customizer_textarea()`, `paksa_trust_default()`, `paksa_challenge_problem_default()`, `paksa_get_option()` |
| `icons.php` | `paksa_get_capability_icon()`, `paksa_get_intelligence_icon()`, `paksa_get_why_icon()`, `paksa_get_industry_icon()`, `paksa_get_outcome_icon()` |
| `services-meta.php` | `paksa_svc_meta()`, `paksa_svc_meta_textarea()`, `paksa_svc_meta_url()`, `paksa_register_services_meta_box()`, `paksa_services_meta_box_condition()`, `paksa_render_services_meta_box()`, `paksa_save_services_meta()`, `paksa_services_meta_fields()` |
| `cpt.php` | `paksa_register_product_cpt()`, `paksa_register_product_taxonomy()`, `paksa_flush_rewrite_on_activation()` |
| `product-meta.php` | `paksa_prod_meta()`, `paksa_prod_meta_textarea()`, `paksa_prod_meta_url()`, `paksa_register_product_meta_box()`, `paksa_render_product_meta_box()`, `paksa_save_product_meta()`, `paksa_product_meta_fields()`, `paksa_parse_pipe_list()`, `paksa_parse_industry_list()` |
| `service-cpt.php` | `paksa_register_service_cpt()`, `paksa_register_service_taxonomy()`, `paksa_register_service_meta()`, `paksa_register_product_meta_rest()` |
| `service-meta.php` | `paksa_register_service_meta_box()`, `paksa_render_service_meta_box()`, `paksa_save_service_meta()`, `paksa_service_meta_fields()`, `paksa_get_service_related_products()`, `paksa_get_product_related_services()` |
| `page-meta.php` | `paksa_register_page_meta_boxes()`, `paksa_page_meta_box_conditions()`, `paksa_render_about_meta_box()`, `paksa_render_contact_meta_box()`, `paksa_save_page_meta()`, `paksa_about_meta_fields()`, `paksa_contact_meta_fields()`, `paksa_page_meta()`, `paksa_page_meta_textarea()` |

### `assets/css/`
| File | Contents |
|---|---|
| `variables.css` | ALL `--pk-*` CSS custom properties |
| `main.css` | Reset, typography, containers, grids, sections, buttons, cards, section-header, cta-global, header, mobile-nav, footer |
| `animations.css` | Keyframes, `.pk-animate-*` classes, hover effects, reduced-motion |
| `home.css` | Homepage section styles — loaded on front page, services, products, archive, taxonomy, single service, about, contact |
| `services.css` | Services page styles — loaded only on page-services.php template |
| `products.css` | Products styles + archive pagination — loaded on products pages, archive, taxonomy, single service |
| `archive.css` | Breadcrumbs, service archive/card, about page, contact page — loaded conditionally |

### `assets/js/`
| File | Contents |
|---|---|
| `main.js` | Adds `.js` to `<html>`, sticky header `.scrolled` via rAF |
| `mobile-nav.js` | Open/close mobile nav, focus trap, Escape key, `aria-expanded` |
| `animations.js` | IntersectionObserver scroll reveals, `data-delay`, `data-anim` |
| `home.js` | FAQ accordion — loaded on front page, services, products, archive, taxonomy, single service, about, contact |
| `products.js` | Category filter pill interaction — loaded on page-products.php ONLY |

### `header/` & `footer/`
| File | Status | Notes |
|---|---|---|
| `header/site-header.php` | ✅ Exists | **DUPLICATE** of `header.php` |
| `header/header-styles.css` | ✅ Exists | Header-specific CSS (partial overlap with main.css) |
| `footer/site-footer.php` | ✅ Exists | **DUPLICATE** of `footer.php` |
| `footer/footer-styles.css` | ✅ Exists | Footer-specific CSS (partial overlap with main.css) |

### `docs/`
| File | Contents |
|---|---|
| `docs/architecture.md` | Theme type, structure, asset loading, decisions |
| `docs/design-system.md` | Full color/type/spacing/shadow/animation docs |
| `docs/components.md` | All component HTML patterns and class docs |
| `docs/development-roadmap.md` | Phase checklist |

### `template-parts/home/` — Homepage Sections
| File | Section |
|---|---|
| `hero.php` | 01 Hero |
| `trust-strip.php` | 02 Trust/Capability Strip |
| `challenge.php` | 03 Business Challenge |
| `capabilities.php` | 04 What We Build |
| `technology.php` | 05 Core Technology Capabilities |
| `products.php` | 06 Featured Products |
| `intelligence.php` | 07 AI & Business Intelligence |
| `process.php` | 08 How We Work |
| `why-paksa.php` | 09 Why Paksa |
| `differentiation.php` | 10 How We Are Different |
| `industries.php` | 12 Industries |
| `case-studies.php` | 13 Case Studies |
| `outcomes.php` | 14 Business Outcomes |
| `faq.php` | 15 FAQ |
| `final-cta.php` | 16 Final CTA |

### `template-parts/components/` — Reusable Components
| File | Usage |
|---|---|
| `section-header.php` | All sections — accepts eyebrow/heading/description/align/heading_tag/class |
| `faq-item.php` | FAQ accordion item — accepts question/answer/index/open |
| `product-card.php` | Shared product card — accepts post_id, index, show_filter, heading_tag, link_label |
| `service-card.php` | Shared service card (CPT-driven) — accepts post_id, index, heading_tag, link_label |
| `breadcrumbs.php` | Breadcrumb wrapper — calls paksa_breadcrumbs(), skips on homepage |

### `template-parts/services/` — Services Page Sections (Phase 4)
| File | Section |
|---|---|
| `hero.php` | Services hero — post meta content, service tile visual |
| `overview.php` | Services overview — post meta paragraphs + optional stats |
| `portfolio.php` | Service card grid — filter-driven, CPT-ready |
| `capabilities.php` | Capability detail with feature lists — filter-driven |
| `process.php` | Process steps — reuses homepage process CSS, own filter |
| `industries.php` | Industries — reuses homepage industry CSS and icons |
| `technology.php` | Technology/integration — empty by default, filter-populated |
| `faq.php` | FAQ — reuses faq-item.php component and home.js accordion |
| `cta.php` | CTA — page meta override with global Customizer fallback |

### `template-parts/products/` — Products Listing Sections (Phase 5)
| File | Section |
|---|---|
| `hero.php` | Listing hero — page meta, category filter pills from taxonomy |
| `grid.php` | Product card grid — WP_Query on paksa_product CPT |
| `industries.php` | Industries — reuses homepage industry CSS and icons |
| `faq.php` | FAQ — reuses faq-item.php and home.js accordion |
| `cta.php` | CTA — page meta override with global Customizer fallback |

### `template-parts/product/` — Single Product Sections (Phase 5)
| File | Section |
|---|---|
| `hero.php` | Product hero — post meta, featured image, tagline, badge |
| `overview.php` | Product overview — meta paragraphs + block editor fallback |
| `features.php` | Key features — pipe-delimited meta, any count |
| `modules.php` | Product modules — pipe-delimited meta, any count |
| `benefits.php` | Business benefits — qualitative, no invented stats |
| `industries.php` | Industries — product-specific meta or global fallback |
| `faq.php` | Product FAQ — filter-driven, product-specific |
| `cta.php` | CTA — product meta override with global Customizer fallback |

### `template-parts/service/` — Single Service Sections (Phase 6)
| File | Section |
|---|---|
| `hero.php` | Service hero — post meta, featured image, eyebrow, badge |
| `overview.php` | Service overview — meta paragraphs + block editor fallback |
| `features.php` | Key capabilities — pipe-delimited meta, reuses .pk-prod-features-grid |
| `related-products.php` | Related products — WP_Query by stored IDs, reuses product-card.php component |
| `cta.php` | CTA — service meta override with global Customizer fallback |

### `template-parts/about/` — About Page Sections (Phase 7)
| File | Section |
|---|---|
| `hero.php` | About hero — post meta, falls back to page title |
| `story.php` | Company story — meta paragraphs + block editor fallback |
| `mission.php` | Mission & Vision — meta textareas, hidden if both empty |
| `values.php` | Values — pipe-delimited meta, any count |
| `cta.php` | CTA — page meta override with global Customizer fallback |

### `template-parts/contact/` — Contact Page Sections (Phase 7)
| File | Section |
|---|---|
| `hero.php` | Contact hero — post meta, falls back to page title |
| `info.php` | Contact info — Customizer global data + page meta intro/hours + paksa_contact_form hook |
| `cta.php` | CTA — page meta override with global Customizer fallback |

### Empty Directories (for future phases)
- `templates/` — Custom page templates
- `parts/` — Block template parts
- `patterns/` — Block patterns
- `styles/` — Style variations
- `languages/` — Translation files

---

## 4. WHAT DOES NOT EXIST YET — DO NOT ASSUME IT EXISTS

- ✅ `inc/cpt.php` — paksa_product CPT + paksa_product_cat taxonomy
- ✅ `inc/service-cpt.php` — paksa_service CPT + paksa_service_cat taxonomy
- ✅ `archive-paksa_product.php` — product archive at /solutions/
- ✅ `taxonomy-paksa_product_cat.php` — product taxonomy at /solutions/category/{slug}/
- ✅ `single-paksa_service.php` — individual service at /services/{slug}/
- ✅ `archive-paksa_service.php` — service archive at /services/
- ✅ `taxonomy-paksa_service_cat.php` — service taxonomy at /services/category/{slug}/
- ✅ `page-about.php` — About Us page template
- ✅ `page-contact.php` — Contact Us page template
- ✅ `template-parts/components/product-card.php` — shared product card component
- ✅ `template-parts/components/service-card.php` — shared service card component
- ✅ `template-parts/components/breadcrumbs.php` — breadcrumb wrapper component
- ✅ `inc/page-meta.php` — About + Contact meta boxes
- ✅ `assets/css/archive.css` — breadcrumbs, service archive, about, contact styles
- ❌ No form processing backend (contact form hook exists: `paksa_contact_form`)
- ❌ No `page-case-studies.php`
- ❌ No `inc/schema.php` (schema is in `template-functions.php`)
- ❌ No stats/counter section
- ❌ No testimonials section
- ❌ No WhatsApp floating button
- ❌ No dropdown/mega-menu CSS or JS
- ❌ No ACF integration
- ❌ No custom REST endpoints

---

## 5. CSS CLASSES — COMPLETE REFERENCE

### Layout
```
.container              max-width: 1280px, auto margins, px-6
.container-narrow       max-width: 720px
.container-wide         max-width: 1440px
.container-fluid        max-width: none
.grid                   display: grid, gap: 24px
.grid-2                 1col → 2col @768px
.grid-3                 1col → 3col @768px
.grid-4                 1col → 2col @768px → 4col @1024px
.grid-6                 1col → 3col @1024px → 6col @1280px
```

### Sections
```
.section                padding: 64px 0 (80px @1024px+)
.section-alt            background: --pk-bg-alt
.section-dark           background: --pk-bg-dark, inverts text colors
```

### Typography
```
.display                clamp(2.5rem, 5vw, 4rem), weight 700
.eyebrow                0.75rem, weight 600, uppercase, letter-spacing, color: --pk-accent
.body-large             1.125rem, color: --pk-text-secondary
.body                   1rem, color: --pk-text
.body-small             0.875rem, color: --pk-text-secondary
.caption                0.75rem, color: --pk-text-muted
```

### Buttons (all need `.btn` base + variant)
```
.btn                    base: inline-flex, 0.9375rem, weight 600, radius-md, px-6 py-3
.btn-primary            bg: --pk-primary, text: inverse
.btn-secondary          bg: --pk-accent, text: --pk-text
.btn-outline            border: --pk-primary, transparent bg
.btn-text               transparent, color: --pk-text-link, underline on hover
```

### Cards
```
.card                   bg: --pk-surface, border: --pk-border, radius-lg, p-8
.card-variant-elevated  shadow-sm, lifts on hover (shadow-lg + translateY(-2px))
.card-variant-dark      bg: --pk-surface-dark, border: --pk-border-dark
.card-title             1.25rem, weight 600
.card-description       color: --pk-text-secondary
```

### Section Header
```
.section-header         max-width: 720px, centered, mb-12
.section-header.align-left  left-aligned variant
```

### Global CTA
```
.cta-global             gradient bg (primary→primary-hover), radius-xl, p-16 (p-20 @768px+)
```

### Header & Nav
```
.site-header            sticky top-0, z-100, bg: --pk-bg, border-bottom
.site-header.scrolled   adds shadow-sm (set by main.js)
.header-inner           flex, space-between, height: 72px
.site-logo              flex, align-center, color: --pk-primary
.main-nav               hidden on mobile, block @1024px+
.nav-cta                hidden on mobile, inline-flex @1024px+
.menu-toggle            44x44px, visible on mobile, hidden @1024px+
.mobile-nav             fixed inset-0, z-200, hidden by default
.mobile-nav.is-open     display: flex (set by mobile-nav.js)
.mobile-nav-header      72px height, border-bottom
.mobile-nav-close       44x44px close button
.mobile-nav-list        flex-1, scrollable
.mobile-nav-cta         border-top, full-width btn
```

### Footer
```
.site-footer            bg: --pk-bg-dark, pt-16
.footer-grid            1col → 2col @768px → "2fr 1fr 1fr 1fr 1fr" @1024px
.footer-brand           logo + tagline + social links
.footer-social          flex, gap-4, muted links
.footer-heading         0.75rem, uppercase, letter-spacing, muted
.footer-links           block links, muted color, hover: inverse
.footer-column          wrapper for heading + links
.footer-bottom          flex row @768px+, space-between, border-top
.footer-bottom-links    flex, gap-4, legal links
```

### Animations
```
.pk-animate-fade-up     fade + translateY (triggered by JS)
.pk-animate-fade-in     opacity fade (triggered by JS)
.pk-animate-scale-in    scale 0.95→1 + fade (triggered by JS)
.pk-animate-slide-right translateX + fade (triggered by JS)
.pk-animate-on-scroll   marks element for IntersectionObserver
.pk-hover-lift          translateY(-2px) + shadow on hover
.pk-hover-glow          accent glow shadow on hover
```

**Animation data attributes:**
```html
data-anim="fade-up|fade-in|scale-in|slide-right"
data-delay="0|100|200|300"   (milliseconds)
```

### Archive / Pagination (products.css)
```
.pk-archive-pagination          wrapper for the_posts_pagination()
.pk-archive-pagination .nav-links   flex, centered, gap-2
.pk-archive-pagination .page-numbers  40px min-width, border, radius-md
.pk-archive-pagination .page-numbers.current  bg: --pk-primary
.pk-prod-cat-pill[href]         anchor variant of category pill (archive/taxonomy)
```

---

## 6. PHP FUNCTIONS — COMPLETE REFERENCE

### Call these, don't recreate them:

```php
// Logo HTML — returns <a> wrapping logo or site name
paksa_get_logo( array('class' => 'site-logo', 'show_text' => true, 'link' => home_url('/')) )

// Skip link — outputs <a href="#main-content">
paksa_skip_link()

// Breadcrumbs — SEO-plugin-aware, falls back to theme breadcrumbs
paksa_breadcrumbs()

// Check if SEO plugin active (Rank Math, Yoast, AIOSEO)
paksa_seo_plugin_active() // returns bool

// Post meta — date, author, categories, tags
paksa_post_meta( array('show_date' => true, 'show_author' => true, 'show_categories' => false, 'show_tags' => false) )

// Featured image with lazy loading
paksa_post_thumbnail( 'paksa-large', array() )

// Post prev/next navigation
paksa_post_navigation()

// Comments template wrapper
paksa_render_comments()

// Filtered post content
paksa_the_content()

// Product meta readers (inc/product-meta.php)
paksa_prod_meta( $key, $fallback, $post_id )
paksa_prod_meta_textarea( $key, $fallback, $post_id )
paksa_prod_meta_url( $key, $fallback, $post_id )
paksa_parse_pipe_list( $raw )       // returns array of ['title', 'desc']
paksa_parse_industry_list( $raw )   // returns array of ['name', 'icon']

// Service meta readers (inc/services-meta.php) — works on both Page and paksa_service
paksa_svc_meta( $key, $fallback, $page_id )
paksa_svc_meta_textarea( $key, $fallback, $page_id )
paksa_svc_meta_url( $key, $fallback, $page_id )

// Relationship helpers (inc/service-meta.php)
paksa_get_service_related_products( $service_id )  // returns int[]
paksa_get_product_related_services( $product_id )  // returns int[]

// Customizer option reader
paksa_get_option( $key, $fallback )
```

### Registered WordPress hooks (DO NOT re-register):
```
wp_head        → paksa_get_favicon (priority 1)
wp_head        → paksa_opengraph (priority 1)
wp_head        → paksa_organization_schema (priority 2)
wp_head        → paksa_website_schema (priority 2)
send_headers   → paksa_security_headers
the_generator  → paksa_remove_wp_version
xmlrpc_enabled → __return_false
init           → paksa_disable_embeds (priority 999)
init           → paksa_limit_login_protections
init           → paksa_disable_emojis
wp_enqueue_scripts → paksa_enqueue_assets
wp_get_attachment_image_attributes → paksa_enable_lazy_loading
wp_resource_hints  → paksa_remove_dns_prefetch
script_loader_tag  → paksa_script_loader_filter
document_title_parts → paksa_document_title
body_class     → paksa_body_class
excerpt_length → paksa_excerpt_length (returns 55)
excerpt_more   → paksa_excerpt_more
after_setup_theme → paksa_theme_setup
customize_register → paksa_customizer_register
add_meta_boxes     → paksa_register_services_meta_box
add_meta_boxes     → paksa_services_meta_box_condition (priority 20)
save_post          → paksa_save_services_meta
init               → paksa_register_product_cpt
init               → paksa_register_product_taxonomy
add_meta_boxes     → paksa_register_product_meta_box
save_post_paksa_product → paksa_save_product_meta
init               → paksa_register_service_cpt
init               → paksa_register_service_taxonomy
init               → paksa_register_service_meta
init               → paksa_register_product_meta_rest
add_meta_boxes     → paksa_register_service_meta_box
save_post_paksa_service → paksa_save_service_meta
add_meta_boxes     → paksa_register_page_meta_boxes
add_meta_boxes     → paksa_page_meta_box_conditions (priority 20)
save_post          → paksa_save_page_meta
after_switch_theme → paksa_flush_rewrite_on_activation
```

---

## 7. DESIGN TOKENS — COMPLETE REFERENCE

### Colors
```css
--pk-primary: #1a365d          /* Deep Navy — buttons, headings, logo */
--pk-primary-hover: #2a4a7f
--pk-primary-active: #0d1f3c
--pk-secondary: #2b6cb0        /* Royal Blue — links */
--pk-secondary-hover: #2c5282
--pk-accent: #00b5d8           /* Cyan — CTAs, icons, highlights */
--pk-accent-hover: #0097b5
--pk-accent-active: #007a94
--pk-accent-light: #e6f9fd

--pk-bg: #ffffff
--pk-bg-alt: #f7fafc
--pk-bg-dark: #1a202c
--pk-bg-dark-alt: #2d3748

--pk-surface: #ffffff
--pk-surface-elevated: #ffffff
--pk-surface-dark: #2d3748
--pk-surface-dark-elevated: #374151

--pk-text: #1a202c
--pk-text-secondary: #4a5568
--pk-text-muted: #718096
--pk-text-inverse: #ffffff
--pk-text-inverse-muted: #a0aec0
--pk-text-link: #2b6cb0
--pk-text-link-hover: #1a4a7a

--pk-border: #e2e8f0
--pk-border-strong: #cbd5e0
--pk-border-dark: #4a5568

--pk-success: #38a169    --pk-success-bg: #f0fff4
--pk-warning: #d69e2e    --pk-warning-bg: #fffff0
--pk-error: #e53e3e      --pk-error-bg: #fff5f5
--pk-info: #3182ce       --pk-info-bg: #ebf8ff
```

### Spacing (8px grid)
```css
--pk-space-1: 0.25rem   /* 4px  */
--pk-space-2: 0.5rem    /* 8px  */
--pk-space-3: 0.75rem   /* 12px */
--pk-space-4: 1rem      /* 16px */
--pk-space-5: 1.25rem   /* 20px */
--pk-space-6: 1.5rem    /* 24px */
--pk-space-8: 2rem      /* 32px */
--pk-space-10: 2.5rem   /* 40px */
--pk-space-12: 3rem     /* 48px */
--pk-space-16: 4rem     /* 64px */
--pk-space-20: 5rem     /* 80px */
--pk-space-24: 6rem     /* 96px */
--pk-space-32: 8rem     /* 128px */
```

### Radius, Shadows, Transitions
```css
--pk-radius-sm: 4px
--pk-radius-md: 8px
--pk-radius-lg: 16px
--pk-radius-xl: 24px
--pk-radius-full: 9999px

--pk-shadow-sm: 0 1px 3px rgba(26,32,44,0.08)
--pk-shadow-md: 0 4px 12px rgba(26,32,44,0.1)
--pk-shadow-lg: 0 8px 24px rgba(26,32,44,0.12)
--pk-shadow-xl: 0 16px 48px rgba(26,32,44,0.16)

--pk-transition-fast: 150ms ease
--pk-transition-base: 250ms ease
--pk-transition-slow: 350ms ease
```

### Containers & Font
```css
--pk-container: 1280px
--pk-container-narrow: 720px
--pk-container-wide: 1440px
--pk-font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif
```

---

## 8. REGISTERED WORDPRESS FEATURES

### Theme Supports (in `functions.php`)
```
title-tag, post-thumbnails, html5 (comment-list, comment-form, search-form, gallery, caption),
custom-logo (200x60, flex), align-wide, editor-styles, editor-color-palette, wp-block-styles
```

### Navigation Menus
```
'primary'  → Primary Menu (header desktop + mobile)
'footer'   → Footer Menu
'social'   → Social Links
```

### Custom Image Sizes
```
'paksa-thumb'   → 375x250 (cropped)
'paksa-medium'  → 768x512 (cropped)
'paksa-large'   → 1280x720 (cropped)
```

### Enqueued Assets (handles)
```css
paksa-variables   → assets/css/variables.css
paksa-main        → assets/css/main.css (depends: paksa-variables)
paksa-animations  → assets/css/animations.css (depends: paksa-main)
paksa-home        → assets/css/home.css (depends: paksa-main) — front page + services + products + archive + taxonomy + single service + about + contact
paksa-services    → assets/css/services.css (depends: paksa-main) — page-services.php only
paksa-products    → assets/css/products.css (depends: paksa-main) — products pages + archive + taxonomy + single service
paksa-archive     → assets/css/archive.css (depends: paksa-main) — service archive/taxonomy, about, contact, product archive/taxonomy (breadcrumbs)
```
```js
paksa-main          → assets/js/main.js (footer)
paksa-mobile-nav    → assets/js/mobile-nav.js (footer, depends: paksa-main)
paksa-animations-js → assets/js/animations.js (footer, depends: paksa-main)
paksa-home          → assets/js/home.js (footer, depends: paksa-main) — front page + services + products + archive + taxonomy + single service + about + contact
paksa-products      → assets/js/products.js (footer, depends: paksa-main) — page-products.php ONLY
```

---

## 9. NAVIGATION STRUCTURE (from requirements.md)

```
Home
Our Services ▾
  ├── AI & ML Solutions
  ├── AI Automation Services
  ├── Data Science & Analytics
  └── Software Development
Solutions ▾
  ├── Paksa ERP
  ├── EventLogic
  ├── TourLedger
  ├── Paksa PoultryPro
  └── Salon Management
About ▾
  ├── About Us
  ├── Blog
  ├── Open Source Projects
  └── Case Studies
Contact Us
```

### Footer Columns (from requirements.md)
```
Products:  Paksa ERP, EventLogic, TourLedger, PoultryPro, Salon Management
Services:  AI & ML, AI Automation, Data Science, Software Dev, Contact Us
Company:   About Us, Blog, Privacy Policy, Terms & Conditions, Refund Policy
```

---

## 10. BREAKPOINTS

```
Mobile:        < 640px
Tablet:        640px – 1023px
Desktop:       1024px – 1279px
Large Desktop: 1280px+
```

CSS media queries used in codebase:
```css
@media (min-width: 768px)  { ... }
@media (min-width: 1024px) { ... }
@media (min-width: 1280px) { ... }
@media (max-width: 1023px) { ... }   /* mobile-only overrides */
```

---

## 11. SECURITY CONSTANTS DEFINED

```php
define('DISALLOW_FILE_EDIT', true);   // in inc/security.php
define('FORCE_SSL_ADMIN', true);      // in inc/security.php
```
> Do NOT redefine these anywhere else.

---

## 12. KNOWN DUPLICATIONS (intentional — do not "fix" without checking)

| Duplication | Reason |
|---|---|
| `header.php` = `header/site-header.php` | Both exist; `header.php` is used by WP template hierarchy; `header/` version is for future `get_template_part()` use |
| `footer.php` = `footer/site-footer.php` | Same as above |
| Some CSS in `main.css` overlaps `header/header-styles.css` | `header-styles.css` is supplemental; `main.css` is the primary source |
| Some CSS in `main.css` overlaps `footer/footer-styles.css` | Same as above |
| Product card markup repeated in archive, taxonomy, related-products | Resolved in Phase 7 — extracted to template-parts/components/product-card.php |

---

## 13. RULES — ALWAYS FOLLOW

1. **Never hardcode hex colors** — always use `--pk-*` CSS variables
2. **Never hardcode spacing px values** — always use `--pk-space-*`
3. **Never add jQuery** — vanilla JS only
4. **Never add CSS frameworks** (Bootstrap, Tailwind) — custom CSS only
5. **Never duplicate hook registrations** — check section 6 before adding `add_action`/`add_filter`
6. **Never output SEO meta without `paksa_seo_plugin_active()` guard**
7. **Always use `esc_html()`, `esc_url()`, `esc_attr()` on all output**
8. **Always use `__()` / `esc_html_e()` for translatable strings with domain `paksa-it-solutions`**
9. **Always check `if (!defined('ABSPATH')) exit;` at top of every PHP file**
10. **New CSS goes in `main.css`** unless it's component-specific (then new file in `assets/css/`)
11. **New PHP helper functions go in `template-functions.php`** or `template-tags.php`
12. **New hooks/filters go in the relevant `inc/` file**, not in `functions.php` directly
13. **`front-page.php` is the homepage** — do not use `index.php` for homepage content
14. **`id="main-content"` is on `<main>` in `header.php`** — skip link target, do not change
15. **`paksa_svc_meta()` works on both `page` and `paksa_service` post types** — reads by post ID
16. **`paksa_page_meta()` and `paksa_page_meta_textarea()` are for About/Contact pages only** — prefix `_paksa_page_`
17. **Contact form uses `do_action('paksa_contact_form')` hook** — no backend in theme; hook in from plugin or child theme

---

## 14. COMPANY DATA (for hardcoded fallbacks only)

```
Name:     Paksa IT Solutions
Address:  13-A-1 Commercial Area, PIA Housing Society, Lahore, Pakistan
Email:    info@paksa.com.pk / sales@paksa.com.pk
Phone:    +92 305 7772572 / +92 314 4676210
WhatsApp: https://api.whatsapp.com/send/?phone=923144676210
Facebook: https://www.facebook.com/PaksaITSolutions
Twitter:  https://twitter.com/PaksaPk
LinkedIn: https://www.linkedin.com/company/paksaitsolutions
Website:  https://paksa.com.pk
```

---

## 15. PERFORMANCE TARGETS

| Metric | Target |
|---|---|
| Lighthouse Performance | 95+ |
| Lighthouse Accessibility | 95+ |
| Lighthouse Best Practices | 95+ |
| Lighthouse SEO | 95+ |
| LCP | < 2.5s |
| CLS | < 0.1 |
| TBT | < 200ms |

---

## 16. CONTENT ARCHITECTURE (Phases 6–7)

### URL Structure
```
Products:
  /solutions/                        → archive-paksa_product.php (native CPT archive)
  /solutions/{product-slug}/         → single-paksa_product.php
  /solutions/category/{term-slug}/   → taxonomy-paksa_product_cat.php

Services:
  /services/                         → archive-paksa_service.php (native CPT archive)
  /services/{service-slug}/          → single-paksa_service.php
  /services/category/{term-slug}/    → taxonomy-paksa_service_cat.php

Marketing landing pages (Pages with custom templates):
  {any-slug}/  → page-products.php  (Template: Products / Solutions)
  {any-slug}/  → page-services.php  (Template: Services / IT Solutions)
  {any-slug}/  → page-about.php     (Template: About Us)
  {any-slug}/  → page-contact.php   (Template: Contact Us)
```

### CPTs Registered
| CPT | Slug | Archive | Menu Position | Icon |
|---|---|---|---|---|
| `paksa_product` | `solutions` | `solutions` | 5 | dashicons-grid-view |
| `paksa_service` | `services` | `services` | 6 | dashicons-hammer |

### Taxonomies Registered
| Taxonomy | CPT | Slug | Hierarchical |
|---|---|---|---|
| `paksa_product_cat` | `paksa_product` | `solutions/category` | Yes |
| `paksa_service_cat` | `paksa_service` | `services/category` | Yes |

### Service Architecture Decision
- Services were previously: single Page + post meta (`page-services.php`)
- Phase 6 adds: `paksa_service` CPT for individual service pages at `/services/{slug}/`
- `page-services.php` is **retained** as the master services overview/marketing landing page
- No existing data was modified. No migration required.
- Individual service CPT posts are new content — created fresh in WordPress admin.

### Service → Product Relationship
- Direction: **bidirectional** (both sides store IDs)
- Service stores: `_paksa_svc_related_products` (comma-separated `paksa_product` IDs)
- Product stores: `_paksa_prod_related_services` (comma-separated `paksa_service` IDs)
- Managed from: service edit screen (multi-select) + product edit screen (multi-select)
- Helpers: `paksa_get_service_related_products($id)`, `paksa_get_product_related_services($id)`
- Rationale: bidirectional allows querying from either side without expensive `meta_query`

### Archive vs Marketing Page
| URL | Template | Purpose |
|---|---|---|
| `/solutions/` | `archive-paksa_product.php` | Native WP CPT archive — auto-populated, paginated |
| `/{page-slug}/` | `page-products.php` | Marketing landing page — custom hero, JS filter pills, industries section |
| `/solutions/{slug}/` | `single-paksa_product.php` | Individual product detail |
| `/solutions/category/{slug}/` | `taxonomy-paksa_product_cat.php` | Filtered by category, native WP nav |

### JS Category Filter Decision
- `products.js` (JS filter pills) loads on `page-products.php` **only**
- Archive and taxonomy pages use native `<a>` links for category navigation
- Rationale: native links are crawlable, accessible without JS, and semantically correct for archive/taxonomy pages

### Rewrite Flush
- Flush occurs **only** on `after_switch_theme` hook
- `paksa_flush_rewrite_on_activation()` registers all CPTs/taxonomies then calls `flush_rewrite_rules()`
- Does **not** flush on every request
- **Administrators:** visit Settings → Permalinks after any CPT/taxonomy slug change

### Admin Structure
```
Products (menu_position: 5, dashicons-grid-view)
  ├── All Products
  ├── Add New Product
  └── Categories

Services (menu_position: 6, dashicons-hammer)
  ├── All Services
  ├── Add New Service
  └── Categories
```

### Meta Prefixes
| Context | Prefix | File |
|---|---|---|
| Services overview page | `_paksa_svc_` | `inc/services-meta.php` |
| Service CPT posts | `_paksa_svc_` | `inc/service-meta.php` |
| Product CPT posts | `_paksa_prod_` | `inc/product-meta.php` |
| Products listing page | `_paksa_prod_listing_` | read directly in `page-products.php` |
| About page | `_paksa_page_` | `inc/page-meta.php` |
| Contact page | `_paksa_page_` | `inc/page-meta.php` |

### Migration Status
- No migration required for Services.
- `page-services.php` and all `_paksa_svc_*` meta on Page posts are untouched.
- `paksa_service` CPT is additive — new posts, new URLs, no data destruction.
- Manual migration procedure (if desired):
  1. Create new `paksa_service` post for each service
  2. Fill in meta box fields (hero, overview, capabilities, related products)
  3. Set permalink slug to match desired `/services/{slug}/` URL
  4. Update navigation menus to point to new CPT URLs

### register_post_meta() Coverage
- `paksa_service`: public identity fields exposed via REST (`show_in_rest: true`)
- `paksa_service`: internal fields registered but not exposed (`show_in_rest: false`)
- `paksa_product`: public identity fields exposed via REST (`show_in_rest: true`)
- `paksa_product`: `_paksa_prod_related_services` registered, not exposed via REST

### Known Limitations (Phase 8)
- Lighthouse testing unavailable — no WordPress runtime in development environment. A Lighthouse execution checklist is provided below.
- Dark mode is intentionally disabled (partial token set commented out in variables.css). Full dark mode is a future phase.
- Contact form has no backend. Uses `do_action('paksa_contact_form')` hook.
- `paksa_breadcrumbs()` defers to SEO plugin when active.

### Lighthouse Execution Checklist (run on real deployment)
```
1. Install theme on WordPress 6.1+ with PHP 8.1+
2. Create pages: Homepage, Services, Products, About, Contact
3. Assign correct templates to each page
4. Create at least 2 paksa_product and 2 paksa_service CPT posts
5. Run Lighthouse (Chrome DevTools > Lighthouse tab) against:
   - Homepage (front-page.php)
   - /services/ (archive-paksa_service.php)
   - /solutions/ (archive-paksa_product.php)
   - /services/{slug}/ (single-paksa_service.php)
   - /solutions/{slug}/ (single-paksa_product.php)
   - About page (page-about.php)
   - Contact page (page-contact.php)
6. Target: Performance 95+, Accessibility 95+, Best Practices 95+, SEO 95+
7. Check: LCP < 2.5s, CLS < 0.1, TBT < 200ms
```

### Phase 8 — Bugs Fixed
| Bug | File | Severity |
|---|---|---|
| `paksa_seo_plugin_active()` used non-existent function names for Yoast/AIOSEO | `inc/template-functions.php` | Medium |
| `paksa_get_logo()` double-wrapped `get_custom_logo()` in a second `<a>` tag | `inc/template-functions.php` | High |
| `paksa_organization_schema()` hardcoded social URLs instead of reading Customizer | `inc/template-functions.php` | Low |
| `paksa_save_services_meta()` missing post_type + template validation | `inc/services-meta.php` | High |
| `paksa_save_page_meta()` About/Contact shared same nonce action | `inc/page-meta.php` | Medium |
| `DISALLOW_FILE_EDIT` / `FORCE_SSL_ADMIN` not guarded with `defined()` check | `inc/security.php` | Low |
| `$_SERVER['REMOTE_ADDR']` read without sanitization | `inc/security.php` | Medium |
| `next_post_link()` had PHP tags embedded inside a string literal | `inc/template-tags.php` | High |
| `get_search_query()` not escaped in `printf()` in search.php | `search.php` | Medium |
| `term_description()` not escaped in archive.php | `archive.php` | Medium |
| Footer social links read non-existent `paksa_social_links` theme mod | `footer.php` | Low |
| `date('Y')` not localized or escaped in copyright | `footer.php` | Low |
| Header CTA buttons hardcoded `#contact` anchor | `header.php` | Low |
| `animations.js` observed all `h2, h3, h4, p, .eyebrow` globally — CLS risk | `assets/js/animations.js` | Medium |
| Partial dark mode token override caused inconsistent rendering | `assets/css/variables.css` | Low |
| `archive-paksa_product.php` missing breadcrumbs | `archive-paksa_product.php` | Low |
| `taxonomy-paksa_product_cat.php` missing breadcrumbs | `taxonomy-paksa_product_cat.php` | Low |
| `index.php` had redundant `have_posts()` check inside loop | `index.php` | Low |

### Shared Components (Phase 7)
| Component | Replaces | Used In |
|---|---|---|
| `product-card.php` | Inline card markup in 4 files | archive, taxonomy, grid, related-products |
| `service-card.php` | No prior equivalent | service archive, service taxonomy |
| `breadcrumbs.php` | Direct `paksa_breadcrumbs()` calls | all archive/single/page templates |

### About Page Content Model
- Hero: post meta (`_paksa_page_hero_*`)
- Story: post meta paragraphs OR block editor fallback
- Mission/Vision: post meta textareas (hidden if both empty)
- Values: pipe-delimited post meta (`Title | Description` per line)
- CTA: post meta override → Customizer fallback

### Contact Page Content Model
- Hero: post meta (`_paksa_page_hero_*`)
- Phone/Email/Address/WhatsApp: Customizer (Global Site Settings > Contact Information)
- Intro paragraph + business hours: post meta
- Form: `paksa_contact_form` action hook (no backend in this phase)
- CTA: post meta override → Customizer fallback

### Recommended Next Phase
**Phase 8 — Testing & Optimization**
- Cross-browser testing
- Accessibility audit (WCAG 2.1 AA)
- Performance audit (Lighthouse 95+)
- SEO audit
- Mobile/responsive review
- Form processing implementation (contact form)
- Navigation menu setup
- Content population guidance

---

## 17. PHASE 9 — CONTENT ARCHITECTURE & ADMIN EXPERIENCE

### Phase 9 Status: COMPLETE

---

### Content Architecture — Authoritative Sources

| Content Type | Source | Location |
|---|---|---|
| Global contact info (phone, email, address, WhatsApp) | Customizer | Global Site Settings → Contact Information |
| Social media URLs | Customizer | Global Site Settings → Social Media Links |
| Global CTA (heading, description, buttons) | Customizer | Homepage → Final CTA |
| Header CTA URL | Customizer | `paksa_cta_primary_url` |
| Homepage hero | Customizer | Homepage → Hero Section |
| Homepage trust strip | Customizer | Homepage → Trust / Capability Strip |
| Homepage challenge | Customizer | Homepage → Business Challenge |
| Homepage capabilities heading | Customizer | Homepage → What We Build |
| Homepage technology heading | Customizer | Homepage → Technology Capabilities Section |
| Homepage intelligence heading | Customizer | Homepage → AI & Business Intelligence Section |
| Homepage process heading | Customizer | Homepage → How We Work |
| Homepage why-paksa heading | Customizer | Homepage → Why Paksa Section |
| Homepage differentiation heading | Customizer | Homepage → How We Are Different Section |
| Homepage industries heading | Customizer | Homepage → Industries Section |
| Homepage outcomes heading | Customizer | Homepage → Business Outcomes Section |
| Homepage FAQ heading | Customizer | Homepage → FAQ Section |
| Homepage section visibility | Customizer | Homepage → Section Visibility |
| Homepage featured products | CPT query | `paksa_product` (featured=1, or first 4) |
| Homepage case studies | Filter | `paksa_case_studies_items` (default empty) |
| Products listing page hero/CTA | Post meta | `_paksa_prod_listing_*` via Products Page Content meta box |
| Products listing section visibility | Post meta | `_paksa_prod_listing_show_*` |
| Individual product content | CPT + post meta | `paksa_product` + `_paksa_prod_*` |
| Product FAQ | Post meta | `_paksa_prod_faq_items` (pipe-delimited) → filter fallback |
| Services overview page | Post meta | `_paksa_svc_*` via Services Page Content meta box |
| Services portfolio grid | CPT query | `paksa_service` (when published) → filter fallback |
| Individual service content | CPT + post meta | `paksa_service` + `_paksa_svc_*` |
| About page content | Post meta | `_paksa_page_*` via About Page Content meta box |
| Contact page content | Post meta | `_paksa_page_*` via Contact Page Content meta box |
| Footer navigation columns | Customizer | `paksa_footer_company`, `paksa_footer_solutions`, etc. |
| Footer social links | Customizer | `paksa_social_facebook/twitter/linkedin/github` |
| Footer copyright year | WordPress | `wp_date('Y')` |

---

### Predefined Pages & Templates

| Page | Template | Content Source |
|---|---|---|
| Homepage | `front-page.php` | Customizer + CPT queries |
| Blog Index | `home.php` | Native WordPress loop |
| Default Page | `page.php` | Block editor |
| Single Post | `single.php` | Block editor |
| Services Overview | `page-services.php` (Template: Services / IT Solutions) | Post meta `_paksa_svc_*` |
| Products / Solutions | `page-products.php` (Template: Products / Solutions) | Post meta `_paksa_prod_listing_*` |
| About Us | `page-about.php` (Template: About Us) | Post meta `_paksa_page_*` |
| Contact Us | `page-contact.php` (Template: Contact Us) | Post meta `_paksa_page_*` + Customizer |
| Product Archive | `archive-paksa_product.php` | Native WP loop |
| Product Category | `taxonomy-paksa_product_cat.php` | Native WP loop |
| Single Product | `single-paksa_product.php` | Post meta `_paksa_prod_*` |
| Service Archive | `archive-paksa_service.php` | Native WP loop |
| Service Category | `taxonomy-paksa_service_cat.php` | Native WP loop |
| Single Service | `single-paksa_service.php` | Post meta `_paksa_svc_*` |
| Search | `search.php` | Native WP loop |
| 404 | `404.php` | Static UI strings |

---

### Homepage Section Visibility

All 15 homepage sections can be individually shown/hidden from:
**Appearance → Customize → Homepage → Section Visibility**

Customizer settings: `paksa_home_show_{section_key}` (values: `'1'` = show, `'0'` = hide)

Section keys: `hero`, `trust_strip`, `challenge`, `capabilities`, `technology`, `products`,
`intelligence`, `process`, `why_paksa`, `differentiation`, `industries`, `case_studies`,
`outcomes`, `faq`, `final_cta`

Filter: `paksa_homepage_section_visibility` — allows programmatic override.

---

### Product Administration

Admins create/edit products at: **Products → Add New Product**

Fields available in the "Product Details" meta box:
- Product Identity: tagline, category label, badge, featured flag
- Hero: eyebrow, heading, description, CTA buttons
- Overview: eyebrow, heading, content paragraphs
- Key Features: eyebrow, heading, description, pipe-delimited feature list
- Modules: eyebrow, heading, description, pipe-delimited module list
- Business Benefits: eyebrow, heading, pipe-delimited benefit list
- Industries: pipe-delimited `Name | icon-key` list
- FAQ: pipe-delimited `Question | Answer` list (one per line) — NEW in Phase 9
- CTA Override: heading, description, buttons
- Related Services: multi-select from published services
- Section Visibility: per-section show/hide controls

To mark a product as featured (shown on homepage): set "Featured Product" to "Yes".

---

### Service Administration

Admins create/edit services at: **Services → Add New Service**

Fields available in the "Service Details" meta box:
- Service Identity: tagline, category label, badge, featured flag
- Hero: eyebrow, heading, description, CTA buttons
- Overview: eyebrow, heading, content paragraphs
- Key Capabilities: eyebrow, heading, pipe-delimited capability list
- Related Products: multi-select from published products
- CTA Override: heading, description, buttons
- Section Visibility: per-section show/hide controls

---

### Taxonomy Management

| Taxonomy | Admin Location | URL Pattern |
|---|---|---|
| Product Categories | Products → Categories | `/solutions/category/{slug}/` |
| Service Categories | Services → Categories | `/services/category/{slug}/` |

---

### Service ↔ Product Relationships

- Direction: **bidirectional** — both sides store IDs
- Service stores: `_paksa_svc_related_products` (comma-separated product IDs)
- Product stores: `_paksa_prod_related_services` (comma-separated service IDs)
- Managed from: both the service edit screen and the product edit screen
- Deleted content: WP_Query uses `post_status => 'publish'` — deleted/trashed posts are automatically excluded from output
- Duplicate IDs: `array_filter( array_map( 'absint', ... ) )` removes zeros; WP_Query deduplicates
- Helpers: `paksa_get_service_related_products($id)`, `paksa_get_product_related_services($id)`
- Sync: manual bidirectional — admin must update both sides for full consistency

---

### FAQ Architecture

| Context | Storage | Admin Interface |
|---|---|---|
| Homepage FAQ | Customizer headings + `paksa_homepage_faq_items` filter | Customizer (headings) + filter (items) |
| Services page FAQ | `paksa_svc_faq_items` filter | Filter |
| Products page FAQ | `paksa_prod_faq_items` filter | Filter |
| Single product FAQ | `_paksa_prod_faq_items` post meta (pipe-delimited) → filter fallback | Product meta box |
| Single service FAQ | Not implemented (section not in service CPT template) | N/A |

Format for pipe-delimited FAQ: `Question | Answer` — one item per line.

---

### Contact Form Architecture

The contact page uses `do_action('paksa_contact_form')` in `template-parts/contact/info.php`.

No form backend is implemented in the theme. To add a form:
```php
add_action( 'paksa_contact_form', function() {
    // Output your form here — e.g. a shortcode, custom HTML form, etc.
    echo do_shortcode('[your-form-shortcode]');
} );
```
If nothing is hooked, the template shows an email fallback link.

---

### Global Settings Location

**Appearance → Customize → Global Site Settings**

| Setting | Customizer Key |
|---|---|
| Phone | `paksa_phone` |
| Email | `paksa_email` |
| Address | `paksa_address` |
| WhatsApp URL | `paksa_whatsapp_url` |
| Facebook URL | `paksa_social_facebook` |
| Twitter/X URL | `paksa_social_twitter` |
| LinkedIn URL | `paksa_social_linkedin` |
| GitHub URL | `paksa_social_github` |

---

### Content Population Note

The theme ships without fabricated Paksa business content. All production content
(products, services, case studies, company information) must be entered through WordPress:
- Products: Products → Add New Product
- Services: Services → Add New Service
- Homepage content: Appearance → Customize → Homepage
- Global settings: Appearance → Customize → Global Site Settings
- Page content: Edit each page → meta box fields

---

### Phase 9 — Files Created

| File | Purpose |
|---|---|
| `inc/products-listing-meta.php` | Meta box for `page-products.php` template (`_paksa_prod_listing_*` fields) |

### Phase 9 — Files Modified

| File | Change |
|---|---|
| `front-page.php` | Added section visibility controls via Customizer |
| `inc/customizer.php` | Added Customizer sections for Technology, Intelligence, Differentiation, Outcomes, and Homepage Section Visibility |
| `inc/product-meta.php` | Added `faq_items` field to product meta box |
| `functions.php` | Added `require_once` for `products-listing-meta.php` |
| `template-parts/home/products.php` | Replaced hardcoded product array with `WP_Query` on `paksa_product` CPT |
| `template-parts/home/case-studies.php` | Removed fabricated case study; default is now empty array |
| `template-parts/home/technology.php` | Section heading/eyebrow/description now Customizer-driven |
| `template-parts/home/intelligence.php` | Section heading/eyebrow/description now Customizer-driven |
| `template-parts/home/differentiation.php` | Section heading/eyebrow/description now Customizer-driven |
| `template-parts/home/outcomes.php` | Section heading/eyebrow/description now Customizer-driven |
| `template-parts/product/faq.php` | Reads from `_paksa_prod_faq_items` post meta first, then filter fallback |
| `template-parts/services/portfolio.php` | Prefers CPT query when published services exist; static filter is fallback |

### Phase 9 — Data Contract Changes

**Meta keys added:**
- `_paksa_prod_faq_items` — pipe-delimited FAQ for single product pages
- `_paksa_prod_listing_eyebrow`, `_paksa_prod_listing_heading`, `_paksa_prod_listing_desc` — products listing page hero
- `_paksa_prod_listing_cta1_text`, `_paksa_prod_listing_cta1_url`, `_paksa_prod_listing_cta2_text`, `_paksa_prod_listing_cta2_url` — products listing CTAs
- `_paksa_prod_listing_show_hero`, `_paksa_prod_listing_show_grid`, `_paksa_prod_listing_show_industries`, `_paksa_prod_listing_show_faq`, `_paksa_prod_listing_show_cta` — products listing visibility

**Customizer options added:**
- `paksa_technology_eyebrow/heading/description`
- `paksa_intelligence_eyebrow/heading/description`
- `paksa_diff_eyebrow/heading/description`
- `paksa_outcomes_eyebrow/heading/description`
- `paksa_home_show_{section_key}` × 15 (homepage section visibility)

**Hooks added:**
- Filter: `paksa_homepage_section_visibility` — programmatic homepage section visibility override

**No existing meta keys, options, hooks, or filters were renamed or removed.**

### Phase 9 — Known Limitations

- Homepage case studies section is hidden by default until real case studies are provided via `paksa_case_studies_items` filter.
- Service FAQ on single service pages is not yet meta-driven (no `_paksa_svc_faq_items` field). Service FAQ can be added via `paksa_service_faq_items` filter.
- Runtime testing unavailable — no WordPress installation in environment. Static validation performed.
- Relationship sync is manual bidirectional — admin must update both product and service sides for full consistency.

### Phase 9 — Compatibility

All existing Product/Service URLs, taxonomy URLs, meta keys, Customizer settings, component contracts, and relationships remain fully compatible. No breaking changes.

---

## 18. PHASE 10 — NAVIGATION, FRONTEND UX & CONTENT ARCHITECTURE COMPLETION

### Phase 10 Status: COMPLETE

---

### Navigation

#### Registered Menu Locations

| Location | Slug | Purpose |
|---|---|---|
| Primary Navigation | `primary` | Desktop header nav + mobile nav |
| Footer Navigation | `footer` | Footer column 1 (Company links) |

**Removed:** `social` menu location — social links are managed via Customizer → Global Site Settings → Social Media Links. Registering a second source would create a duplicate source of truth.

#### How Administrators Assign Menus

1. Go to **Appearance → Menus**
2. Create a menu (e.g. "Main Navigation")
3. Add pages, CPT posts, custom links, or categories
4. Under "Menu Settings → Display location", check **Primary Navigation**
5. Save Menu
6. Repeat for **Footer Navigation**

#### Nested Menu Support

- Desktop: `depth=2` — top-level items with children get a `<button class="pk-dropdown-toggle">` injected by `Paksa_Nav_Walker`
- The link (`<a>`) and the toggle (`<button>`) are separate interactive elements — the link navigates, the button opens/closes the submenu
- Submenu panel: `<ul class="pk-submenu" role="menu">` — positioned absolutely below the parent item
- CSS: `.pk-has-dropdown`, `.pk-dropdown-toggle`, `.pk-submenu`, `.pk-submenu.is-open` in `assets/css/main.css`

#### Desktop Dropdown Keyboard Behaviour

| Key | Behaviour |
|---|---|
| `Tab` to toggle button | Focus visible on toggle |
| `Enter` / `Space` on toggle | Opens/closes submenu |
| `Escape` in submenu | Closes submenu, returns focus to toggle |
| `Tab` out of last submenu item | Closes submenu |
| Click outside | Closes all open submenus |

#### Mobile Navigation

- `depth=2` — submenus are included in mobile nav markup
- Mobile submenu toggle: same `.pk-dropdown-toggle` button, handled by `main.js` mobile section
- Submenu opens inline (not absolutely positioned) — stacks below parent item
- CSS: `.pk-mobile-menu .pk-submenu`, `.pk-mobile-menu .pk-has-dropdown` in `assets/css/main.css`
- Existing mobile nav open/close/focus-trap/Escape behaviour from `mobile-nav.js` is unchanged

#### No-Menu Fallback

`fallback_cb => false` — when no menu is assigned to `primary`, the `<nav>` renders empty. No fabricated navigation links are shown.

#### Footer Navigation

- Rendered via `wp_nav_menu()` with `Paksa_Footer_Nav_Walker` — outputs plain `<a>` tags matching `.footer-links a` CSS
- Replaces the hardcoded `get_theme_mod('paksa_footer_company', [...])` array that had `url => '#'` placeholders
- Only renders when a menu is assigned to the `footer` location (`has_nav_menu('footer')` guard)
- Remaining footer columns (Solutions, Products, Resources) still use `get_theme_mod()` arrays — these are a known limitation for a future phase

#### New Files

| File | Purpose |
|---|---|
| `inc/nav-walker.php` | `Paksa_Nav_Walker` (desktop dropdown) + `Paksa_Footer_Nav_Walker` (footer plain links) |

---

### WhatsApp Floating Button

#### Configuration Source

| Setting | Customizer Key | Location |
|---|---|---|
| WhatsApp URL | `paksa_whatsapp_url` | Global Site Settings → Contact Information |
| Button Visibility | `paksa_whatsapp_show` | Global Site Settings → Contact Information |

No new URL setting was created — `paksa_whatsapp_url` already existed from Phase 7. Only the visibility toggle (`paksa_whatsapp_show`) is new.

#### Rendering Behaviour

- Button renders on every page via `footer.php` → `get_template_part('template-parts/components/whatsapp-fab')`
- Does **not** render if `paksa_whatsapp_url` is empty
- Does **not** render if `paksa_whatsapp_show` is `'0'`
- Opens in new tab with `rel="noopener noreferrer"`
- Accessible label: `aria-label="Chat with us on WhatsApp"`
- Keyboard accessible: visible focus ring via `:focus-visible`
- Mobile-safe: `position: fixed; bottom: 24px; right: 24px` — reduced to 20px on mobile
- Does not cause horizontal overflow (fixed positioning, right-aligned)
- CSS: `.pk-whatsapp-fab` in `assets/css/main.css`
- Respects `prefers-reduced-motion`

#### New Files

| File | Purpose |
|---|---|
| `template-parts/components/whatsapp-fab.php` | Reusable WhatsApp FAB component |

---

### Service FAQ

#### Meta Key

`_paksa_svc_faq_items`

#### Input Format

```
Question | Answer
```

One item per line. Pipe (`|`) separates question from answer. Leave blank to hide the FAQ section.

#### Admin Interface

Available in the **Service Details** meta box on `paksa_service` edit screens, under the **FAQ** section.

#### Save Behaviour

- Saved via `paksa_save_service_meta()` in `inc/service-meta.php`
- Sanitized with `sanitize_textarea_field()`
- Full security: nonce verification, `DOING_AUTOSAVE` check, `current_user_can('edit_post')`, post type check (`paksa_service`)

#### Data Precedence

1. Post meta: `_paksa_svc_faq_items` (pipe-delimited, one per line)
2. Filter fallback: `paksa_service_faq_items` (for programmatic population)

Matches the product FAQ contract exactly.

#### Filter Compatibility

`paksa_service_faq_items` filter is preserved. If post meta is empty, the filter is applied. Existing filter hooks are not broken.

#### Frontend Rendering

- Template: `template-parts/service/faq.php` (new file)
- Reuses `template-parts/components/faq-item.php` accordion component
- Reuses `home.js` FAQ accordion (already loaded on `is_singular('paksa_service')`)
- Section heading: "Questions About {Service Name}"
- Empty state: section does not render (returns early)
- Controlled by `_paksa_svc_show_faq` post meta (Section Visibility in meta box)

#### New Files

| File | Purpose |
|---|---|
| `template-parts/service/faq.php` | Service FAQ section — meta-driven with filter fallback |

---

### Case Studies

**Status: Deferred — filter-driven architecture retained**

**Reason:** The existing `paksa_case_studies_items` filter contract is correct and complete. The homepage section is hidden by default (empty array) and will only show when real case studies are provided. No CPT is justified at this stage because:

1. No independently managed case study entities exist yet
2. No dedicated case study page is required by the current site architecture
3. The filter contract allows case studies to be added from a child theme or plugin without modifying the theme
4. Creating a CPT for zero content would add admin complexity with no benefit

**To add case studies when ready:**
```php
add_filter( 'paksa_case_studies_items', function( $items ) {
    $items[] = array(
        'title'     => 'Project Title',
        'industry'  => 'Industry',
        'challenge' => 'The challenge.',
        'solution'  => 'The solution.',
        'url'       => 'https://example.com/case-study',
    );
    return $items;
} );
```

**Future phase:** If 3+ real case studies exist and require independent admin management, a `paksa_case_study` CPT with `page-case-studies.php` template is the appropriate next step.

---

### Skip Link

- Exists at correct location: `paksa_skip_link()` called first in `<body>` in `header.php`
- Target: `#main-content` — the `<main id="main-content">` opened in `header.php`
- **Fixed in Phase 10:** `.skip-link` CSS added to `assets/css/main.css`
  - `position: absolute; top: -100%` — visually hidden until focused
  - `top: var(--pk-space-4)` on `:focus` — becomes visible
  - Sufficient contrast: white text on `--pk-primary` background
  - Does not use `display: none` or `visibility: hidden` — remains keyboard reachable

---

### Main Content Landmark Audit

| Template | `<main id="main-content">` | Notes |
|---|---|---|
| `header.php` | Opens `<main id="main-content">` | All templates inherit this |
| `footer.php` | Closes `</main>` | Correct |
| `front-page.php` | Inside header's `<main>` | Correct — no nested main |
| `single-paksa_product.php` | Own `<main id="main-content">` | Overrides header's open — **conflict** |
| `single-paksa_service.php` | Own `<main id="main-content">` | Overrides header's open — **conflict** |
| `archive-paksa_product.php` | Own `<main id="main-content">` | Overrides header's open — **conflict** |
| `archive-paksa_service.php` | Own `<main id="main-content">` | Overrides header's open — **conflict** |
| `taxonomy-paksa_product_cat.php` | Own `<main id="main-content">` | Overrides header's open — **conflict** |
| `taxonomy-paksa_service_cat.php` | Own `<main id="main-content">` | Overrides header's open — **conflict** |
| `page.php`, `search.php`, `404.php`, `home.php`, `single.php` | Inside header's `<main>` | Correct |

**Known limitation:** CPT single/archive/taxonomy templates open their own `<main>` while `header.php` also opens one. This results in nested `<main>` elements. This is a structural issue from the original architecture where CPT templates were designed as self-contained. Resolving this requires either removing `<main>` from `header.php` (breaking the simpler templates) or removing it from the CPT templates. This is deferred to Phase 11 as a structural refactor — it requires coordinated changes across 6+ templates and `header.php`.

---

### Heading Audit

| Template | H1 | Notes |
|---|---|---|
| `front-page.php` | In `hero.php` — `pk-hero-heading` | Correct |
| `single-paksa_product.php` | In `product/hero.php` — `pk-prod-hero-heading` | Correct |
| `single-paksa_service.php` | In `service/hero.php` — `pk-svc-hero-heading` | Correct |
| `archive-paksa_product.php` | `pk-archive-heading` via `post_type_archive_title()` | Correct |
| `archive-paksa_service.php` | `pk-svc-archive-heading` via `post_type_archive_title()` | Correct |
| `taxonomy-paksa_product_cat.php` | `pk-tax-heading` — term name | Correct |
| `taxonomy-paksa_service_cat.php` | `pk-svc-tax-heading` — term name | Correct |
| `page.php` | `pk-page-title` via `the_title()` | Correct |
| `single.php` | `pk-page-title` via `the_title()` | Correct |
| `home.php` | `pk-page-title` via `single_post_title()` | Correct |
| `search.php` | `pk-page-title` — "Search Results for: {query}" | Correct |
| `404.php` | `pk-page-title` — "Page Not Found" | Correct |

No competing H1 elements found. Section headings use H2. Card titles use H3 (via `heading_tag` arg). Archive grid labels use `screen-reader-text` H2 — correct.

---

### Breadcrumb Consistency

| Template | Breadcrumbs | Notes |
|---|---|---|
| `archive-paksa_product.php` | ✅ | Added Phase 8 |
| `taxonomy-paksa_product_cat.php` | ✅ | Added Phase 8 |
| `archive-paksa_service.php` | ✅ | Present |
| `taxonomy-paksa_service_cat.php` | ✅ | Present |
| `single-paksa_product.php` | ✅ | Via `paksa_breadcrumbs()` in hero |
| `single-paksa_service.php` | ✅ | Via `paksa_breadcrumbs()` in hero |
| `page.php`, `search.php`, `404.php` | ❌ | Not present — these use the simple template structure; breadcrumbs on generic pages are not required |

`paksa_breadcrumbs()` remains the single source of truth. No alternate breadcrumb implementations exist.

---

### Accessibility Improvements (Phase 10)

1. **Skip link CSS** — `.skip-link` was rendered but had no styles. Now properly hidden off-screen and revealed on focus.
2. **Dropdown toggle semantics** — `<button>` separate from `<a>` — no nested interactive elements.
3. **`aria-expanded`** on dropdown toggles — accurate state.
4. **`aria-controls`** linking toggle to submenu panel.
5. **`aria-label`** on dropdown toggle — "Open {Item} submenu".
6. **`role="menubar"`** on primary menu `<ul>`.
7. **`role="menu"`** on submenu `<ul>`.
8. **`role="none"`** on `<li>` elements (removes implicit listitem role in menu context).
9. **`role="menuitem"`** on `<a>` elements.
10. **`aria-current="page"`** on current menu items.
11. **WhatsApp FAB** — `aria-label`, keyboard accessible, visible focus ring.
12. **Footer nav** — native WordPress menu with proper `aria-current` support.

---

### Performance (Phase 10)

- No new external libraries introduced
- Dropdown CSS is pure CSS (`.pk-submenu.is-open` toggle via JS class)
- WhatsApp FAB: inline SVG, no image request, fixed position (no layout shift)
- `main.js` additions: event delegation not needed (finite number of toggles), `passive: true` on scroll listener retained
- No new CSS files added — all new styles appended to `main.css`
- `Paksa_Nav_Walker` runs server-side — no client-side cost

---

### Data Contract Changes (Phase 10)

**Customizer settings added:**
- `paksa_whatsapp_show` — WhatsApp button visibility (`'1'` = show, `'0'` = hide)

**Meta keys added:**
- `_paksa_svc_faq_items` — pipe-delimited FAQ for single service pages
- `_paksa_svc_show_faq` — service FAQ section visibility

**Filters preserved (no changes):**
- `paksa_service_faq_items` — service FAQ programmatic fallback
- `paksa_product_faq_items` — product FAQ programmatic fallback
- `paksa_case_studies_items` — homepage case studies

**Menu locations changed:**
- Removed: `social` (was registered but unused — social links are Customizer-managed)
- Retained: `primary`, `footer`

**No existing meta keys, Customizer settings, hooks, filters, CPTs, taxonomies, or URL structures were changed.**

---

### Files Created (Phase 10)

| File | Purpose |
|---|---|
| `inc/nav-walker.php` | `Paksa_Nav_Walker` + `Paksa_Footer_Nav_Walker` |
| `template-parts/components/whatsapp-fab.php` | WhatsApp floating action button |
| `template-parts/service/faq.php` | Service FAQ section |

### Files Modified (Phase 10)

| File | Change |
|---|---|
| `functions.php` | Removed `social` menu location; added `require_once` for `nav-walker.php` |
| `header.php` | Added `Paksa_Nav_Walker` to desktop nav; fixed mobile nav `depth=1` → `depth=2` |
| `footer.php` | Replaced hardcoded footer company links with native `wp_nav_menu()`; added WhatsApp FAB |
| `inc/customizer.php` | Added `paksa_whatsapp_show` visibility control |
| `inc/service-meta.php` | Added `faq_items` and `show_faq` fields to `paksa_service_meta_fields()` |
| `inc/service-cpt.php` | Registered `_paksa_svc_faq_items` with `register_post_meta()` |
| `single-paksa_service.php` | Added `faq` to section visibility map; added FAQ template part call |
| `assets/css/main.css` | Added skip link CSS, desktop dropdown CSS, mobile submenu CSS, WhatsApp FAB CSS |
| `assets/js/main.js` | Added desktop dropdown JS + mobile submenu toggle JS |
| `SNAPSHOT.md` | Phase 10 documentation appended |

---

### URLs

No existing URL structures were changed. All product, service, taxonomy, and page URLs remain identical.

---

### Runtime

No WordPress/PHP/browser runtime was available during Phase 10 development. All validation was static:
- PHP: manual inspection of function signatures, hook registrations, meta key consistency
- CSS: token usage verified against `variables.css`
- JS: logic reviewed for null guards, event listener correctness, ARIA state accuracy
- Template hierarchy: verified against WordPress template hierarchy documentation

**Runtime testing checklist (perform on real deployment):**

1. Assign a menu with nested items to Primary Navigation
2. Verify desktop dropdown opens/closes on toggle click
3. Verify keyboard: Tab to toggle → Enter opens → Escape closes → Tab out closes
4. Verify mobile: hamburger opens → submenu toggle works → Escape closes mobile nav
5. Set `paksa_whatsapp_url` in Customizer → verify FAB appears
6. Set `paksa_whatsapp_show` to Hide → verify FAB disappears
7. Clear `paksa_whatsapp_url` → verify FAB does not render
8. Create a service, add FAQ items → verify FAQ section renders on single service page
9. Set `_paksa_svc_show_faq` to Hide → verify FAQ section hidden
10. Assign a menu to Footer Navigation → verify footer column 1 renders menu items
11. Tab to skip link → verify it becomes visible and navigates to main content

---

### Known Limitations (Phase 10)

1. **Nested `<main>` elements**: CPT single/archive/taxonomy templates open their own `<main id="main-content">` while `header.php` also opens one. Structural refactor deferred to Phase 11.
2. **Footer columns 2–4** (Solutions, Products, Resources) still use `get_theme_mod()` arrays with `url => '#'` placeholders. Converting these to native WordPress menus requires registering additional menu locations or a different architecture decision.
3. **Runtime testing unavailable** — static validation only.
4. **Case studies** remain filter-driven with no CPT or admin UI.

---

### Next Phase Recommendation

**Phase 11 — Structural Cleanup & Content Population**

Priority items:
1. Resolve nested `<main>` conflict — refactor `header.php` to not open `<main>`, move `<main id="main-content">` into each template (or create a wrapper approach)
2. Convert remaining footer columns (Solutions, Products, Resources) to native WordPress menus or a structured Customizer repeater
3. Content population guide — step-by-step admin instructions for creating products, services, pages, and menus
4. Contact form backend — implement `paksa_contact_form` hook with a native WordPress form or lightweight plugin
5. Performance audit — Lighthouse run on real deployment, address any regressions
6. Cross-browser testing — Chrome, Firefox, Safari, Edge at key breakpoints

---

## 19. PHASE 11 — STRUCTURAL & FUNCTIONAL COMPLETION

### Phase 11 Status: COMPLETE

---

### Nested `<main>` Resolution

**Decision: Option B — individual templates own `<main>`, `header.php` does not.**

Rationale:
- CPT/custom-template files already had `<main>` with meaningful CSS classes (`.pk-single-product`, `.pk-service-archive`, etc.) needed for scoped CSS
- Removing `<main>` from `header.php` is one change vs. removing it from 9 templates
- Each template now has full control over its landmark and CSS class

**Changes made:**
- `header.php` — removed `<main id="main-content">` from end of file
- `footer.php` — removed `</main>` from start of file
- `front-page.php` — added `<main id="main-content" class="pk-front-page">` wrapper
- `page.php` — added `<main id="main-content" class="pk-page">` wrapper
- `single.php` — added `<main id="main-content" class="pk-single-post">` wrapper
- `home.php` — added `<main id="main-content" class="pk-blog-index">` wrapper
- `search.php` — added `<main id="main-content" class="pk-search-results">` wrapper
- `404.php` — added `<main id="main-content" class="pk-error-page">` wrapper
- `archive.php` — added `<main id="main-content" class="pk-archive">` wrapper

**Templates that already had their own `<main>` (unchanged):**
- `page-about.php` — `<main id="main-content" class="pk-about-page">`
- `page-contact.php` — `<main id="main-content" class="pk-contact-page">`
- `page-services.php` — `<main id="main-content" class="pk-services-page">`
- `page-products.php` — `<main id="main-content" class="pk-products-page">`
- `single-paksa_product.php` — `<main id="main-content" class="pk-single-product">`
- `single-paksa_service.php` — `<main id="main-content" class="pk-single-service">`
- `archive-paksa_product.php` — `<main id="main-content" class="pk-product-archive">`
- `archive-paksa_service.php` — `<main id="main-content" class="pk-service-archive">`
- `taxonomy-paksa_product_cat.php` — `<main id="main-content" class="pk-product-taxonomy">`
- `taxonomy-paksa_service_cat.php` — `<main id="main-content" class="pk-service-taxonomy">`

**Skip link:** `paksa_skip_link()` in `header.php` targets `#main-content` — still valid. Every template now has exactly one `<main id="main-content">`.

**Final document structure (all templates):**
```html
<header class="site-header" role="banner">...</header>
<nav id="mobile-nav" class="mobile-nav">...</nav>
<main id="main-content" class="pk-{template}">...</main>
<footer class="site-footer" role="contentinfo">...</footer>
```

---

### Footer Navigation — Complete Conversion

All five footer columns now use native WordPress menus. No `url => '#'` placeholder links remain.

#### Registered Menu Locations (complete list)

| Location Slug | Label | Column |
|---|---|---|
| `primary` | Primary Navigation | Header |
| `footer` | Footer Navigation | Footer — Company |
| `footer-solutions` | Footer Solutions | Footer — Solutions |
| `footer-products` | Footer Products | Footer — Products |
| `footer-resources` | Footer Resources | Footer — Resources |
| `footer-legal` | Footer Legal Links | Footer bottom bar |

#### Empty State Behavior

Each footer column uses `has_nav_menu()` guard. If no menu is assigned:
- The `<nav>` element is not rendered
- The column heading (`<h3>`) remains visible
- No placeholder `#` links are output
- Footer layout remains stable (CSS grid handles empty columns gracefully)

#### How Administrators Assign Footer Menus

1. Go to **Appearance → Menus**
2. Create menus for each footer column (e.g. "Footer Solutions", "Footer Products", etc.)
3. Add the relevant pages/CPT posts/custom links
4. Under "Menu Settings → Display location", assign each menu to its location
5. Save

---

### Contact Form

#### Architecture

| Concern | Implementation |
|---|---|
| Rendering hook | `do_action('paksa_contact_form')` in `template-parts/contact/info.php` |
| Form handler | `inc/contact-form.php` — hooked at priority 10 |
| Submission endpoint | `admin-post.php` action `paksa_contact_submit` |
| Works without JS | Yes — standard HTML form POST |
| Recipient | `paksa_email` Customizer setting → falls back to `get_option('admin_email')` |
| Database storage | None — no submissions stored |

#### Fields

| Field | Type | Required | Max Length |
|---|---|---|---|
| Full Name | text | Yes | 100 |
| Email Address | email | Yes | 254 |
| Subject | text | Yes | 200 |
| Message | textarea | Yes | 5000 |

#### Security

- **Nonce:** `paksa_contact_submit` / `paksa_contact_nonce` — verified before any processing
- **Request method:** POST only
- **Honeypot:** `pk_website` field — hidden from users, filled by bots → redirects to `spam` status
- **Sanitization:** `sanitize_text_field()`, `sanitize_email()`, `sanitize_textarea_field()` per field type
- **Email validation:** `is_email()` on submitted address
- **Length enforcement:** server-side max length checks
- **No PII storage:** no database writes
- **Safe redirect:** `wp_safe_redirect()` — prevents open redirect

#### Submission Flow

```
POST → admin-post.php?action=paksa_contact_submit
  → nonce check
  → method check
  → honeypot check
  → sanitize + validate fields
  → wp_mail() to paksa_email (or admin_email fallback)
  → wp_safe_redirect() back to referring page with ?contact={status}
```

#### Status Query Args

| Value | Meaning | Message shown |
|---|---|---|
| `success` | Email sent | "Thank you — your message has been sent." |
| `error` | Validation failed | "Please check the fields below and try again." |
| `mail-error` | wp_mail() returned false | "Your message could not be delivered." |
| `spam` | Honeypot triggered | "Your submission could not be processed." |

#### Hooks

- `admin_post_paksa_contact_submit` — logged-in users
- `admin_post_nopriv_paksa_contact_submit` — non-logged-in users (public visitors)
- `paksa_contact_form` — rendering hook (priority 10, can be unhooked and replaced)

#### Overriding the Form

To replace the theme form with a plugin form:
```php
remove_action( 'paksa_contact_form', 'paksa_render_contact_form' );
add_action( 'paksa_contact_form', function() {
    echo do_shortcode( '[your-form-shortcode]' );
} );
```

#### CSS

Contact form styles in `assets/css/main.css`:
- `.pk-contact-form` — form container
- `.pk-form-group` — label + input pair
- `.pk-form-label` — field label
- `.pk-form-input` — text/email/textarea inputs
- `.pk-form-textarea` — textarea variant
- `.pk-form-submit` — submit button
- `.pk-form-notice` — status message container
- `.pk-form-notice--success` — green success state
- `.pk-form-notice--error` — red error state
- `.pk-form-honeypot` — hidden honeypot field

---

### Placeholder Link Audit Results

| Location | Pattern | Status | Resolution |
|---|---|---|---|
| Footer Solutions column | `url => '#'` × 5 | Fixed | Native `footer-solutions` menu |
| Footer Products column | `url => '#'` × 2 | Fixed | Native `footer-products` menu |
| Footer Resources column | `url => '#'` × 4 | Fixed | Native `footer-resources` menu |
| Footer Legal bar | `url => '#'` × 3 | Fixed | Native `footer-legal` menu |
| Footer Company column | `url => '#'` × 4 | Fixed in Phase 10 | Native `footer` menu |
| Header CTA | `#contact` | Acceptable | Customizer-controlled, legitimate fragment |
| Hero CTA secondary | `#solutions` | Acceptable | Customizer-controlled, legitimate fragment |
| Final CTA secondary | `#contact` | Acceptable | Customizer-controlled, legitimate fragment |

No remaining invalid placeholder links in the theme.

---

### Phase 11 — Files Created

| File | Purpose |
|---|---|
| `inc/contact-form.php` | Native contact form renderer + submission handler |

### Phase 11 — Files Modified

| File | Change |
|---|---|
| `header.php` | Removed `<main id="main-content">` |
| `footer.php` | Removed `</main>`; replaced Solutions/Products/Resources/Legal columns with native menus |
| `front-page.php` | Added `<main id="main-content" class="pk-front-page">` wrapper |
| `page.php` | Added `<main id="main-content" class="pk-page">` wrapper |
| `single.php` | Added `<main id="main-content" class="pk-single-post">` wrapper |
| `home.php` | Added `<main id="main-content" class="pk-blog-index">` wrapper |
| `search.php` | Added `<main id="main-content" class="pk-search-results">` wrapper |
| `404.php` | Added `<main id="main-content" class="pk-error-page">` wrapper |
| `archive.php` | Added `<main id="main-content" class="pk-archive">` wrapper |
| `functions.php` | Added `footer-solutions`, `footer-products`, `footer-resources`, `footer-legal` menu locations; added `require_once` for `contact-form.php` |
| `assets/css/main.css` | Added contact form CSS + form notice CSS |
| `SNAPSHOT.md` | Phase 11 documentation appended |

### Phase 11 — Data Contract Changes

**Menu locations added:**
- `footer-solutions`
- `footer-products`
- `footer-resources`
- `footer-legal`

**Hooks added:**
- `admin_post_paksa_contact_submit`
- `admin_post_nopriv_paksa_contact_submit`
- `paksa_contact_form` (priority 10, `paksa_render_contact_form`)

**No existing meta keys, Customizer settings, CPTs, taxonomies, or URL structures were changed.**

### Phase 11 — URL Integrity

No URL structures changed. All existing product, service, taxonomy, and page URLs remain identical.

### Phase 11 — Runtime

No WordPress/PHP/browser runtime available. Static validation only.

**Runtime testing checklist:**

1. Load every page type — verify one `<main>` per document in browser DevTools
2. Tab to skip link — verify it becomes visible and focus jumps to `#main-content`
3. Assign menus to all footer locations — verify links render correctly
4. Leave footer menus unassigned — verify no `#` links appear, columns remain stable
5. Submit contact form with valid data — verify email received, success message shown
6. Submit with empty fields — verify error message shown, form re-displayed
7. Submit with invalid email — verify error message shown
8. Fill honeypot field — verify spam redirect
9. Disable JS — verify form still submits and redirects correctly
10. Check `paksa_email` Customizer setting — verify email goes to correct address
11. Clear `paksa_email` — verify fallback to `admin_email`

### Phase 11 — Known Limitations

1. **wp_mail() delivery** depends on server mail configuration. On shared hosting without SMTP, `wp_mail()` may fail silently. Administrators should install an SMTP plugin (e.g. WP Mail SMTP) for reliable delivery — this is a server/infrastructure concern, not a theme concern.
2. **Rate limiting** is not implemented at the theme level. Server-level rate limiting (nginx/Apache) or a security plugin is recommended for production.
3. **Static validation only** — no runtime testing available.

### Next Phase Recommendation

**Phase 12 — Content Population & Launch Preparation**

Priority items:
1. Create all required WordPress pages and assign correct templates
2. Assign all navigation menus (Primary, Footer, Footer Solutions, Footer Products, Footer Resources, Footer Legal)
3. Create initial `paksa_product` and `paksa_service` CPT posts
4. Configure all Customizer settings (Global Site Settings, Homepage sections)
5. Configure SMTP for reliable contact form email delivery
6. Run Lighthouse audit on real deployment
7. Cross-browser testing at all breakpoints
8. Final accessibility audit with screen reader
9. SEO configuration (meta descriptions, Open Graph images, sitemap)
10. Performance optimization (image compression, caching plugin)

---

## 20. PHASE 12 — PRODUCTION CONTENT POPULATION & LAUNCH PREPARATION

### Phase 12 Status: DOCUMENTED — PENDING RUNTIME EXECUTION

Phase 12 requires a live WordPress runtime, database access, a browser, and access to paksa.com.pk.
No WordPress runtime is available in this development environment.
This section documents the complete content map, population guide, and deployment checklist
for execution by the site administrator.

---

### Content Map: paksa.com.pk → WordPress Data Model

#### Pages Required

| Page Title | Slug | Template | Notes |
|---|---|---|---|
| Home | `/` | `front-page.php` | Set as static front page in Settings → Reading |
| Services | `/our-services/` | `page-services.php` (Template: Services / IT Solutions) | Avoid `/services/` — CPT archive slug |
| Products & Solutions | `/our-products/` | `page-products.php` (Template: Products / Solutions) | Avoid `/solutions/` — CPT archive slug |
| About Us | `/about/` | `page-about.php` (Template: About Us) | |
| Contact Us | `/contact/` | `page-contact.php` (Template: Contact Us) | |
| Blog | `/blog/` | `home.php` | Set as Posts page in Settings → Reading |

#### Products (paksa_product CPT) — Verified from Navigation

| Product Title | Slug | Category |
|---|---|---|
| Paksa ERP | `paksa-erp` | Enterprise Software |
| EventLogic | `eventlogic` | Event Management |
| TourLedger | `tourledger` | Travel & Tourism |
| Paksa PoultryPro | `paksa-poultrpro` | Agriculture |
| Salon Management | `salon-management` | Services & Retail |

Content for each product (features, modules, benefits, FAQ) must be sourced from the
actual product pages on paksa.com.pk. Do not invent content.

#### Services (paksa_service CPT) — Verified from Navigation

| Service Title | Slug | Category |
|---|---|---|
| AI & ML Solutions | `ai-ml-solutions` | AI & Machine Learning |
| AI Automation Services | `ai-automation-services` | AI & Machine Learning |
| Data Science & Analytics | `data-science-analytics` | Data & Analytics |
| Software Development | `software-development` | Software Development |

#### Product Categories (paksa_product_cat)

| Term Name | Slug |
|---|---|
| Enterprise Software | `enterprise-software` |
| Event Management | `event-management` |
| Travel & Tourism | `travel-tourism` |
| Agriculture | `agriculture` |
| Services & Retail | `services-retail` |

#### Service Categories (paksa_service_cat)

| Term Name | Slug |
|---|---|
| AI & Machine Learning | `ai-machine-learning` |
| Data & Analytics | `data-analytics` |
| Software Development | `software-development` |

#### Product ↔ Service Relationships

Candidate relationships — must be verified from paksa.com.pk before entry:

| Product | Candidate Related Service |
|---|---|
| Paksa ERP | Software Development, AI & ML Solutions |
| EventLogic | Software Development |
| TourLedger | Software Development |
| Paksa PoultryPro | Software Development, Data Science & Analytics |
| Salon Management | Software Development |

Do not enter relationships that are not explicitly supported by the existing website content.

#### Case Studies

Status: Deferred. No verified case study content available.
`paksa_case_studies_items` filter returns empty array by default.
Homepage Case Studies section: set to Hide in Customizer → Homepage → Section Visibility.

---

### Admin Population Order

Execute in this order to avoid dependency failures:

1. Global Settings (Customizer — contact info, social links)
2. Site Logo and Favicon (Customizer — Site Identity)
3. Product Categories (Products → Categories)
4. Service Categories (Services → Categories)
5. Products (Products → Add New — 5 posts)
6. Services (Services → Add New — 4 posts)
7. Service → Product relationships (edit each service, select related products)
8. Product → Service relationships (edit each product, select related services)
9. WordPress Pages (Pages → Add New — 6 pages)
10. Settings → Reading (set front page and posts page)
11. Homepage Customizer sections (Appearance → Customize → Homepage)
12. Navigation Menus (Appearance → Menus — 6 locations)
13. Header CTA URLs (update `#contact` → `/contact/`, `#solutions` → `/our-products/`)
14. Contact form email verification (submit test, verify delivery)
15. SEO plugin configuration
16. Debug settings verification (WP_DEBUG = false)

---

### Navigation Menu Configuration

#### Primary Navigation (location: `primary`)

```
Home                          → /
Our Services                  → /our-services/
  ├── AI & ML Solutions       → /services/ai-ml-solutions/
  ├── AI Automation Services  → /services/ai-automation-services/
  ├── Data Science & Analytics→ /services/data-science-analytics/
  └── Software Development    → /services/software-development/
Solutions                     → /our-products/
  ├── Paksa ERP               → /solutions/paksa-erp/
  ├── EventLogic              → /solutions/eventlogic/
  ├── TourLedger              → /solutions/tourledger/
  ├── Paksa PoultryPro        → /solutions/paksa-poultrpro/
  └── Salon Management        → /solutions/salon-management/
About                         → /about/
  ├── About Us                → /about/
  └── Blog                    → /blog/
Contact Us                    → /contact/
```

#### Footer Navigation (location: `footer`) — Company column

```
About Us    → /about/
Blog        → /blog/
Contact Us  → /contact/
```

#### Footer Solutions (location: `footer-solutions`)

```
Paksa ERP         → /solutions/paksa-erp/
EventLogic        → /solutions/eventlogic/
TourLedger        → /solutions/tourledger/
Paksa PoultryPro  → /solutions/paksa-poultrpro/
Salon Management  → /solutions/salon-management/
```

#### Footer Products (location: `footer-products`) — Services column

```
AI & ML Solutions         → /services/ai-ml-solutions/
AI Automation Services    → /services/ai-automation-services/
Data Science & Analytics  → /services/data-science-analytics/
Software Development      → /services/software-development/
```

#### Footer Resources (location: `footer-resources`)

Add only verified URLs. Do not add placeholder links.

#### Footer Legal Links (location: `footer-legal`)

Add only when real legal pages exist with verified content:
- Privacy Policy
- Terms & Conditions
- Refund Policy

---

### Customizer Settings to Update After Pages Are Created

| Setting | Current Default | Production Value |
|---|---|---|
| `paksa_hero_cta_primary_url` | `#contact` | `/contact/` |
| `paksa_hero_cta_secondary_url` | `#solutions` | `/our-products/` |
| `paksa_cta_primary_url` | `#contact` | `/contact/` |
| `paksa_cta_secondary_url` | `#contact` | `/contact/` |
| `paksa_email` | `info@paksa.com.pk` | Verify correct recipient |
| `paksa_whatsapp_url` | `https://api.whatsapp.com/send/?phone=923144676210` | Verify number is correct |

---

### Contact Form Production Configuration

| Concern | Status |
|---|---|
| Rendering hook | `paksa_contact_form` → `paksa_render_contact_form` at priority 10 ✅ |
| Submission endpoint | `admin-post.php` action `paksa_contact_submit` ✅ |
| Nonce | `paksa_contact_submit` / `paksa_contact_nonce` ✅ |
| Honeypot | `pk_website` field ✅ |
| Sanitization | Per-field sanitization ✅ |
| Validation | Required fields, `is_email()`, length limits ✅ |
| Recipient | `paksa_email` Customizer → `admin_email` fallback ✅ |
| No DB storage | Confirmed ✅ |
| SMTP delivery | Depends on server configuration — install WP Mail SMTP if `wp_mail()` fails |
| Rate limiting | Not implemented at theme level — use server-level or security plugin |

---

### SMTP Configuration Note

Do not hardcode SMTP credentials in theme files.
Do not commit SMTP credentials to Git.
Configure SMTP through WP Mail SMTP plugin admin UI only.
Document SMTP configuration separately from the repository.

---

### SEO Configuration

The theme has `paksa_seo_plugin_active()` guards that prevent duplicate output when
Rank Math, Yoast SEO, or AIOSEO is active.

Install one SEO plugin (Rank Math recommended for WordPress 6.1+).
Configure through the plugin's setup wizard.
Verify:
- Sitemap generated at `/sitemap_index.xml` or `/sitemap.xml`
- Open Graph images set for homepage and key pages
- Meta descriptions set for all pages, products, and services
- Canonical URLs correct
- No duplicate title tags (theme outputs title-tag support; SEO plugin overrides)

---

### Redirect Inventory

The existing paksa.com.pk URL structure must be crawled before launch.
Compare every live URL against the new WordPress URL structure.
Implement 301 redirects for any changed URLs via server config or redirect plugin.

Common scenarios to verify:
- Existing product page URLs vs. `/solutions/{slug}/`
- Existing service page URLs vs. `/services/{slug}/`
- Existing contact/about page slugs vs. `/contact/` and `/about/`

Do not implement redirects for URLs that have not changed.

---

### Git Hygiene Checklist

Before any commit:
- [ ] No SMTP credentials in any file
- [ ] No database dumps committed
- [ ] No `wp-config.php` committed
- [ ] No `wp-content/uploads/` committed
- [ ] No `.env` files committed
- [ ] No debug logs committed
- [ ] No temporary files committed
- [ ] `.gitignore` covers all of the above

---

### Production Validation Checklist

All items must be verified in the live WordPress environment.

#### Content
- [ ] 5 products published with real content
- [ ] 4 services published with real content
- [ ] All product categories assigned
- [ ] All service categories assigned
- [ ] No placeholder `#` links in any rendered navigation
- [ ] No fabricated content visible on any page
- [ ] Contact information matches paksa.com.pk
- [ ] Social URLs verified and functional

#### Navigation
- [ ] Primary menu renders on desktop
- [ ] Dropdown opens/closes on toggle click
- [ ] Dropdown closes on Escape key
- [ ] Dropdown closes on Tab-out
- [ ] Mobile hamburger opens nav
- [ ] Mobile submenu toggles work
- [ ] All menu links resolve (no 404)
- [ ] All 6 footer menu locations assigned or gracefully empty

#### Templates
- [ ] Homepage: all enabled sections render
- [ ] Homepage products section: shows CPT posts
- [ ] Services page: shows CPT service cards
- [ ] Products page: shows CPT product cards with category filter
- [ ] Single product: all populated sections render
- [ ] Single service: all populated sections render
- [ ] About page: real content renders
- [ ] Contact page: form renders
- [ ] 404 page: renders with navigation
- [ ] Search results: render correctly

#### Contact Form
- [ ] Valid submission sends email to configured recipient
- [ ] Success message shown after valid submission
- [ ] Empty field submission shows error
- [ ] Invalid email shows error
- [ ] Honeypot not visible to users
- [ ] Form works without JavaScript
- [ ] SMTP delivery confirmed (not just wp_mail() returning true)

#### WhatsApp FAB
- [ ] Visible on all pages
- [ ] Links to correct WhatsApp URL
- [ ] Hidden when `paksa_whatsapp_show` = Hide
- [ ] Keyboard accessible
- [ ] No horizontal overflow on mobile

#### Accessibility
- [ ] One `<main id="main-content">` per page
- [ ] One H1 per page
- [ ] All images have meaningful alt text
- [ ] All form fields have associated labels
- [ ] Focus indicators visible on all interactive elements
- [ ] Skip link works on all page types

#### Performance (Lighthouse — Chrome DevTools)
Target: 95+ Performance, Accessibility, Best Practices, SEO
- [ ] Homepage
- [ ] Services page
- [ ] Products page
- [ ] Single product
- [ ] Single service
- [ ] About page
- [ ] Contact page

#### Browser Testing
- [ ] Chrome (latest)
- [ ] Edge (latest)
- [ ] Firefox (latest)
- [ ] Safari (if available)

#### Responsive Testing
- [ ] 320px — no horizontal overflow
- [ ] 375px — no horizontal overflow
- [ ] 768px — tablet layout correct
- [ ] 1024px — desktop nav visible
- [ ] 1280px — full layout correct

#### Security
- [ ] HTTPS active, HTTP → HTTPS redirect
- [ ] `WP_DEBUG` = false
- [ ] No PHP errors visible to visitors
- [ ] Admin accessible only over HTTPS
- [ ] File editing disabled in dashboard

#### URL Integrity
- [ ] `/solutions/` — product archive loads
- [ ] `/solutions/{slug}/` — individual product loads
- [ ] `/solutions/category/{slug}/` — product category archive loads
- [ ] `/services/` — service archive loads
- [ ] `/services/{slug}/` — individual service loads
- [ ] `/services/category/{slug}/` — service category archive loads
- [ ] `/contact/` — Contact page loads
- [ ] `/about/` — About page loads
- [ ] Invalid URL → 404 with navigation

---

### Phase 12 — Known Limitations

1. **No runtime available** — Phase 12 content population, Lighthouse testing, browser testing,
   form testing, and email delivery testing cannot be performed in this static environment.
   All validation must be performed by the site administrator on the live deployment.

2. **Content sourcing** — Product and service content (features, modules, benefits, FAQ)
   must be sourced from paksa.com.pk by the administrator. This document provides the
   data model and field mapping but cannot pre-populate the content.

3. **SMTP delivery** — `wp_mail()` reliability depends on server mail configuration.
   Shared hosting without SMTP configuration may fail silently.
   WP Mail SMTP plugin is recommended for production.

4. **Rate limiting** — Contact form rate limiting is not implemented at the theme level.
   Server-level rate limiting or a security plugin is required for production.

5. **Case studies** — Deferred. No verified case study content available.
   Section hidden by default via Customizer.

6. **Dark mode** — Intentionally disabled. Partial token set commented out in `variables.css`.
   Full dark mode is a future phase.

7. **Legal pages** — Privacy Policy, Terms & Conditions, Refund Policy pages are not created.
   Footer Legal menu should remain unassigned until real legal content exists.

8. **Redirect inventory** — Cannot be produced without crawling the live paksa.com.pk site.
   Must be completed before DNS cutover.

9. **Open Source Projects page** — Referenced in navigation structure but URL unknown.
   Do not add to menu until verified URL is available.

10. **GitHub URL** — `https://github.com/paksaitsolutions` listed in SNAPSHOT.md section 14.
    Verify this URL is publicly accessible before saving to Customizer.

---

### Phase 12 — Launch Readiness Assessment

**Status: Ready pending runtime execution**

The theme codebase is structurally complete and production-ready.
Launch is blocked only by:

1. WordPress runtime installation
2. Content population from paksa.com.pk (products, services, pages, menus)
3. Customizer configuration (global settings, homepage sections, CTA URLs)
4. SMTP configuration for contact form delivery
5. SEO plugin installation and configuration
6. Redirect inventory (requires crawling live site)
7. Lighthouse audit on real deployment
8. Cross-browser and responsive testing
9. Accessibility audit with screen reader

No theme code changes are required before launch unless runtime testing reveals defects.

---

### Next Phase Recommendation

**Phase 13 — Post-Launch Monitoring & Iteration**

After Phase 12 runtime execution is complete and the site is live:

1. Monitor Google Search Console for crawl errors and indexing issues
2. Monitor Core Web Vitals in Search Console (real user data, 28-day window)
3. Address any Lighthouse findings from the Phase 12 audit
4. Address any accessibility findings from the Phase 12 audit
5. Implement case studies section when 3+ verified case studies exist
6. Implement dark mode (full token set in `variables.css`)
7. Consider blog content strategy if editorial content is planned
8. Review contact form spam rate — implement reCAPTCHA if honeypot is insufficient
9. Review redirect performance after DNS cutover

Do NOT begin Phase 13 until Phase 12 runtime execution is confirmed complete.
