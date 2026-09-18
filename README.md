# Paksa Theme — Enterprise WordPress Block Theme

A complete visual website framework for technology, software, and service businesses. Built as a native WordPress block theme with full Site Editor support, advanced Gutenberg composition, and a unified design token system.

---

## Overview

| Field | Details |
|---|---|
| **Theme Name** | Paksa IT Solutions |
| **Version** | 1.9.0 |
| **Text Domain** | `paksa-it-solutions` |
| **Requires WordPress** | 6.1+ |
| **Requires PHP** | 7.4+ (8.1+ recommended) |
| **License** | GNU General Public License v2 or later |
| **Theme Type** | Block Theme (FSE / Gutenberg-native) |

---

## Project Structure

```
paksa-it-solutions/
├── style.css                    # Theme header & metadata
├── functions.php                # Theme setup, supports, image sizes (v1.9.0)
├── theme.json                   # Design tokens, block settings, template registration
├── index.php                    # Fallback template
├── front-page.php               # Legacy Customizer homepage
├── header.php / footer.php      # Classic template wrappers
├── single.php / page.php        # Classic fallbacks
├── archive.php / search.php     # Classic fallbacks
├── 404.php / home.php           # Classic fallbacks
├── single-paksa_product.php     # Classic product single
├── single-paksa_service.php     # Classic service single
├── archive-paksa_product.php    # Classic product archive
├── archive-paksa_service.php    # Classic service archive
├── taxonomy-paksa_product_cat.php
├── taxonomy-paksa_service_cat.php
│
├── templates/                   # FSE block templates
│   ├── page.html                # Default page
│   ├── single.html              # Single post
│   ├── archive.html             # Archive
│   ├── home.html                # Blog index
│   ├── search.html              # Search results
│   ├── 404.html                 # 404 page
│   ├── single-paksa_product.html
│   ├── single-paksa_service.html
│   ├── taxonomy-paksa_product_cat.html
│   ├── taxonomy-paksa_service_cat.html
│   ├── paksa-visual-page.html   # Full-width visual page
│   ├── paksa-landing-page.html  # No-header landing page
│   ├── paksa-visual-single.html # Visual single post/product/service
│   ├── paksa-content-index.html # Content index page
│   ├── paksa-product-archive.html
│   └── paksa-service-archive.html
│
├── parts/                       # FSE template parts
│   ├── header.html              # Standard header (logo + nav + CTA)
│   ├── header-minimal.html      # Logo + nav only
│   ├── header-dark.html         # Dark background header
│   ├── header-centered.html     # Centered logo layout
│   ├── footer.html              # Multi-column footer
│   ├── footer-minimal.html      # Single-row minimal footer
│   ├── footer-cta.html          # Footer with CTA band
│   ├── page-hero.html           # Page title hero
│   ├── cta-global.html          # Global CTA band
│   ├── contact-form.html        # Contact form part
│   ├── announcement.html        # Announcement bar
│   └── social-bar.html          # Social links bar
│
├── styles/                      # Global style variations
│   ├── corporate.json
│   ├── creative.json
│   ├── elegant.json
│   ├── minimal.json
│   └── modern.json
│
├── patterns/                    # PHP-registered block patterns (empty dir, patterns in inc/)
│
├── assets/
│   ├── css/
│   │   ├── variables.css        # --pk-* design tokens
│   │   ├── main.css             # Main frontend stylesheet
│   │   ├── components.css       # Reusable component primitives
│   │   ├── blocks.css           # Block styles (shared editor + frontend)
│   │   ├── editor.css           # Editor-only overrides
│   │   ├── animations.css       # Keyframes & animation rules
│   │   ├── style-variations.css # Style variation overrides
│   │   └── [page-specific].css  # archive, home, products, services, contact…
│   └── js/
│       ├── main.js              # Core interactions & navigation
│       ├── mobile-nav.js        # Mobile hamburger menu
│       ├── animations.js        # IntersectionObserver scroll animations
│       ├── editor-blocks.js     # Phase 17 block editor (IIFE)
│       └── editor-phase18.js    # Phase 18 advanced editor controls (3 IIFEs)
│
├── inc/
│   ├── enqueue.php              # Asset enqueueing
│   ├── security.php             # Security headers & hardening
│   ├── performance.php          # Performance optimizations
│   ├── accessibility.php        # WCAG 2.1 AA helpers
│   ├── template-functions.php   # Template helper functions
│   ├── template-tags.php        # Custom template tags
│   ├── customizer.php           # Customizer panels & settings
│   ├── icons.php                # Central SVG icon registry
│   ├── visual-system.php        # Block registration, pattern categories, editor assets
│   ├── editor-controls.php      # Shared block attribute helpers & Phase 18 styles
│   ├── blocks.php               # paksa/section, paksa/testimonial, paksa/cta
│   ├── advanced-builder.php     # Phase 14–17 pattern library (80+ patterns)
│   ├── composition.php          # Phase 19 compositions, query patterns, page starters
│   ├── parts.php                # Header/footer variant Customizer controls
│   ├── style-variations.php     # Style variation registration
│   ├── site-editor.php          # FSE bridge patterns
│   ├── nav-walker.php           # Custom nav walker
│   ├── cpt.php                  # Custom post types
│   ├── service-cpt.php          # Service CPT registration
│   ├── product-meta.php         # Product meta fields
│   ├── service-meta.php         # Service meta fields
│   ├── services-meta.php        # Services listing meta
│   ├── page-meta.php            # Page meta fields
│   ├── products-listing-meta.php
│   ├── contact-form.php         # Secure contact form
│   ├── theme-api.php            # Theme API helpers
│   └── updater.php              # Theme updater
│
├── inc/patterns/                # PHP pattern files (loaded by functions.php)
│   └── [35 pattern files]       # hero, heading, paragraph, services, home sections
│
└── languages/                   # Translation files
```

---

## Design System

### Color Palette

| Token | Name | Hex |
|---|---|---|
| `--pk-primary` | Blue | `#6192f8` |
| `--pk-primary-hover` | Blue Hover | `#4a7ef5` |
| `--pk-secondary` | Dark | `#121619` |
| `--pk-accent-light` | Light Blue | `#eef3fe` |
| `--pk-bg` | White | `#ffffff` |
| `--pk-bg-alt` | Light Gray | `#f8f9fc` |
| `--pk-bg-dark` | Near Black | `#121619` |
| `--pk-text` | Near Black | `#1d1d1d` |
| `--pk-text-secondary` | Gray | `#555f6d` |
| `--pk-text-muted` | Light Gray | `#8a94a0` |
| `--pk-border` | Border | `#e6e8ea` |
| `--pk-success` | Green | `#12b76a` |
| `--pk-warning` | Amber | `#f79009` |
| `--pk-error` | Red | `#f04438` |

### Typography

- **Font Family:** Poppins (with system font fallbacks)
- **Body:** 1rem / line-height 1.7
- **Headings:** 700 weight / line-height 1.15
- **Display:** `clamp(3rem, 5vw + 1rem, 5.5rem)`
- **Fluid sizes:** caption → small → normal → body-large → large → h4 → h3 → h2 → h1 → display

### Spacing

8px grid via `--pk-space-1` through `--pk-space-32`. WordPress spacing presets: 2XS (0.5rem) → 3XL (clamp 5–9rem).

### Layout

| Token | Value |
|---|---|
| `--pk-container` | 1200px |
| `--pk-container-narrow` | 720px |
| `--pk-container-wide` | 1440px |

---

## Custom Blocks

| Block | Description |
|---|---|
| `paksa/section` | Full-width section container with InnerBlocks, bg image, animation, hover, border/shadow controls |
| `paksa/testimonial` | Server-rendered testimonial card with quote, author, rating, avatar |
| `paksa/cta` | Server-rendered CTA with heading, description, variant, layout, bg image, buttons with icons |
| `paksa/icon` | Single icon from the central registry with shape, size, hover |
| `paksa/action` | Accessible button/link with icon from registry |
| `paksa/stat` | Animated counter with icon, prefix, suffix, label |
| `paksa/breadcrumbs` | Dynamic breadcrumb trail using established `paksa_breadcrumbs()` |
| `paksa/related-content` | Dynamic product/service relationship renderer |

---

## Block Styles

### Core blocks extended

| Block | Styles |
|---|---|
| `core/button` | outline, ghost, light, dark, secondary, text-link |
| `core/group` | card, card-dark, surface, glass, bordered, dark, gradient + 10 card variants |
| `core/columns` | grid-2/3/4, sidebar-left/right, feature-row |
| `core/heading` | display, eyebrow, gradient-text, section-heading |
| `core/paragraph` | lead, muted, intro |
| `core/quote` | testimonial, highlight, large |
| `core/image` | rounded, elevated, framed, circle, image-zoom |
| `core/cover` | media-section, hero-overlay |
| `core/list` | icon-list |
| `core/separator` | divider, gradient |
| `core/table` | clean, striped |
| `core/buttons` | centered, stacked |
| `paksa/section` | alt, dark, gradient |
| `paksa/testimonial` | bordered, dark |

### Motion styles (all core/group, core/column, core/image, core/cover)

fade, fade-up, fade-down, fade-left, fade-right, scale, reveal, stagger

---

## Block Variations

9 block variations registered in `editor-phase18.js`:
- `paksa-hero-section`, `paksa-feature-section`, `paksa-split-section`, `paksa-stats-section`
- `paksa-testimonials-section`, `paksa-pricing-section`
- `paksa-feature-card`, `paksa-service-card`, `paksa-team-card`

---

## Templates

| Template | File | Description |
|---|---|---|
| Default Page | `page.html` | Header + page-hero + post-content + global CTA + footer |
| Single Post | `single.html` | Header + hero + meta + featured image + content + nav + footer |
| Archive | `archive.html` | Header + hero + query loop + footer |
| Blog Index | `home.html` | Header + hero + query loop + footer |
| Search | `search.html` | Header + search hero + query loop + footer |
| 404 | `404.html` | Header + error hero + footer |
| Single Product | `single-paksa_product.html` | Header + product hero + featured image + content + related + CTA + footer |
| Single Service | `single-paksa_service.html` | Header + service hero + featured image + content + related + CTA + footer |
| Product Category | `taxonomy-paksa_product_cat.html` | Header + archive hero + product query + CTA + footer |
| Service Category | `taxonomy-paksa_service_cat.html` | Header + archive hero + service query + CTA + footer |
| Visual Page | `paksa-visual-page.html` | Full-width page with page-hero part |
| Landing Page | `paksa-landing-page.html` | Header + full-width post-content + footer (no hero) |
| Visual Single | `paksa-visual-single.html` | Visual single for posts, products, services |
| Content Index | `paksa-content-index.html` | Page title + query loop |
| Product Archive | `paksa-product-archive.html` | Product archive with breadcrumbs |
| Service Archive | `paksa-service-archive.html` | Service archive with breadcrumbs |

---

## Template Parts

| Part | File | Description |
|---|---|---|
| Header — Standard | `header.html` | Logo + nav + CTA button |
| Header — Minimal | `header-minimal.html` | Logo + nav only |
| Header — Dark | `header-dark.html` | Dark background header |
| Header — Centered | `header-centered.html` | Centered logo, nav left, actions right |
| Footer — Multi-column | `footer.html` | Brand + nav + contact + social + bottom bar |
| Footer — Minimal | `footer-minimal.html` | Single-row logo + nav + copyright |
| Footer — With CTA | `footer-cta.html` | CTA band + social + copyright |
| Page Hero | `page-hero.html` | Breadcrumbs + post title + excerpt |
| Global CTA | `cta-global.html` | Reusable CTA band |
| Contact Form | `contact-form.html` | Secure contact form part |
| Announcement | `announcement.html` | Top announcement bar |
| Social Bar | `social-bar.html` | Social links bar |

---

## Pattern Library

100+ patterns across 25 categories:

| Category | Examples |
|---|---|
| Paksa Heroes | Classic, Split, Dark, Gradient, Centered, Statistics, Cards, Trust, Video, Product Focus, Service Focus |
| Paksa Features | Four-column, Image+Detail, Alternating, Icon Grid |
| Paksa About | Story, Values, Image+Text, Statistics |
| Paksa Services | Card Grid, Featured, Comparison, Process |
| Paksa Products | Grid, Hero, Features, Benefits |
| Paksa Testimonials | Block Grid, Slider |
| Paksa Pricing | Cards, Three Tiers |
| Paksa FAQ | Accordion, Two-column, Cards, Sidebar |
| Paksa CTA | Simple, Split, Dark, Gradient, Icons, Image, Multiple Actions, Block variants |
| Paksa Contact | Form+Info, Map, Cards, Newsletter |
| Paksa Blog | Featured, Query Grid, Latest Live |
| Paksa Stats | Metric Grid |
| Paksa Process | Numbered Steps, Timeline |
| Paksa Team | Grid |
| Paksa Case Studies | Cards |
| Paksa Query Loops | Posts 2/3-col, Products 2/3-col, Services 2/3-col |
| Paksa Single | Product composition, Service composition, Related content |
| Paksa Page Starters | About, Contact, Services, Products, Blog |
| Paksa Template Parts | All 4 header + all 3 footer + CTA + Announcement |
| Paksa Headers | Navigation with CTA |
| Paksa Footers | Minimal, With CTA |
| Paksa Navigation | Dynamic page list, With CTA button |

---

## Style Variations

| Variation | Description |
|---|---|
| Corporate | Deep navy, formal typography |
| Creative | Vibrant accent, expressive layout |
| Elegant | Serif headings, refined spacing |
| Minimal | Reduced color, maximum whitespace |
| Modern | Default — blue primary, Poppins |

---

## Custom Post Types

| CPT | Slug | Taxonomy |
|---|---|---|
| Products & Solutions | `paksa_product` | `paksa_product_cat` |
| Services | `paksa_service` | `paksa_service_cat` |

---

## Theme Features

### Core WordPress Supports
- `title-tag`, `post-thumbnails`, `html5`
- `custom-logo` (200×60, flex)
- `align-wide`, `editor-styles`, `editor-color-palette`, `wp-block-styles`
- `block-templates`, `block-template-parts`

### Navigation Menus
- Primary, Footer, Footer Solutions, Footer Products, Footer Resources, Footer Legal

### Custom Image Sizes
| Name | Dimensions |
|---|---|
| `paksa-thumb` | 375×250 (cropped) |
| `paksa-medium` | 768×512 (cropped) |
| `paksa-large` | 1280×720 (cropped) |

### Security (`inc/security.php`)
- HTTP security headers: `X-Content-Type-Options`, `X-Frame-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`
- WordPress version hidden, XML-RPC disabled, oEmbed removed
- `DISALLOW_FILE_EDIT`, `FORCE_SSL_ADMIN`

### Performance (`inc/performance.php`)
- Native lazy loading + async decoding on all images
- Emoji scripts disabled, DNS prefetch deduplication
- `type="text/javascript"` removed from script tags

### Accessibility (`inc/accessibility.php`)
- Skip-to-content link, paginated title support
- WCAG 2.1 AA target (4.5:1 contrast, visible focus indicators)
- All animations respect `prefers-reduced-motion`

### JavaScript (Vanilla, no jQuery)
- `main.js` — navigation, interactions
- `mobile-nav.js` — hamburger menu with nested sub-menu support
- `animations.js` — IntersectionObserver scroll animations
- `editor-blocks.js` — Phase 17 block editor registrations
- `editor-phase18.js` — Phase 18 advanced editor (section, testimonial, CTA with 5–8 control panels each)
- All scripts loaded with `defer`

---

## Editor Controls (Phase 18)

Every custom block has organized sidebar panels:

### paksa/section (5 panels)
Layout, Background Image, Animation, Hover & Interaction, Border & Shadow

### paksa/testimonial (7 panels)
Quote Content, Appearance, Rating, Avatar, Hover & Interaction, Border & Shadow

### paksa/cta (8 panels)
Content, Appearance, Primary Button, Secondary Button, Background Image, Animation, Border & Shadow

### Shared attribute helpers (`inc/editor-controls.php`)
- `paksa_hover_attributes()` — hoverEffect, hoverShadow, hoverLift, transition
- `paksa_bg_image_attributes()` — bgImageUrl, position, size, overlay color/opacity
- `paksa_border_shadow_attributes()` — borderWidth, borderStyle, borderColor, borderRadius, shadowPreset
- `paksa_responsive_attributes()` — colsMobile, colsTablet, colsDesktop, stackMobile
- `paksa_typography_attributes()` — textTransform, letterSpacing, fontWeight

---

## Responsive Breakpoints

| Breakpoint | Width |
|---|---|
| Mobile | < 640px |
| Tablet | 640px – 1023px |
| Desktop | 1024px – 1279px |
| Large Desktop | 1280px+ |

---

## Performance Targets

| Metric | Target |
|---|---|
| Lighthouse Performance | 95+ |
| Lighthouse Accessibility | 95+ |
| Lighthouse Best Practices | 95+ |
| Lighthouse SEO | 95+ |
| Largest Contentful Paint | < 2.5s |
| Cumulative Layout Shift | < 0.1 |
| Total Blocking Time | < 200ms |

---

## Development Roadmap

| Phase | Status | Description |
|---|---|---|
| Phase 1 — Discovery | ✅ Complete | Project analysis, architecture planning |
| Phase 2 — Foundation | ✅ Complete | Theme structure, design tokens, header/footer |
| Phase 3 — Components | ✅ Complete | Buttons, cards, hero, sections, forms |
| Phase 4 — Service Templates | ✅ Complete | Service CPT, templates, meta |
| Phase 5 — Product Templates | ✅ Complete | Product CPT, templates, meta |
| Phase 6 — Content Types | ✅ Complete | CPTs, taxonomies, relationships |
| Phase 7 — Page Templates | ✅ Complete | Contact, About, Case Studies, Archive pages |
| Phase 8 — Testing & Optimization | ✅ Complete | Cross-browser, accessibility, performance |
| Phase 9 — Customizer | ✅ Complete | Global settings, header/footer variants |
| Phase 10 — Navigation | ✅ Complete | Multi-level nav, mobile menu, walker |
| Phase 11 — Contact & WhatsApp | ✅ Complete | Secure form, WhatsApp FAB |
| Phase 12 — SEO & Schema | ✅ Complete | Schema.org, meta, Open Graph |
| Phase 13 — Security & Performance | ✅ Complete | Headers, lazy load, emoji disable |
| Phase 14 — Visual System | ✅ Complete | Block styles, patterns, icon registry, FSE parts |
| Phase 15 — Style Variations | ✅ Complete | 5 global style variations |
| Phase 16 — Advanced Patterns | ✅ Complete | About, pricing, blog, newsletter, footer patterns |
| Phase 17 — Custom Blocks | ✅ Complete | paksa/section, paksa/testimonial, paksa/cta |
| Phase 18 — Advanced Editor | ✅ Complete | Editor controls, hover system, bg image, block variations |
| Phase 19 — Full-site Composition | ✅ Complete | All FSE templates, header/footer variants, query patterns, page starters |

---

## Local Development Setup

### Requirements
- WordPress 6.1+
- PHP 8.1+
- MySQL 5.7+ / MariaDB 10.3+
- [ACF (Advanced Custom Fields)](https://www.advancedcustomfields.com/) plugin (recommended)

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/paksaitsolutions/Paksa-WP-Theme.git
   ```

2. Copy the `paksa-it-solutions/` folder into your WordPress installation:
   ```
   wp-content/themes/paksa-it-solutions/
   ```

3. Activate the theme from **Appearance → Themes**.

4. Install and activate the **ACF** plugin for custom field support.

### Recommended Local Environment
- [LocalWP](https://localwp.com/) or [XAMPP](https://www.apachefriends.org/) or Docker

---

## License

GNU General Public License v2 or later — see [LICENSE](./LICENSE)
