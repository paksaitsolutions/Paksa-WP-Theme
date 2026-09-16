# Phase 1 — Discovery Report

**Project:** Paksa IT Solutions WordPress Theme  
**Date:** September 16, 2026  
**Status:** Phase 1 Complete — Awaiting Approval for Phase 2

---

## 1. Current Project Analysis

### 1.1 Project State

| Item | Finding |
|---|---|
| **WordPress version** | Not installed locally. Target: WordPress 6.0+ (block theme compatible) |
| **PHP version** | Not available in current environment. Target: PHP 7.4+ (recommended 8.1+) |
| **Git status** | Initialized, 1 commit (`2f1c928` — "Initial commit"), branch `main` |
| **Existing theme** | NONE — empty repository, no existing theme |
| **Existing plugins** | NONE — no WordPress installation present |
| **Existing CPTs** | NONE |
| **Existing taxonomies** | NONE |
| **Existing Elementor** | NONE |
| **Existing Gutenberg** | NONE |
| **Existing CSS/JS** | NONE |
| **Existing assets** | NONE |
| **Existing branding** | NONE (logo, colors, fonts to be designed) |
| **Existing content** | NONE (content structure documented in requirements.md from paksa.com.pk analysis) |
| **Database** | NONE — no WordPress database |
| **Integrations** | NONE |
| **Docker** | NONE |
| **WP-CLI** | NOT available locally |

### 1.2 Existing Files

| File | Purpose | Status |
|---|---|---|
| `.git/` | Git repository | Active, 1 commit |
| `.gitignore` | Git ignore rules | **MISMATCH** — FuelPHP template, not WordPress. Needs replacement. |
| `LICENSE` | GPL v3 | Correct for WordPress themes ✓ |
| `README.md` | Project description | Minimal ("Paksa WP Theme") |
| `requirements.md` | Requirements from paksa.com.pk deep dive | Created by us, accurate |
| `.kilo/skills/` | WP agent-skills (8 skills) | Installed |
| `.kilocode/skills/` | UI/UX skills (7 skills) | Installed |

### 1.3 Key Finding

**This is a brand-new, empty WordPress theme development repository.** There is no existing WordPress installation, no existing theme, no existing plugins, no existing content, and no existing database to preserve. All functionality will be built from scratch.

The `.gitignore` file is from a FuelPHP project template and is not relevant to WordPress. It will need to be replaced with a proper WordPress theme `.gitignore`.

---

## 2. Recommended Theme Architecture

### 2.1 Theme Type

**Block Theme** (modern WordPress standard, fully compatible with Gutenberg)

Rationale:
- WordPress 6.0+ is the target
- Block themes are the future of WordPress
- Supports both Gutenberg blocks and classic templates
- `theme.json` provides centralized design token management
- Template Parts enable reusable header/footer across all pages
- No need for page builders (matches requirement: "Do not build on Elementor")

### 2.2 Theme Folder Name

```
paksa-it-solutions/
```

### 2.3 Architecture Overview

```
paksa-it-solutions/
│
├── style.css                          # Theme header, version, tags
├── functions.php                      # Theme setup, enqueues, features
├── index.php                          # Fallback template
├── front-page.php                     # Homepage (static front page)
│
├── header.php                         # Site header (template part alternative)
├── footer.php                         # Site footer (template part alternative)
│
├── screenshot.png                     # Theme preview image
│
├── theme.json                         # Design tokens, settings, styles (BLOCK THEME)
│
├── assets/
│   ├── css/
│   │   ├── main.css                   # Compiled/main stylesheet
│   │   ├── variables.css              # CSS custom properties (design tokens)
│   │   └── animations.css             # Animation keyframes and rules
│   ├── js/
│   │   ├── main.js                    # Main script (navigation, interactions)
│   │   ├── animations.js              # Scroll animations (IntersectionObserver)
│   │   └── mobile-nav.js              # Mobile navigation logic
│   ├── images/                        # Brand images, logos, hero images
│   ├── icons/                         # SVG icons (inline sprite or individual)
│   └── fonts/                         # Custom fonts (if not using Google Fonts CDN)
│
├── inc/
│   ├── setup.php                      # Theme setup, post type support, image sizes
│   ├── enqueue.php                    # Asset enqueueing (CSS, JS, fonts)
│   ├── security.php                   # Security headers, hardening, nonce checks
│   ├── performance.php                # Lazy loading, preload, optimization hooks
│   ├── accessibility.php              # Skip links, ARIA, focus management
│   ├── customizer.php                 # WordPress Customizer options (if needed)
│   ├── template-functions.php         # Helper functions for templates
│   ├── template-tags.php              # Custom template tags
│   ├── schema.php                     # Structured data markup (JSON-LD)
│   └── admin/
│       ├── admin-menu.php             # Admin menu/page (if custom admin needed)
│       └── admin-helpers.php          # Admin helper functions
│
├── template-parts/
│   ├── header/
│   │   ├── site-header.php            # Main header markup
│   │   ├── mobile-nav.php             # Mobile navigation markup
│   │   └── site-logo.php              # Logo markup
│   ├── footer/
│   │   ├── site-footer.php            # Main footer markup
│   │   ├── footer-widgets.php         # Footer widget columns
│   │   └── footer-bottom.php          # Copyright, legal links
│   ├── hero/
│   │   ├── hero-standard.php          # Standard hero section
│   │   ├── hero-split.php             # Split layout hero
│   │   └── hero-product.php           # Product-focused hero
│   ├── sections/
│   │   ├── section-header.php         # Section title + eyebrow
│   │   ├── section-features.php       # Feature grid section
│   │   ├── section-stats.php          # Statistics section
│   │   ├── section-testimonials.php   # Testimonials section
│   │   ├── section-cta.php            # Call-to-action section
│   │   └── section-faq.php            # FAQ section
│   ├── cards/
│   │   ├── card-service.php           # Service card
│   │   ├── card-product.php           # Product card
│   │   ├── card-blog.php              # Blog card
│   │   ├── card-testimonial.php       # Testimonial card
│   │   └── card-feature.php           # Feature/ Capability card
│   ├── components/
│   │   ├── button.php                 # Button markup
│   │   ├── badge.php                  # Badge markup
│   │   ├── tabs.php                   # Tabs markup
│   │   ├── accordion.php              # Accordion markup
│   │   ├── breadcrumbs.php            # Breadcrumb trail
│   │   ├── alert.php                  # Alert/notice box
│   │   └── pagination.php             # Pagination markup
│   ├── forms/
│   │   ├── contact-form.php           # Contact form
│   │   └── form-field.php             # Individual form field
│   └── content/
│       ├── entry-meta.php             # Post meta (date, author, categories)
│       ├── entry-header.php           # Post title, featured image
│       └── entry-content.php          # Post content wrapper
│
├── templates/
│   ├── page-services.php              # Services archive/template
│   ├── page-solutions.php             # Solutions/products template
│   ├── page-products.php              # Product archive template
│   ├── page-industries.php            # Industries template
│   ├── page-case-studies.php          # Case studies template
│   ├── page-contact.php               # Contact page template
│   ├── single-service.php             # Single service post type
│   ├── single-product.php             # Single product post type
│   ├── single-case-study.php          # Single case study post type
│   └── archive.php                    # Archive template (fallback)
│
├── languages/                         # Translation files (.pot, .po, .mo)
│   └── paksa-it-solutions.pot
│
└── templates/                         # WordPress template files
```

### 2.4 Architecture Decisions

| Decision | Rationale |
|---|---|
| **Block Theme** | Modern standard, theme.json for design tokens, full Gutenberg compatibility |
| **Template Parts over header.php/footer.php** | Better block theme pattern, manageable via Site Editor |
| **theme.json for design tokens** | Centralized control of colors, typography, spacing, responsive |
| **CSS Custom Properties alongside theme.json** | Direct CSS access for animations, complex selectors, third-party compat |
| **Separate JS files** | Modular, maintainable, cache-friendly |
| **Template Parts for sections** | Reusable, manageable, editable in Site Editor |
| **No page builder** | Matches requirements, cleaner code, better performance |

---

## 3. Design System

### 3.1 Color System

Based on paksa.com.pk analysis and brand positioning (premium enterprise IT):

```css
:root {
    /* === BRAND COLORS === */
    --pk-primary: #1a365d;          /* Deep Navy — Trust, Enterprise */
    --pk-primary-light: #2a4a7f;    /* Lighter Navy for hovers */
    --pk-secondary: #2b6cb0;        /* Royal Blue — Action, Links */
    --pk-accent: #00b5d8;           /* Cyan — Innovation, Technology */
    --pk-accent-light: #4dd8e6;     /* Light Cyan for subtle accents */
    
    /* === BACKGROUND === */
    --pk-bg: #ffffff;               /* Primary background */
    --pk-bg-alt: #f7fafc;           /* Section alternating background */
    --pk-bg-dark: #1a202c;          /* Dark sections, footer */
    
    /* === SURFACE === */
    --pk-surface: #ffffff;          /* Card background */
    --pk-surface-elevated: #ffffff; /* Elevated cards (with shadow) */
    --pk-surface-dark: #2d3748;     /* Dark surface for footer/dark sections */
    
    /* === TEXT === */
    --pk-text: #1a202c;             /* Primary text — near-black */
    --pk-text-secondary: #4a5568;   /* Secondary text — gray */
    --pk-text-muted: #718096;       /* Muted text — lighter gray */
    --pk-text-inverse: #ffffff;     /* Text on dark backgrounds */
    --pk-text-inverse-muted: #a0aec0; /* Muted text on dark */
    
    /* === BORDER === */
    --pk-border: #e2e8f0;           /* Standard border */
    --pk-border-light: #edf2f7;     /* Light border */
    --pk-border-dark: #4a5568;      /* Border on dark bg */
    
    /* === SEMANTIC === */
    --pk-success: #38a169;          /* Success, positive */
    --pk-warning: #d69e2e;          /* Warning, caution */
    --pk-error: #e53e3e;            /* Error, critical */
    --pk-info: #3182ce;             /* Information, neutral info */
    
    /* === RADIUS === */
    --pk-radius-sm: 4px;
    --pk-radius-md: 8px;
    --pk-radius-lg: 16px;
    --pk-radius-xl: 24px;
    --pk-radius-full: 9999px;
    
    /* === SHADOWS === */
    --pk-shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
    --pk-shadow-md: 0 4px 12px rgba(0,0,0,0.1);
    --pk-shadow-lg: 0 8px 24px rgba(0,0,0,0.12);
    --pk-shadow-xl: 0 16px 48px rgba(0,0,0,0.16);
    
    /* === SPACING (8px grid) === */
    --pk-space-1: 0.25rem;   /* 4px */
    --pk-space-2: 0.5rem;    /* 8px */
    --pk-space-3: 0.75rem;   /* 12px */
    --pk-space-4: 1rem;      /* 16px */
    --pk-space-5: 1.25rem;   /* 20px */
    --pk-space-6: 1.5rem;    /* 24px */
    --pk-space-8: 2rem;      /* 32px */
    --pk-space-10: 2.5rem;   /* 40px */
    --pk-space-12: 3rem;     /* 48px */
    --pk-space-16: 4rem;     /* 64px */
    --pk-space-20: 5rem;     /* 80px */
    --pk-space-24: 6rem;     /* 96px */
    
    /* === TYPOGRAPHY (responsive with clamp) === */
    --pk-font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    --pk-font-display: 'Inter', var(--pk-font-sans);
    
    /* Container */
    --pk-container: 1280px;
    --pk-container-narrow: 800px;
    --pk-container-wide: 1440px;
    
    /* Breakpoints (reference only, actual media queries in CSS) */
    --pk-breakpoint-sm: 640px;
    --pk-breakpoint-md: 768px;
    --pk-breakpoint-lg: 1024px;
    --pk-breakpoint-xl: 1280px;
    --pk-breakpoint-2xl: 1920px;
}
```

### 3.2 Typography System

| Element | Size (Desktop) | Weight | Line Height | Font |
|---|---|---|---|---|
| Display | clamp(2.5rem, 5vw, 4rem) | 700 | 1.1 | Inter |
| H1 | clamp(2rem, 4vw, 3rem) | 700 | 1.15 | Inter |
| H2 | clamp(1.5rem, 3vw, 2.25rem) | 700 | 1.2 | Inter |
| H3 | clamp(1.25rem, 2vw, 1.5rem) | 600 | 1.3 | Inter |
| H4 | 1.125rem | 600 | 1.4 | Inter |
| Body Large | 1.125rem | 400 | 1.7 | Inter |
| Body | 1rem | 400 | 1.7 | Inter |
| Body Small | 0.875rem | 400 | 1.6 | Inter |
| Eyebrow/Label | 0.75rem | 600 | 1.4 | Inter, uppercase, letter-spacing |
| Button | 0.9375rem | 600 | 1.4 | Inter |
| Caption | 0.75rem | 400 | 1.5 | Inter |

### 3.3 Responsive Breakpoints (Centralized)

| Name | Width | Target |
|---|---|---|
| Mobile | < 640px | Phones |
| Tablet | 640px – 1023px | Tablets |
| Desktop | 1024px – 1279px | Laptops |
| Large Desktop | 1280px+ | Desktops, monitors |

---

## 4. Component Architecture

### 4.1 Component Inventory

All components are PHP template parts in `template-parts/`. Each is a self-contained, reusable partial.

| Category | Components |
|---|---|
| **Navigation** | site-header, mobile-nav, site-logo, dropdown, mega-menu |
| **Hero** | hero-standard, hero-split, hero-product, hero-service, hero-minimal, hero-image |
| **Section** | section-header, section-features, section-stats, section-testimonials, section-cta, section-faq, section-tech-stack, section-process, section-compare, section-integrations, section-security, section-outcomes |
| **Card** | card-service, card-product, card-blog, card-testimonial, card-feature, card-industry, card-case-study, card-technology, card-integration |
| **UI** | button, badge, icon, tabs, accordion, modal, breadcrumbs, pagination, alert |
| **Form** | contact-form, form-field, search-form |
| **Content** | entry-meta, entry-header, entry-content |

### 4.2 Component Pattern

Each component follows a consistent pattern:

```php
<!-- template-parts/components/button.php -->
<?php
$attrs = [
    'class' => ['pk-btn', $attrs['class'] ?? ''],
    'href' => $attrs['href'] ?? '#',
    'target' => $attrs['target'] ?? '_self',
];
?>
<a <?php echo get_attributes($attrs); ?>>
    <?php echo esc_html($attrs['text'] ?? 'Button'); ?>
</a>
```

Each component:
1. Accepts attributes via `$attrs` array
2. Escapes all output
3. Uses design tokens via CSS classes
4. Is self-contained (no external dependencies)
5. Has a corresponding CSS module

---

## 5. Template Architecture

### 5.1 Template Hierarchy

| Template | Used For |
|---|---|
| `front-page.php` | Homepage (static front page) |
| `home.php` | Blog posts index (if blog page) |
| `page.php` | Default page template |
| `single.php` | Default single post |
| `archive.php` | Default archive |
| `search.php` | Search results |
| `404.php` | 404 error page |
| `page-services.php` | Services page (custom template) |
| `page-solutions.php` | Solutions page (custom template) |
| `page-products.php` | Products page (custom template) |
| `page-industries.php` | Industries page (custom template) |
| `page-case-studies.php` | Case studies page (custom template) |
| `page-contact.php` | Contact page (custom template) |
| `single-service.php` | Single service CPT |
| `single-product.php` | Single product CPT |
| `single-case-study.php` | Single case study CPT |

### 5.2 Master IT Solutions Template Architecture

The master template (`templates/page-services.php`) supports all service pages through a section-based architecture:

```php
// In page-services.php
$sections = get_field('sections') ?: []; // or post meta

get_template_part('template-parts/hero/hero-standard');

if (in_array('trust_strip', $sections)) get_template_part('template-parts/sections/section-trust');
if (in_array('challenge', $sections)) get_template_part('template-parts/sections/section-challenge');
if (in_array('solution', $sections)) get_template_part('template-parts/sections/section-solution');
if (in_array('features', $sections)) get_template_part('template-parts/sections/section-features');
// ... etc for each section
```

Each section is optional — a page doesn't break if a section is disabled.

---

## 6. WordPress Data Architecture

### 6.1 Custom Post Types (Phase 6 — to be implemented after inspection)

| CPT | Slug | Key Fields |
|---|---|---|
| Service | `service` | Title, description, icon, features, linked_product, gallery |
| Product | `product` | Title, description, features(repeater), gallery, sub_pages, faq, tech_stack |
| Case Study | `case_study` | Title, challenge, solution, results, gallery, client_info, industry |
| Technology | `technology` | Title, description, category, logo |
| Testimonial | `testimonial` | Name, role, company, quote, rating, avatar |
| Partner | `partner` | Name, logo, website |

### 6.2 Custom Taxonomies

| Taxonomy | For | Terms |
|---|---|---|
| Service Category | Service | AI & ML, AI Automation, Data Science, Software Dev, etc. |
| Product Category | Product | ERP, Event Management, Travel, Agriculture, Salon |
| Industry | Case Study, Service | Healthcare, Finance, E-commerce, etc. |
| Blog Category | Post (default) | AI, ERP, Poultry, Salon, Data, etc. |

### 6.3 Content Entity Strategy

Per requirements: "Content separated from presentation, not hard-coded."

- Services → Custom Post Type (reusable)
- Products → Custom Post Type (reusable)
- Industries → Taxonomy on Service + Product
- Case Studies → Custom Post Type (reusable)
- Technologies → Custom Post Type or Taxonomy
- FAQs → Repeatable fields via ACF (or custom block)
- Testimonials → Custom Post Type (reusable)

### 6.4 WordPress-Native Content Management (Recommended)

| Setting | Method |
|---|---|
| Logo | `custom_logo` (WordPress native) |
| Colors | `theme.json` + Customizer options (if needed) |
| Typography | `theme.json` (block theme native) |
| Header CTA | Customizer setting or block |
| Footer content | WP Nav Menus + Widgets + Theme Mods |
| Social links | Theme Mods or Nav Menus |
| Contact details | Theme Mods + ACF options page |
| Global settings | `theme.json` + Customizer |

---

## 7. Performance Strategy

### 7.1 CSS Strategy

| Strategy | Implementation |
|---|---|
| **Critical CSS** | Inline above-fold CSS in `<head>` |
| **Deferred CSS** | Non-critical CSS loaded with `media="print"` + swap |
| **CSS Modules** | Components use specific classes, no cascade bloat |
| **No CSS frameworks** | Custom CSS only, no Tailwind/Bootstrap overhead |
| **Minification** | Build step or WP optimization plugin |
| **CSS Custom Properties** | Single source of truth, minimal duplication |

### 7.2 JavaScript Strategy

| Strategy | Implementation |
|---|---|
| **Vanilla JS only** | No jQuery, no React, no Vue |
| **Modular files** | Separate files for nav, animations, interactions |
| **Deferred loading** | Scripts with `defer` attribute |
| **IntersectionObserver** | For scroll animations (no GSAP) |
| **Reduced motion** | Respect `prefers-reduced-motion` |
| **No unused polyfills** | Target modern browsers |

### 7.3 Image Strategy

| Strategy | Implementation |
|---|---|
| **Lazy loading** | `loading="lazy"` on all below-fold images |
| **Responsive images** | `srcset` and `sizes` attributes |
| **WebP/AVIF** | Format negotiation via `.htaccess` or plugin |
| **Image dimensions** | Width/height attributes to prevent CLS |
| **WordPress image sizes** | Custom sizes registered in `functions.php` |
| **SVG for icons** | Inline SVG sprite, no external icon libraries |

### 7.4 Target Performance

| Metric | Target |
|---|---|
| Lighthouse Performance | 95+ |
| Lighthouse Accessibility | 95+ |
| Lighthouse Best Practices | 95+ |
| Lighthouse SEO | 95+ |
| First Contentful Paint | < 1.2s |
| Largest Contentful Paint | < 2.5s |
| Cumulative Layout Shift | < 0.1 |
| Total Blocking Time | < 200ms |

---

## 8. SEO Strategy

| Feature | Implementation |
|---|---|
| **Semantic HTML** | `<main>`, `<article>`, `<section>`, `<nav>`, `<header>`, `<footer>` |
| **Heading hierarchy** | Single H1 per page, proper nesting |
| **Breadcrumbs** | Structured data + visible nav (Schema.org) |
| **Open Graph** | `og:title`, `og:description`, `og:image` via `wp_head()` + filters |
| **Schema.org** | Organization, Service, Product, FAQPage, LocalBusiness markup |
| **Canonical** | Rel canonical via `rel_canonical()` |
| **Title tags** | Via `document_title_filter` or plugin compat |
| **Image alt text** | Required on all images, from attachment metadata |
| **Structured data** | JSON-LD in `<head>` via `schema.php` |
| **Sitemap** | Via `wp_sitemap_query_posts` filter or plugin |
| **Robots.txt** | Via `robots_txt` filter |
| **Mobile viewport** | `<meta name="viewport">` in header.php |

**SEO Plugin Compatibility:**
- Rank Math: Coexist via `document_title_parts` filter
- Yoast: Coexist via `wpseo_*` filters
- Theme outputs SEO-friendly markup; plugin controls meta tags

---

## 9. Accessibility Strategy

| Feature | Implementation |
|---|---|
| **Skip link** | Visible skip-to-content link at page top |
| **Keyboard navigation** | All interactive elements focusable via Tab |
| **Focus indicators** | Visible `:focus-visible` styles, never `outline: none` |
| **ARIA** | Only where HTML5 semantics insufficient |
| **Semantic landmarks** | `<header>`, `<nav>`, `<main>`, `<section>`, `<footer>` |
| **Form labels** | Explicit `<label>` for every input |
| **Error handling** | Clear error messages, `aria-invalid`, `aria-describedby` |
| **Reduced motion** | `@media (prefers-reduced-motion: reduce)` |
| **Color contrast** | WCAG AA minimum (4.5:1 for text, 3:1 for UI) |
| **Screen reader** | Descriptive alt text, `aria-label` for icon buttons |
| **Heading hierarchy** | Proper order, no skipping levels |
| **Language** | `lang="en"` on `<html>` |
| **Responsive text** | No text overflows viewport at any size |

---

## 10. Development Roadmap

### Phase 1 — DISCOVERY ✅ COMPLETE

- [x] Inspect project/environment
- [x] Identify existing architecture
- [x] Identify content requirements from paksa.com.pk
- [x] Produce technical report (this document)
- [x] **Awaiting approval to proceed**

### Phase 2 — FOUNDATION (Next)

- [ ] Create theme folder structure
- [ ] Create `style.css`, `functions.php`, `index.php`
- [ ] Implement `theme.json` (design tokens, settings)
- [ ] Create `assets/css/variables.css` (design tokens)
- [ ] Implement `header.php` / `header/` template parts
- [ ] Implement `footer.php` / `footer/` template parts
- [ ] Setup `functions.php` — theme supports, image sizes, enqueues
- [ ] Implement security foundation (`inc/security.php`)
- [ ] Implement accessibility foundation (`inc/accessibility.php`)
- [ ] Implement performance foundation (`inc/performance.php`)
- [ ] Implement `inc/enqueue.php` — asset loading
- [ ] Setup WordPress Customizer basics

### Phase 3 — COMPONENT LIBRARY

- [ ] Buttons (primary, secondary, outline, ghost, icon)
- [ ] Cards (service, product, blog, testimonial, feature)
- [ ] Section headers
- [ ] Hero variants (standard, split, product, service)
- [ ] Feature grid component
- [ ] Statistics/counter component
- [ ] Tabs component
- [ ] FAQ/accordion component
- [ ] CTA component
- [ ] Process/Timeline component
- [ ] Testimonial slider
- [ ] Technology cards
- [ ] Integration cards
- [ ] Breadcrumbs
- [ ] Pagination
- [ ] Forms (contact, search)
- [ ] Badges
- [ ] Alerts
- [ ] Modal

### Phase 4 — MASTER IT SOLUTIONS TEMPLATE

- [ ] Design section-based architecture
- [ ] Build `page-services.php` master template
- [ ] Create all section template parts
- [ ] Test with dummy content
- [ ] Ensure each section is optional

### Phase 5 — PRODUCT TEMPLATE

- [ ] Design product page architecture
- [ ] Build `single-product.php`
- [ ] Create product-specific sections (modules, features, AI, architecture)
- [ ] Test with Paksa ERP content

### Phase 6 — CONTENT TYPES

- [ ] Register CPTs: Service, Product, Case Study, Technology, Testimonial
- [ ] Register taxonomies: Service Category, Product Category, Industry
- [ ] Setup ACF field groups (if ACF is available)
- [ ] Create admin menu for content management
- [ ] Implement `rewrite` and `has_archive` properly

### Phase 7 — PAGE TEMPLATES

- [ ] `page-contact.php`
- [ ] `page-about.php`
- [ ] `page-products.php` (product archive)
- [ ] `page-industries.php`
- [ ] `page-case-studies.php`
- [ ] Archive templates for CPTs

### Phase 8 — TESTING & OPTIMIZATION

- [ ] Desktop testing (1920px, 1440px, 1280px)
- [ ] Tablet testing (1024px, 768px)
- [ ] Mobile testing (480px, 390px, 360px)
- [ ] Cross-browser testing
- [ ] Accessibility audit
- [ ] Performance optimization
- [ ] Security hardening
- [ ] Create `.pot` translation file

---

## 11. Potential Risks

| Risk | Impact | Mitigation |
|---|---|---|
| **No WordPress installation present** | Cannot test PHP/theme live | Set up local WP environment via Docker/XAMPP before Phase 2 |
| **PHP not available locally** | Cannot run PHP linting | Install PHP or use CI for validation |
| **No existing WordPress DB** | No data to migrate | Build from scratch per requirements.md |
| **Block theme + Classic theme hybrid issues** | Some features may not work in block theme context | Test thoroughly in Phase 2; adjust templates as needed |
| **ACF dependency** | If ACF is not available, field management is harder | Use Customizer + Post Meta as fallback; document ACF requirement |
| **WPDS MCP is experimental** | WordPress Design System MCP may change APIs | Treat WPDS data as guidance, not authoritative |
| **21st.dev API rate limits** | Component searches may be limited | Cache results locally where possible |
| **Brand assets not available** | Logo, colors, fonts may change | Use CSS variables for easy theming |
| **Client content not ready** | Real content may differ from paksa.com.pk | Design for data-driven content, not hard-coded |
| **Theme.json compatibility** | Older WP versions may not support all theme.json features | Target WP 6.1+; provide CSS fallbacks |
| **Mega menu complexity** | Complex dropdowns may have JS/CSS issues | Build incrementally, test each breakpoint |
| **Performance with many sections** | Too many sections may slow page load | Lazy-load non-critical sections; optimize queries |
| **Security in form handling** | Contact forms need CSRF protection | Use WordPress nonces; sanitize all inputs |
| **RTL support** | Pakistan market may need Urdu/RTL | Design with `dir="rtl"` support from start |

---

## 12. Files I Intend to Create or Modify

### New Files (Phase 2 — Foundation)

| File | Purpose |
|---|---|
| `paksa-it-solutions/style.css` | Theme header, version, description |
| `paksa-it-solutions/functions.php` | Theme setup, feature support |
| `paksa-it-solutions/index.php` | Fallback template |
| `paksa-it-solutions/front-page.php` | Homepage template |
| `paksa-it-solutions/header.php` | Site header (includes template parts) |
| `paksa-it-solutions/footer.php` | Site footer (includes template parts) |
| `paksa-it-solutions/screenshot.png` | Theme preview |
| `paksa-it-solutions/theme.json` | Block theme settings, styles, templates |
| `paksa-it-solutions/.gitignore` | **Replace** existing FuelPHP gitignore with WordPress theme gitignore |
| `paksa-it-solutions/inc/setup.php` | Theme setup function |
| `paksa-it-solutions/inc/enqueue.php` | Asset enqueueing |
| `paksa-it-solutions/inc/security.php` | Security headers, hardening |
| `paksa-it-solutions/inc/performance.php` | Performance optimizations |
| `paksa-it-solutions/inc/accessibility.php` | Accessibility enhancements |
| `paksa-it-solutions/inc/template-functions.php` | Template helper functions |
| `paksa-it-solutions/inc/template-tags.php` | Custom template tags |
| `paksa-it-solutions/inc/schema.php` | Structured data (JSON-LD) |
| `paksa-it-solutions/assets/css/main.css` | Main stylesheet |
| `paksa-it-solutions/assets/css/variables.css` | CSS custom properties (design tokens) |
| `paksa-it-solutions/assets/css/animations.css` | Keyframes and animation rules |
| `paksa-it-solutions/assets/js/main.js` | Main JavaScript (nav, interactions) |
| `paksa-it-solutions/assets/js/animations.js` | Scroll animations (IntersectionObserver) |
| `paksa-it-solutions/assets/js/mobile-nav.js` | Mobile navigation logic |
| `paksa-it-solutions/template-parts/header/site-header.php` | Header markup |
| `paksa-it-solutions/template-parts/header/site-logo.php` | Logo markup |
| `paksa-it-solutions/template-parts/header/mobile-nav.php` | Mobile nav markup |
| `paksa-it-solutions/template-parts/footer/site-footer.php` | Footer markup |
| `paksa-it-solutions/languages/paksa-it-solutions.pot` | Translation file |

### Files to Modify

| File | Current State | Action |
|---|---|---|
| `.gitignore` | FuelPHP template | Replace with WordPress theme gitignore |
| `README.md` | "Paksa WP Theme" | Update with project documentation |
| `requirements.md` | Created by us | Keep as reference, no modification needed |

### Will Create in Phase 3+

All files under `template-parts/`, `templates/`, `inc/admin/` — these will be created as we progress through the phases.

---

## Summary

**Project Status:** Empty WordPress theme development repository — clean slate.

**Immediate Action Required:** Client approval of this discovery report.

**Next Step:** After approval → Phase 2 (Foundation) — Create theme structure, design tokens, header, footer, and base components.

**Environment Requirements Before Development:**
1. Local WordPress installation (WordPress 6.1+)
2. PHP 8.1+
3. MySQL/MariaDB
4. Optionally: Docker via `docker-compose` for local environment
5. ACF plugin (recommended for field management)
6. SFTP access to production server at paksa.com.pk

**Key Principle:** No existing functionality to preserve or modify. This is a ground-up build.

---

**Awaiting client approval to proceed to Phase 2.**
