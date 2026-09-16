# Paksa IT Solutions — Services Sections Guide

## Overview

Comprehensive services section system with 12 block patterns covering all common services page layouts. All sections are fully customizable, reusable across different industries, and built with modern design principles.

## Pattern Categories

| Category | Slug | Patterns |
|---|---|---|
| **Paksa Hero** | `paksa-hero` | 6 patterns |
| **Paksa Headings** | `paksa-headings` | 4 patterns |
| **Paksa Paragraphs** | `paksa-paragraphs` | 4 patterns |
| **Paksa Services** | `paksa-services` | 12 patterns |

## Services Block Patterns

### 1. Services Grid

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/services-grid` |
| Category | `paksa-services` |
| Use case | 6-card grid with icons, titles, descriptions, links |
| Icons | 6 inline SVGs (monitor, AI, code, cloud, integration, ecommerce) |
| Layout | Responsive grid: 1 col → 2 col → 3 col |

**Use for:** Standard services overview page, portfolio listings, capability pages.

---

### 2. Services Process

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/services-process` |
| Category | `paksa-services` |
| Use case | 5-step methodology with icons and numbered badges |
| Icons | 5 inline SVGs (search, design, code, check, refresh) |
| Layout | Responsive: 1 → 2 → 3 columns |

**Use for:** How we work pages, methodology pages, onboarding flows.

---

### 3. Services Tabs

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/services-tabs` |
| Category | `paksa-services` |
| Use case | Tabbed service categories with icon buttons |
| Tabs | 3 tabs (Software, AI & Data, Cloud) |
| Content per tab | Heading, description, feature list with checkmarks |

**Use for:** Service category pages, product feature pages.

---

### 4. Services Features

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/services-features` |
| Category | `paksa-services` |
| Use case | Feature checklist with icons in 2-column layout |
| Icons | Checkmark SVG in accent-light boxes |
| Layout | Responsive: 1 → 2 columns |

**Use for:** Why choose us, capabilities, differentiators.

---

### 5. Services Stats

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/services-stats` |
| Category | `paksa-services` |
| Use case | Statistics display with icons and counters |
| Icons | People, clock, gauge, support SVG |
| Layout | Responsive: 2 → 4 columns |
| Background | Dark section |

**Use for:** About pages, credibility sections, social proof.

---

### 6. Services CTA

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/services-cta` |
| Category | `paksa-services` |
| Use case | Gradient CTA with heading, description, buttons |
| Background | Primary gradient |
| Buttons | Primary + Outline |

**Use for:** Conversion sections, contact pages, end-of-page CTAs.

---

### 7. Services Categories

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/services-categories` |
| Category | `paksa-services` |
| Use case | Category cards with icon, title, description, count |
| Icons | 4 inline SVGs |
| Layout | 4-column grid |

**Use for:** Service catalog, directory pages.

---

### 8. Services Categories Grid

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/services-categories-grid` |
| Category | `paksa-services` |
| Use case | Compact 4-column category grid |
| Layout | 4-column grid with tight spacing |

**Use for:** Compact service listings, sidebar widgets.

---

### 9. Service Detail

| Property | Value |
|---|---|
| Slug | `paksa-it-solutions/service-detail` |
| Category | `paksa-services` |
| Use case | Single service showcase with icon, heading, features |
| Sections | Hero + Feature list |
| Icons | Monitor SVG (hero) + Checkmarks (features) |

**Use for:** Individual service pages, detailed service descriptions.

---

## CSS Classes Reference

### Card System

| Class | Purpose |
|---|---|
| `.pk-svc-grid` | Card grid container |
| `.pk-svc-grid-4` | 4-column modifier |
| `.pk-svc-card` | Individual service card |
| `.pk-svc-card-icon` | Icon wrapper (56×56, accent-light bg) |
| `.pk-svc-card-title` | Card title (1.25rem, 600) |
| `.pk-svc-card-desc` | Card description (0.9375rem) |
| `.pk-svc-card-link` | Learn more link with arrow |
| `.pk-svc-card-highlight` | Gradient primary bg variant |
| `.pk-svc-card-elevated` | Shadow variant |

### Tab System

| Class | Purpose |
|---|---|
| `.pk-svc-tabs` | Tab container (2-col grid) |
| `.pk-svc-tabs-nav` | Tab button column |
| `.pk-svc-tab-btn` | Individual tab button |
| `.pk-svc-tab-btn.is-active` | Active tab style |
| `.pk-svc-tab-btn-icon` | Icon inside tab button |
| `.pk-svc-tab-panel` | Tab content panel |
| `.pk-svc-tab-panel.is-active` | Active panel display |

### Process System

| Class | Purpose |
|---|---|
| `.pk-svc-process-steps` | Steps grid container |
| `.pk-svc-step` | Individual step |
| `.pk-svc-step-icon` | Icon circle (72×72, accent-light) |
| `.pk-svc-step-number` | Number badge (overlapping) |
| `.pk-svc-step-title` | Step title |
| `.pk-svc-step-desc` | Step description |

### Features System

| Class | Purpose |
|---|---|
| `.pk-svc-features` | Features grid |
| `.pk-svc-feature` | Individual feature row |
| `.pk-svc-feature-icon` | Icon box (40×40) |
| `.pk-svc-feature-title` | Feature title |
| `.pk-svc-feature-desc` | Feature description |

### Stats System

| Class | Purpose |
|---|---|
| `.pk-svc-stats` | Stats grid (2→4 cols) |
| `.pk-svc-stat` | Individual stat |
| `.pk-svc-stat-icon` | Icon box (48×48) |
| `.pk-svc-stat-value` | Large number (clamp 2rem-2.5rem) |
| `.pk-svc-stat-label` | Description label |

### Category System

| Class | Purpose |
|---|---|
| `.pk-svc-category` | Category card |
| `.pk-svc-category-icon` | Icon box (48×48) |
| `.pk-svc-category-title` | Category title |
| `.pk-svc-category-desc` | Category description |
| `.pk-svc-category-count` | Project count badge |

### CTA System

| Class | Purpose |
|---|---|
| `.pk-svc-cta` | CTA section (gradient, rounded) |

## Icon System

All icons use inline SVG with consistent attributes:

```html
<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <!-- SVG paths -->
</svg>
```

### Icon Sizes by Context

| Context | Width | Height |
|---|---|---|
| Card icon | 28px | 28px |
| Tab icon | 18px | 18px |
| Step icon | 32px | 32px |
| Feature icon | 20px | 20px |
| Stat icon | 24px | 24px |
| Category icon | 24px | 24px |
| Arrow icon | 16px | 16px |
| Checkmark | 18px | 18px |

## Animation System

All patterns use the existing animation system:

| Animation | Class | Data Attribute |
|---|---|---|
| Fade up | `.pk-animate-on-scroll` | `data-anim="fade-up"` |
| Fade in | `.pk-animate-on-scroll` | `data-anim="fade-in"` |
| Scale in | `.pk-animate-on-scroll` | `data-anim="scale-in"` |
| Slide right | `.pk-animate-on-scroll` | `data-anim="slide-right"` |

### Stagger Delays

Patterns use incremental delays:
- Grid cards: `data-delay="0"`, `"100"`, `"200"`, `"300"`, etc.
- Steps: `data-delay="0"`, `"100"`, `"200"`, etc.
- Section headers: `data-delay="0"`, `"100"`, `"200"`

## Reusability Guide

### For Any Industry

All patterns use generic placeholder content. To customize:

1. **Insert the pattern** into any page/post via the block editor
2. **Edit the text** directly — all headings, descriptions, and labels are editable
3. **Update links** — all `href` values use placeholder `#` URLs
4. **Replace icons** — inline SVGs can be swapped for any icon set

### Layout Switching

The `template-parts/services/page.php` template supports layout switching via Customizer options:

| Layout Option | Description |
|---|---|
| `grid` | Card grid (default) |
| `tabs` | Tabbed interface |
| `process` | Step-by-step process |
| `list` | Simple list |

### Column Configuration

Grid columns configurable via Customizer:

| Option | Values | Default |
|---|---|---|
| `paksa_services_columns` | 2, 3, 4 | 3 |

## Customizer Integration

All services section settings flow through `paksa_get_option()`:

| Option | Default | Description |
|---|---|---|
| `paksa_services_eyebrow` | "Our Services" | Section eyebrow text |
| `paksa_services_heading` | "What We Do" | Section heading |
| `paksa_services_description` | "Enterprise technology solutions..." | Section description |
| `paksa_services_layout` | "grid" | Layout type |
| `paksa_services_columns` | "3" | Number of grid columns |
| `paksa_services_items` | (empty) | Dynamic items via filter |

## Adding New Service Patterns

1. Create `patterns/services-{name}.php` in the patterns directory
2. Use `register_block_pattern('paksa-it-solutions/services-{name}', ...)`
3. Assign to `paksa-services` category
4. Add to `$pattern_files` array in `functions.php`
5. Follow icon system: inline SVG with `currentColor` stroke
6. Use animation classes: `.pk-animate-on-scroll` + `data-anim` + `data-delay`
7. Use CSS classes from the services CSS system
8. Add documentation to this guide

## Responsive Breakpoints

All services patterns follow the existing responsive system:

| Breakpoint | Behavior |
|---|---|
| < 640px | 1 column, reduced padding |
| 640px–1023px | 2 columns (grids), horizontal tabs |
| 1024px+ | 3-4 columns, side-by-side tabs |
| 1280px+ | Full layout with all animations |

## Accessibility

All patterns include:
- Proper ARIA labels on tab buttons (`role="tab"`, `aria-selected`, `aria-controls`)
- Semantic HTML (`<section>`, `<article>`, `<nav>`)
- `aria-hidden="true"` on decorative icons
- `aria-labelledby` on tab panels
- Focus-visible styles on interactive elements
- Reduced motion support via `prefers-reduced-motion`
