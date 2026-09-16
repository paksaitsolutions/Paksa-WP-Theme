# Paksa IT Solutions — WordPress Theme

A custom enterprise-grade WordPress block theme for [Paksa IT Solutions](https://paksa.com.pk) — an AI/ML, Data Science, and Software Development company based in Lahore, Pakistan.

---

## Overview

| Field | Details |
|---|---|
| **Theme Name** | Paksa IT Solutions |
| **Version** | 1.0.0 |
| **Text Domain** | `paksa-it-solutions` |
| **Requires WordPress** | 6.1+ |
| **Requires PHP** | 7.4+ (8.1+ recommended) |
| **License** | GNU General Public License v2 or later |
| **Theme Type** | Block Theme (Gutenberg-native) |

---

## Project Structure

```
paksa-it-solutions/
├── style.css                  # Theme header & metadata
├── functions.php              # Theme setup, supports, image sizes
├── theme.json                 # Design tokens, block settings & styles
├── index.php                  # Fallback template
├── front-page.php             # Homepage template
├── header.php / footer.php    # Site header/footer wrappers
├── single.php                 # Single post template
├── page.php                   # Default page template
├── archive.php                # Archive template
├── search.php                 # Search results template
├── 404.php                    # 404 error page
├── home.php                   # Blog index template
│
├── assets/
│   ├── css/
│   │   ├── variables.css      # CSS custom properties (design tokens)
│   │   ├── main.css           # Main stylesheet
│   │   └── animations.css     # Keyframes & animation rules
│   ├── js/
│   │   ├── main.js            # Core interactions & navigation
│   │   ├── mobile-nav.js      # Mobile hamburger menu logic
│   │   └── animations.js      # Scroll-triggered animations (IntersectionObserver)
│   ├── images/                # Theme images & logos
│   └── icons/                 # SVG icons
│
├── inc/
│   ├── enqueue.php            # CSS/JS asset enqueueing
│   ├── security.php           # Security headers & hardening
│   ├── performance.php        # Performance optimizations
│   ├── accessibility.php      # WCAG 2.1 AA accessibility helpers
│   ├── template-functions.php # Template helper functions
│   └── template-tags.php      # Custom template tags
│
├── header/
│   ├── site-header.php        # Main header markup
│   └── header-styles.css      # Header-specific styles
│
├── footer/
│   ├── site-footer.php        # Main footer markup
│   └── footer-styles.css      # Footer-specific styles
│
├── templates/                 # Custom page templates
├── parts/                     # Block template parts
├── patterns/                  # Block patterns
├── styles/                    # Global style variations
└── languages/                 # Translation files (.pot, .po, .mo)
```

---

## Design System

### Color Palette

| Token | Color | Hex |
|---|---|---|
| Primary | Deep Navy | `#1a365d` |
| Primary Hover | Lighter Navy | `#2a4a7f` |
| Secondary | Royal Blue | `#2b6cb0` |
| Accent | Cyan | `#00b5d8` |
| Background | White | `#ffffff` |
| Background Alt | Light Gray | `#f7fafc` |
| Background Dark | Dark | `#1a202c` |
| Text | Near-black | `#1a202c` |
| Text Secondary | Gray | `#4a5568` |
| Text Muted | Light Gray | `#718096` |
| Success | Green | `#38a169` |
| Warning | Amber | `#d69e2e` |
| Error | Red | `#e53e3e` |

### Typography

- **Font Family:** Inter (with system font fallbacks)
- **Body:** 1rem / line-height 1.7
- **Headings:** 700 weight / line-height 1.15
- **Display:** `clamp(2.5rem, 5vw, 4rem)`

### Layout

| Token | Value |
|---|---|
| Content Width | 1280px |
| Wide Width | 1440px |
| Narrow Width | 720px |

---

## Theme Features

### Core WordPress Supports
- `title-tag`, `post-thumbnails`, `html5`
- `custom-logo` (200×60, flex)
- `align-wide`, `editor-styles`, `editor-color-palette`, `wp-block-styles`

### Navigation Menus
- **Primary** — Main header navigation
- **Footer** — Footer links
- **Social** — Social media links

### Custom Image Sizes
| Name | Dimensions |
|---|---|
| `paksa-thumb` | 375×250 (cropped) |
| `paksa-medium` | 768×512 (cropped) |
| `paksa-large` | 1280×720 (cropped) |

### Security (`inc/security.php`)
- HTTP security headers: `X-Content-Type-Options`, `X-Frame-Options`, `X-XSS-Protection`, `Referrer-Policy`, `Permissions-Policy`
- WordPress version hidden from public
- XML-RPC disabled
- oEmbed discovery links removed
- File editing disabled in dashboard (`DISALLOW_FILE_EDIT`)
- SSL forced for admin (`FORCE_SSL_ADMIN`)
- Basic login failure tracking

### Performance (`inc/performance.php`)
- Native lazy loading (`loading="lazy"`) and async decoding on all images
- Emoji scripts disabled
- DNS prefetch deduplication
- `type="text/javascript"` removed from script tags

### Accessibility (`inc/accessibility.php`)
- Skip-to-content link
- Paginated title support
- Body class helpers for search results and paged views
- WCAG 2.1 AA target (4.5:1 contrast, visible focus indicators)

### JavaScript (Vanilla, no jQuery)
- `main.js` — navigation, interactions
- `mobile-nav.js` — hamburger menu with nested sub-menu support
- `animations.js` — scroll-triggered animations via `IntersectionObserver`
- All scripts loaded with `defer`, respects `prefers-reduced-motion`

---

## Site Architecture

### Pages & Templates

| Page | Template |
|---|---|
| Homepage | `front-page.php` |
| Blog Index | `home.php` |
| Default Page | `page.php` |
| Single Post | `single.php` |
| Archive | `archive.php` |
| Search Results | `search.php` |
| 404 | `404.php` |

### Navigation Structure

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

---

## Development Roadmap

| Phase | Status | Description |
|---|---|---|
| Phase 1 — Discovery | ✅ Complete | Project analysis, architecture planning |
| Phase 2 — Foundation | 🔄 In Progress | Theme structure, design tokens, header/footer |
| Phase 3 — Components | ⏳ Pending | Buttons, cards, hero, sections, forms |
| Phase 4 — Service Templates | ⏳ Pending | Master IT solutions page template |
| Phase 5 — Product Templates | ⏳ Pending | Product/solution page templates |
| Phase 6 — Content Types | ⏳ Pending | CPTs, taxonomies, ACF field groups |
| Phase 7 — Page Templates | ⏳ Pending | Contact, About, Case Studies, Archive pages |
| Phase 8 — Testing & Optimization | ⏳ Pending | Cross-browser, accessibility, performance audit |

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

3. Activate the theme from **Appearance → Themes** in the WordPress admin.

4. Install and activate the **ACF** plugin for custom field support.

### Recommended Local Environment
- [LocalWP](https://localwp.com/) or [XAMPP](https://www.apachefriends.org/) or Docker

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

## Browser & Device Support

| Breakpoint | Width |
|---|---|
| Mobile | < 640px |
| Tablet | 640px – 1023px |
| Desktop | 1024px – 1279px |
| Large Desktop | 1280px+ |

---

## Company

**Paksa IT Solutions**
- Address: PIA Housing Society, Lahore, Pakistan
- Email: info@paksa.com.pk / sales@paksa.com.pk
- Phone: +92 305 7772572
- Website: [paksa.com.pk](https://paksa.com.pk)

---

## License

GNU General Public License v2 or later — see [LICENSE](./LICENSE)
