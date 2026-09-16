# Paksa IT Solutions — Design System Documentation

## Color System

### Primary Colors

| Token | Hex | Usage |
|---|---|---|
| `--pk-primary` | `#1a365d` | Primary buttons, headings, logo |
| `--pk-primary-hover` | `#2a4a7f` | Hover states |
| `--pk-primary-active` | `#0d1f3c` | Active/pressed states |

### Secondary Colors

| Token | Hex | Usage |
|---|---|---|
| `--pk-secondary` | `#2b6cb0` | Links, secondary accents |
| `--pk-secondary-hover` | `#2c5282` | Link hover states |

### Accent Color

| Token | Hex | Usage |
|---|---|---|
| `--pk-accent` | `#00b5d8` | CTAs, active nav, highlights, icons, metrics |
| `--pk-accent-hover` | `#0097b5` | Accent hover |
| `--pk-accent-active` | `#007a94` | Accent active |
| `--pk-accent-light` | `#e6f9fd` | Accent backgrounds, tints |

### Background Colors

| Token | Hex | Usage |
|---|---|---|
| `--pk-bg` | `#ffffff` | Primary background |
| `--pk-bg-alt` | `#f7fafc` | Alternating sections |
| `--pk-bg-dark` | `#1a202c` | Dark sections, footer |
| `--pk-bg-dark-alt` | `#2d3748` | Dark section alternatives |

### Surface Colors

| Token | Hex | Usage |
|---|---|---|
| `--pk-surface` | `#ffffff` | Card background |
| `--pk-surface-elevated` | `#ffffff` | Elevated elements |
| `--pk-surface-dark` | `#2d3748` | Dark surface |
| `--pk-surface-dark-elevated` | `#374151` | Elevated dark elements |

### Text Colors

| Token | Hex | Usage |
|---|---|---|
| `--pk-text` | `#1a202c` | Primary text |
| `--pk-text-secondary` | `#4a5568` | Secondary text, descriptions |
| `--pk-text-muted` | `#718096` | Captions, muted text |
| `--pk-text-inverse` | `#ffffff` | Text on dark backgrounds |
| `--pk-text-inverse-muted` | `#a0aec0` | Muted text on dark |
| `--pk-text-link` | `#2b6cb0` | Links |
| `--pk-text-link-hover` | `#1a4a7a` | Link hover |

### Border Colors

| Token | Hex | Usage |
|---|---|---|
| `--pk-border` | `#e2e8f0` | Standard borders |
| `--pk-border-strong` | `#cbd5e0` | Stronger borders |
| `--pk-border-dark` | `#4a5568` | Borders on dark bg |

### Semantic Colors

| Token | Hex | Usage |
|---|---|---|
| `--pk-success` | `#38a169` | Success states, positive |
| `--pk-success-bg` | `#f0fff4` | Success background |
| `--pk-warning` | `#d69e2e` | Warning states |
| `--pk-warning-bg` | `#fffff0` | Warning background |
| `--pk-error` | `#e53e3e` | Error states |
| `--pk-error-bg` | `#fff5f5` | Error background |
| `--pk-info` | `#3182ce` | Information states |
| `--pk-info-bg` | `#ebf8ff` | Info background |

---

## Typography

### Typeface

**Inter** (primary) — Modern, clean, highly readable sans-serif.
Fallback: `-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif`

### Hierarchy

| Element | Size (Desktop) | Weight | Line Height | Margin Bottom |
|---|---|---|---|---|
| Display | clamp(2.5rem, 5vw, 4rem) | 700 | 1.1 | 1.5rem |
| H1 | clamp(2rem, 4vw, 3rem) | 700 | 1.1 | 1rem |
| H2 | clamp(1.5rem, 3vw, 2.25rem) | 700 | 1.15 | 1rem |
| H3 | clamp(1.25rem, 2vw, 1.5rem) | 600 | 1.2 | 1rem |
| H4 | 1.125rem | 600 | 1.3 | 1rem |
| Body Large | 1.125rem | 400 | 1.7 | 1rem |
| Body | 1rem | 400 | 1.7 | 1rem |
| Body Small | 0.875rem | 400 | 1.6 | 1rem |
| Eyebrow | 0.75rem | 600 | 1.4 | 1rem |
| Button | 0.9375rem | 600 | 1.4 | — |
| Caption | 0.75rem | 400 | 1.5 | — |

### Responsive Strategy

All headings use `clamp()` for fluid scaling between mobile and desktop. No breakpoint-specific font sizes needed for most text.

---

## Spacing System

Based on **8px grid**. All spacing values derive from this scale.

| Token | Value | Usage |
|---|---|---|
| `--pk-space-1` | 4px | Micro spacing |
| `--pk-space-2` | 8px | Tight spacing |
| `--pk-space-3` | 12px | Small spacing |
| `--pk-space-4` | 16px | Default gap |
| `--pk-space-5` | 20px | Medium spacing |
| `--pk-space-6` | 24px | Section internal gap |
| `--pk-space-8` | 32px | Large gap |
| `--pk-space-10` | 40px | Section padding |
| `--pk-space-12` | 48px | Section padding |
| `--pk-space-16` | 64px | Large section padding |
| `--pk-space-20` | 80px | Hero padding |
| `--pk-space-24` | 96px | Large hero padding |

---

## Container System

| Container | Max Width | Usage |
|---|---|---|
| `.container` | 1280px | Standard content |
| `.container-narrow` | 720px | Reading, text-heavy content |
| `.container-wide` | 1440px | Large layouts |
| `.container-fluid` | 100% | Full-width sections |

---

## Border Radius

| Token | Value | Usage |
|---|---|---|
| `--pk-radius-sm` | 4px | Small elements, nav items |
| `--pk-radius-md` | 8px | Buttons, form inputs |
| `--pk-radius-lg` | 16px | Cards |
| `--pk-radius-xl` | 24px | Large containers, CTA |
| `--pk-radius-full` | 9999px | Pills, badges, circles |

---

## Shadow System

| Token | Value | Usage |
|---|---|---|
| `--pk-shadow-sm` | 0 1px 3px rgba(0,0,0,0.08) | Subtle depth |
| `--pk-shadow-md` | 0 4px 12px rgba(0,0,0,0.1) | Cards, dropdowns |
| `--pk-shadow-lg` | 0 8px 24px rgba(0,0,0,0.12) | Elevated cards, modals |
| `--pk-shadow-xl` | 0 16px 48px rgba(0,0,0,0.16) | Heavy elevation |

---

## Animation System

### Available Animations

| Class | Effect | Duration |
|---|---|---|
| `.pk-animate-fade-up` | Fade + translateY 16px→0 | 500ms |
| `.pk-animate-fade-in` | Opacity 0→1 | 400ms |
| `.pk-animate-scale-in` | Scale 0.95→1 + fade | 400ms |
| `.pk-animate-slide-right` | TranslateX 20px→0 + fade | 500ms |

### Hover Effects

| Class | Effect |
|---|---|
| `.pk-hover-lift` | translateY(-2px) + shadow |
| `.pk-hover-glow` | Accent glow shadow |

### Reduced Motion

All animations respect `prefers-reduced-motion: reduce` via CSS media query. When activated:
- All animation durations become 0.01ms
- No transforms are applied on hover
- Smooth scrolling is disabled

---

## CSS Variables Source

All design tokens are defined in `assets/css/variables.css` and mirrored in `theme.json`. Both files must be updated together when adding new tokens.
