# Paksa IT Solutions — Components Documentation

## Buttons

### Available Variants

| Class | Description | Example |
|---|---|---|
| `.btn` | Base button class (required) | — |
| `.btn-primary` | High-emphasis CTA | Primary action |
| `.btn-secondary` | Accent CTA | Secondary action |
| `.btn-outline` | Bordered CTA | Outline action |
| `.btn-text` | Minimal text action | Text link with hover |
| `.btn:disabled` | Disabled state | All variants |

### States

All buttons support `:hover`, `:focus-visible`, `:active`, and `:disabled` states.

### Usage

```html
<a href="#" class="btn btn-primary">Get Started</a>
<button class="btn btn-secondary">Submit</button>
<a href="#" class="btn btn-outline">Learn More</a>
```

---

## Cards

### Available Variants

| Class | Description |
|---|---|
| `.card` | Basic card with border |
| `.card-variant-elevated` | Card with shadow, lift on hover |
| `.card-variant-dark` | Dark-themed card |

### Card Content Structure

```html
<article class="card card-variant-elevated">
    <h3 class="card-title">Title</h3>
    <p class="card-description">Description text</p>
    <a href="#" class="btn btn-primary">Action</a>
</article>
```

### Components Using Cards

- Feature cards
- Service cards
- Product cards
- Industry cards
- Technology cards
- Testimonial cards
- Integration cards

---

## Section Header

### Structure

```html
<header class="section-header">
    <span class="eyebrow">Section Label</span>
    <h2>Section Heading</h2>
    <p>Supporting description text.</p>
</header>
```

### Alignment

- `.section-header` — Centered (default)
- `.section-header.align-left` — Left-aligned

---

## Global CTA

### Structure

```html
<section class="cta-global">
    <h2>Ready to Transform Your Business?</h2>
    <p>Let's discuss how technology can help you improve operations.</p>
    <a href="#" class="btn btn-primary">Get a Free Consultation</a>
    <a href="#" class="btn btn-outline">Discuss Your Project</a>
</section>
```

---

## Site Header

### Structure

```html
<header class="site-header">
    <div class="container header-inner">
        <a href="/" class="site-logo">Logo</a>
        <nav class="main-nav">Desktop menu</nav>
        <div class="nav-cta">CTA button</div>
        <button class="menu-toggle" aria-controls="mobile-nav" aria-expanded="false" aria-label="Menu">Menu</button>
    </div>
</header>

<nav class="mobile-nav" id="mobile-nav" aria-label="Mobile navigation">
    <div class="mobile-nav-header">
        <a href="/" class="site-logo">Logo</a>
        <button class="mobile-nav-close" aria-label="Close menu">Close</button>
    </div>
    <div class="mobile-nav-list">Navigation links</div>
    <div class="mobile-nav-cta">CTA button</div>
</nav>
```

### JavaScript

- `main.js` — Header scroll state, js class injection
- `mobile-nav.js` — Mobile menu toggle, focus trapping, ESC to close, aria-expanded sync

---

## Site Footer

### Structure

```html
<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            <a href="/" class="site-logo">Logo</a>
            <p>Tagline</p>
            <div class="footer-social">Social links</div>
        </div>
        <div class="footer-column">
            <h3 class="footer-heading">Company</h3>
            <nav class="footer-links">Links</nav>
        </div>
        <!-- More columns -->
    </div>
    <div class="container footer-bottom">
        <p>Copyright notice</p>
        <nav class="footer-bottom-links">Legal links</nav>
    </div>
</footer>
```

---

## Typography Components

| Class | Element |
|---|---|
| `.display` | Display heading |
| `.eyebrow` | Small uppercase label |
| `.body` | Standard body text |
| `.body-large` | Larger body text |
| `.body-small` | Smaller body text |
| `.caption` | Small caption text |

---

## Grid Components

| Class | Description | Breakpoint |
|---|---|---|
| `.grid` | Base grid container | — |
| `.grid-2` | 2 columns | 768px+ |
| `.grid-3` | 3 columns | 768px+ |
| `.grid-4` | 4 columns | 1024px+ (2 on tablet) |
| `.grid-6` | 6 columns | 1280px+ (3 on tablet, 6 on desktop) |

---

## Section Classes

| Class | Description |
|---|---|
| `.section` | Standard section padding |
| `.section-alt` | Alternating background |
| `.section-dark` | Dark background section |
