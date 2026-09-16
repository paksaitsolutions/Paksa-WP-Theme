# Paksa IT Solutions — Hero Section Guide

## Overview

The hero section is the first visual element on the homepage and key inner pages. It introduces the company value proposition and primary calls-to-action.

## Available Block Patterns

Four block patterns are registered via `register_block_pattern()` in the `patterns/` directory:

| Pattern | Class | Description |
|---|---|---|
| **Standard** | `pk-hero` | Text left, dashboard visual right (default) |
| **Split** | `pk-hero-split` | Two equal columns — text + image/visual |
| **Dark** | `pk-hero-dark` | Dark background, high-impact entrance |
| **Minimal** | `pk-hero-minimal` | Text-only, reduced padding, smaller heading |

### Pattern Locations

All patterns are in `paksa-it-solutions/patterns/`:

- `patterns/hero-standard.php` — Standard hero with dashboard mockup
- `patterns/hero-split.php` — Split layout with image visual
- `patterns/hero-dark.php` — Dark background variant
- `patterns/hero-minimal.php` — Minimal text-only variant

### Using a Pattern

1. Edit a page or post in the WordPress block editor
2. Open the Inserter (⊕)
3. Search for the pattern name (e.g., "Hero Standard")
4. Click to insert

## Content Source

The homepage hero (`template-parts/home/hero.php`) sources content from **WordPress Customizer**:

| Option | Setting Path | Default |
|---|---|---|
| `paksa_hero_eyebrow` | Customizer → Homepage → Hero | "Enterprise Technology Solutions" |
| `paksa_hero_heading` | Customizer → Homepage → Hero | "Technology That Moves Business Forward" |
| `paksa_hero_subheading` | Customizer → Homepage → Hero | "Build Smarter.\nOperate Better.\nGrow With Confidence." |
| `paksa_hero_description` | Customizer → Homepage → Hero | Description text |
| `paksa_hero_cta_primary_text` | Customizer → Homepage → Hero | "Get a Free Consultation" |
| `paksa_hero_cta_primary_url` | Customizer → Homepage → Hero | "#contact" |
| `paksa_hero_cta_secondary_text` | Customizer → Homepage → Hero | "Explore Our Solutions" |
| `paksa_hero_cta_secondary_url` | Customizer → Homepage → Hero | "#solutions" |

## CSS Classes

### Primary Hero (`.pk-hero`)

| Class | Purpose |
|---|---|
| `.pk-hero` | Main hero section wrapper |
| `.pk-hero-inner` | Grid container for content + visual |
| `.pk-hero-content` | Text content area |
| `.pk-hero-heading` | H1 heading |
| `.pk-hero-subheading` | Subheading (supports multi-line) |
| `.pk-hero-description` | Body description text |
| `.pk-hero-actions` | Button container |
| `.pk-hero-visual` | Right-side visual area |

### Dashboard Visual (`.pk-hero-dashboard`)

| Class | Purpose |
|---|---|
| `.pk-hero-dashboard` | Dashboard mockup wrapper |
| `.pk-dash-header` | Window header bar |
| `.pk-dash-dots` | Traffic light dots (red/yellow/green) |
| `.pk-dash-title` | Window title |
| `.pk-dash-body` | Dashboard body grid |
| `.pk-dash-sidebar` | Left navigation sidebar |
| `.pk-dash-nav-item` | Individual sidebar item |
| `.pk-dash-main` | Main content area |
| `.pk-dash-metrics` | Metrics grid container |
| `.pk-dash-metric` | Individual metric card |
| `.pk-dash-metric-label` | Metric label bar |
| `.pk-dash-metric-value` | Metric value bar |
| `.pk-dash-chart` | Chart area |
| `.pk-dash-chart-bars` | Bars container |
| `.pk-dash-bar` | Individual bar (uses `--h` custom property) |
| `.pk-dash-modules` | Modules grid container |
| `.pk-dash-module` | Individual module |
| `.pk-dash-module-icon` | Module icon placeholder |
| `.pk-dash-module-lines` | Module text lines |

### Floating Nodes (`.pk-hero-nodes`)

| Class | Purpose |
|---|---|
| `.pk-hero-nodes` | Floating badges container (desktop only) |
| `.pk-node` | Individual floating badge |
| `.pk-node-ai` | AI badge |
| `.pk-node-bi` | BI badge |
| `.pk-node-erp` | ERP badge |
| `.pk-node-data` | Data badge |

### Variant Modifiers

| Class | Purpose |
|---|---|
| `.pk-hero-dark` | Dark background variant |
| `.pk-hero-split` | Split layout variant |
| `.pk-hero-minimal` | Minimal text-only variant |

### Animation Classes

Hero elements use the animation system:

| Class | Data Attribute | Effect |
|---|---|---|
| `pk-animate-on-scroll` | `data-anim="fade-up"` | Fade in + slide up |
| `pk-animate-on-scroll` | `data-anim="fade-in"` | Fade in |

Use `data-delay="100"` (in ms) to stagger animations.

## Responsive Behavior

| Breakpoint | Behavior |
|---|---|
| < 1024px | Single column, content above visual |
| ≥ 1024px | Two columns (content + visual side by side) |
| ≥ 1280px | Floating nodes appear |
| < 640px | Reduced padding, smaller dashboard |

## Customizer Integration

All hero content is managed via `paksa_get_option()` in `template-parts/home/hero.php`. To change hero content:

1. Go to **Appearance → Customize → Homepage → Hero**
2. Modify any field
3. Changes apply immediately via the preview

## Block Pattern vs Template Part

- **Block patterns** are for the WordPress block editor — insert into pages/posts via the Inserter
- **Template parts** (`template-parts/home/hero.php`) are for PHP-driven homepage sections controlled by Customizer
- Both use the same CSS classes for visual consistency

## Adding Custom Variants

To add a new hero variant:

1. Create `patterns/hero-{name}.php` with `register_block_pattern()`
2. Add CSS for the variant in `assets/css/main.css` (follow existing `.pk-hero-*` naming)
3. Add pattern documentation to this file
4. Update `docs/components.md`

## Performance Notes

- Hero animations are wrapped in progressive enhancement (`.js` class check in `animations.css`)
- Floating nodes (`pk-hero-nodes`) are `display: none` on mobile and below 1280px
- All animations respect `prefers-reduced-motion: reduce`
